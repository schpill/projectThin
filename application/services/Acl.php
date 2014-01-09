<?php
    namespace ThinService;

    class Acl
    {
        public static function check($username, $password, $session)
        {
            $session = \Thin\Session::instance($session);
            $file = APPLICATION_PATH . DS . 'config' . DS . 'acl.php';
            $users = include($file);
            foreach ($users as $user) {
                $login  = $user->getLogin();
                $pwd    = $user->getPassword();

                if ($username == $login && md5($password) == $pwd) {
                    $session->setUser($user);
                    return false;
                }
            }
            return true;
        }
    }
