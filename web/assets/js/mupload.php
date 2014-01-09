<?php

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

    $fileupload     = $_FILES["fileup"]['tmp_name'];
    $name           = UUID() . '_' . $_FILES["fileup"]["name"];
    $idarea         = $_POST["idarea"];
    defined('FILES_PATH')       || define('FILES_PATH',         realpath(dirname(__FILE__) . '/../files'));

    $cid = 'GGVRfbRYfPpT6gh6sq';
    $hash = 'sfkgD3SCYjTL2EKnHZNnG8eMVDBfLs4Q';


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
        $file = FILES_PATH . "/$name";
        echo '<html>
        <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
            <script>
            function init() {
                window.parent.$("#' . $idarea . '_file").html("<a href=\'' . $urlSite . 'assets/files/' . $name . '\' target=\'_fileUpload\'>' . $_FILES["fileup"]["name"] . '</a>");
                window.parent.$("#' . $idarea . '_file").show();
                window.parent.$("#' . $idarea . '").val("' . $urlSite . 'assets/files/' . $name . '");
                window.parent.$("#iframe_' . $idarea . '").hide();
            }
            </script>
            <body onload="init();">
            </body>
            </html>';
    }

