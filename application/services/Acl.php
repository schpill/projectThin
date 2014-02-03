<?php
    namespace ThinService;

    class Acl
    {
        public static function check($username, $password, $session)
        {
            $session    = \Thin\Session::instance($session);
            $sql        = new \Thin\Querydata('adminright');
            $users      = \Thin\Data::getAll('adminuser');
            foreach ($users as $user) {
                $user   = \Thin\Data::getIt('adminuser', $user);
                $login  = $user->getLogin();
                $pwd    = $user->getPassword();
                if ($username == $login && sha1($password) == $pwd) {
                    $rights = $sql->where('adminuser = ' . $user->getId())->get();
                    if (count($rights)) {
                        foreach ($rights as $right) {
                            if (!ake($right->getAdmintable()->getName(), \Thin\Data::$_rights)) {
                                \Thin\Data::$_rights[$right->getAdmintable()->getName()] = array();
                            }
                            \Thin\Data::$_rights[$right->getAdmintable()->getName()][$right->getAdminaction()->getName()] = true;
                        }
                    }
                    $session->setUser($user);
                    $session->setRights($rights);
                    return false;
                }
            }
            return true;
        }
    }
