<?php
    set_time_limit(0);
    error_reporting(-1);
    $fileupload     = $_FILES["fileupload"]['tmp_name'];
    function UUID()
    {
        list($usec, $sec) = explode(' ', microtime());
        return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            mt_rand(0, 0xffff), mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0x0fff) | 0x4000,
            mt_rand(0, 0x3fff) | 0x8000,
            mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
        ) . $sec . $usec;
    }

    $name           = UUID() . '_' . $_POST["name"];
    defined('FILES_PATH')   || define('FILES_PATH',         realpath(dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR . 'files'));
    defined('CONFIG_PATH')  || define('CONFIG_PATH',        realpath(dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'application' . DIRECTORY_SEPARATOR . 'config'));

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
        $tab    = explode('\\', $urlSite);
        $r      = '';
        foreach ($tab as $c => $v) {
            $r .= $v;
        }
        $r = str_replace('//', '/', $r);
        $r = str_replace($protocol . ':/', $protocol . '://', $r);
        $urlSite = $r;
    }
    $type           = array_key_exists('type', $_POST)  ? $_POST['type'] : '';
    $id             = array_key_exists('id', $_POST)    ? $_POST['id']   : null;

    $fileData       = CONFIG_PATH . DIRECTORY_SEPARATOR . 'datas.php';

    $settingsUpload = array();
    $settings       = array();
    $fields         = array();

    if (is_readable($fileData)) {
        $datas = include($fileData);
        if (!empty($type) && !empty($id)) {
            $fields         = array_key_exists($type, $datas)       ? $datas[$type]['fields'][$id]      : array();
            $settings       = array_key_exists($type, $datas)       ? $datas[$type]['settings']         : array();
            $settingsUpload = array_key_exists('settings', $fields) ? $fields['settings']               : array();
        }
    } else {
        render('wrong config file => ' . $fileData, 500);
    }

    if (move_uploaded_file($fileupload, FILES_PATH . "/$name")) {
        if (count($settingsUpload)) {
            settings(FILES_PATH . "/$name", $settingsUpload);
        }
        render($urlSite . 'assets/files/' . $name);
    }

    render('Problem, please reupload file!', 500);

    function settings($file, $settings)
    {
        /* extensions */
        if (array_key_exists('extensions', $settings)) {
            $exts = explode(',', strtolower($settings['extensions']));
            $tab = explode('.', strtolower($file));
            $ext = end($tab);
            if (!in_array($ext, $exts)) {
                $message = "Your file has a wrong extension ($ext). You must provide a file with these extensions : " . strtolower($settings['extensions']);
                render($message, 500);
            }
        }
    }

    function render($message, $code = 200)
    {
        $tab = array(
            'code'      => $code,
            'message'   => $message,
        );
        die(serialize($tab));
    }
