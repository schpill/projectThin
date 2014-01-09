<?php
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

    // $posturl        = "http://api.zendgroup.com/image.php";
    $posturl        = $urlSite . 'api/upload.php';

    $fileupload     = $_FILES["fileup"]['tmp_name'];
    $name           = $_FILES["fileup"]["name"];

    $isIframe       = ($_POST["iframe"]) ? true : false;
    $idarea         = $_POST["idarea"];

    $postData = array(
        'fileupload' => "@" . $fileupload,
        'name'       => $name,
        'key'        => '239EFGIY052f49d3ed8c8b7f7991ec05513fb5e8'
    );

    $ch = curl_init($posturl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
    $result = curl_exec($ch);
    curl_close($ch);

    $tab = unserialize($result);

    if ($isIframe) {
        #use for iframe upload
        echo '';
    } else {
        // use for drag & drop
        if ($tab['code'] == 500) {
            die($tab['message']);
        } else {
            echo '<html>
        <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
            <script>
            function init() {
                window.parent.$("#' . $idarea . '_file").html("<a href=\'' . $tab['message'] . '\' target=\'_fileUpload\'>' . $_FILES["fileup"]["name"] . '</a>");
                window.parent.$("#' . $idarea . '_file").show();
                window.parent.$("#' . $idarea . '").val("' . $tab['message'] . '");
                window.parent.$("#iframe_' . $idarea . '").hide();
            }
            </script>
            <body onload="init();">
            </body>
            </html>';
        }
    }
