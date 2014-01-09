<?php
    set_time_limit(0);
    $fileupload     = $_FILES["fileupload"]['tmp_name'];
    function UUID()
    {
        return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            mt_rand(0, 0xffff), mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0x0fff) | 0x4000,
            mt_rand(0, 0x3fff) | 0x8000,
            mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
        );
    }

    $name           = UUID() . '_' . $_POST["name"];
    defined('FILES_PATH')       || define('FILES_PATH',         realpath(dirname(__FILE__) . '/../assets/files'));

    $protocol = 'http';
    if (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') {
        $protocol = 'https';
    }

    $urlSite = "$protocol://" . $_SERVER["SERVER_NAME"] . "/";

    if (strstr($urlSite, '//')) {
        $urlSite = str_replace('//', '/', $urlSite);
        $urlSite = str_replace($protocol . ':/', $protocol . '://', $urlSite);
    }

    if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
        $tab = explode('\\', $urlSite);
        $r = '';
        foreach ($tab as $c => $v) {
            $r .= $v;
        }
        $r = str_replace('//', '/', $r);
        $r = str_replace($protocol . ':/', $protocol . '://', $r);
        $urlSite = $r;
    }

    if (move_uploaded_file($fileupload, FILES_PATH . "/$name")) {
        render('/assets/files/' . $name);
    }

    render('Problem, please reupload file!', 500);

    function render($message, $code = 200)
    {
        $tab = array(
            'code'      => $code,
            'message'   => $message,
        );
        die(serialize($tab));
    }
