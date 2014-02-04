<?php
    namespace ThinService;
    use Thin\Data;
    use Thin\Querydata;
    use Thin\Session;

    class Acl
    {
        public static function check($username, $password, $session)
        {
            $session    = Session::instance($session);
            $sql        = new Querydata('adminright');
            $users      = Data::getAll('adminuser');
            foreach ($users as $user) {
                $user   = Data::getIt('adminuser', $user);
                $login  = $user->getLogin();
                $pwd    = $user->getPassword();
                if ($username == $login && sha1($password) == $pwd) {
                    $rights = $sql->where('adminuser = ' . $user->getId())->get();
                    if (count($rights)) {
                        foreach ($rights as $right) {
                            if (!ake($right->getAdmintable()->getName(), \Thin\Data::$_rights)) {
                                Data::$_rights[$right->getAdmintable()->getName()] = array();
                            }
                            Data::$_rights[$right->getAdmintable()->getName()][$right->getAdminaction()->getName()] = true;
                        }
                    }
                    $session->setUser($user);
                    $session->setRights($rights);
                    return false;
                }
            }
            return true;
        }

        public static function allRights($email)
        {
            $db = new Querydata('adminuser');
            $res = $db->where('email = ' . $email)->get();
            if (count($res)) {
                $user = $db->first($res);
                $adminTables = Data::getAll('admintable');
                $adminActions = Data::getAll('adminaction');
                foreach ($adminTables as $path) {
                    $adminTable = Data::getIt('admintable', $path);
                    foreach ($adminActions as $pathAction) {
                        $adminAction = Data::getIt('adminaction', $pathAction);
                        $dbRight = new Querydata('adminright');
                        $exists = $dbRight
                        ->where('adminaction = ' . $adminAction->getId())
                        ->whereAnd('adminuser = ' . $user->getId())
                        ->whereAnd('admintable = ' . $adminTable->getId())
                        ->get();
                        if (!count($exists)) {
                            $newRight = array(
                                'adminaction'   => $adminAction->getId(),
                                'adminuser'     => $user->getId(),
                                'admintable'    => $adminTable->getId()
                            );
                            Data::add('adminright', $newRight);
                            Data::getAll('adminright');
                        }
                    }
                }
            } else {
                throw new \Exception("This user $email does not exist.");
            }
        }
    }
