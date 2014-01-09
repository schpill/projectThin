<?php
    namespace ThinService;
    class Member extends \Thin\Data
    {
        public static function addMember()
        {
            $db = new Querydata('member');
            $email = request()->getEmail();
            $evers = $db->where('email = ' . $email)->get();
            if (count($evers)) {
                $ever = current($evers);
                $paid = $ever->getPaid();
                if (0 == $paid) {
                    \Thin\Utils::go(URLSITE . 'member/paypal/' . $ever->getId());
                } else {
                    \Thin\Utils::go(URLSITE . 'member/userZone/' . $ever->getId());
                }
            } else {
                $_POST['paid'] = 0;
                $_POST['password'] = sha1(request()->getPassword1());
                unset($_POST['password1']);
                unset($_POST['password2']);
                $newId = Data::add('member');
                $key = sha1($newId . date('dmY') . $_POST['password']);
                $session = \Thin\Session::instance('member');
                $member = Data::getById('member', $newId);
                $session->setMember($member);
                \Thin\Utils::go(URLSITE . 'member/paypal/' . $newId . '/' . $key);
            }
        }

        public static function lost()
        {
            $email = request()->getEmail();
            if (null !== $email) {
                $evers = Data::query('member', 'email = ' . $email);
                if (count($evers) == 1) {
                    $member = static::getObject(current($evers));
                    $newPassword = \Thin\Inflector::lower(\Thin\Inflector::quickRandom(12));
                    Data::update('member', $member, array('password' => sha1($newPassword)));
                    if ('fr' == getLanguage()) {
                        $textMail = 'Bonjour,<br /><br />
                        Votre nouveau mot de passe est &laquo; ' . $newPassword . ' &raquo;<br /><br />
                        &Agrave; bient&ocirc;t sur <a href="' . URLSITE . '">Champagne &amp; Confetti</a>';
                        \Thin\Utils::mail($member->email, 'Champagne et Confetti - Nouveau mot de passe', $textMail, "From: Champagne et Confetti<sales@cconfetti.com>\nContent-Type: text/html; charset=\"utf-8\"\nContent-Transfer-Encoding: 8bit");
                    }
                    if ('uk' == getLanguage()) {
                        $textMail = 'Hello,<br /><br />
                        Your new password is &laquo; ' . $newPassword . ' &raquo;<br /><br />
                        See you soon on <a href="' . URLSITE . '">Champagne &amp; Confetti</a>';
                        \Thin\Utils::mail($member->email, 'Champagne et Confetti - New password', $textMail, "From: Champagne et Confetti<sales@cconfetti.com>\nContent-Type: text/html; charset=\"utf-8\"\nContent-Transfer-Encoding: 8bit");
                    }
                    return true;
                } else {
                    return false;
                }
            }
        }

        public static function login()
        {
            $db         = new Querydata('member');
            $session    = \Thin\Session::instance('member');
            $email      = request()->getEmailConnect();
            $password   = request()->getPasswordConnect();
            $evers      = $fb->where('member', 'email = ' . $email)->whereAnd('password = ' . sha1($password))->get();
            if (!count($evers)) {
                \Thin\Utils::go(URLSITE . 'member?error');
            } else {
                $member = current($evers);
                $session->setMember($member);
                $key = static::makeKey($member);

                $paid = $member->getPaid();
                if (1 == $paid) {
                    \Thin\Utils::go(URLSITE . 'member/userZone/' . $member->getId() . '/' . $key);
                } else {
                    \Thin\Utils::go(URLSITE . 'member/paypal/' . $member->getId() . '/' . $key);
                }
            }
        }

        public static function makeKey($member)
        {
            return sha1($member->getId() . date('dmY') . $member->getPassword());
        }
    }
