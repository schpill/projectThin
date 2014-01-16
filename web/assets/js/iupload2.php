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
    // $posturl        = "http://api.gpweb.co/upload.php";

    $fileupload     = $_FILES["img"]['tmp_name'];
    $name           = $_FILES["img"]["name"];

    $isIframe       = false;
    $idarea         = array_key_exists("idarea", $_POST)    ? $_POST["idarea"]  : '';
    $type           = array_key_exists("type", $_POST)      ? $_POST["type"]    : '';


    $postData = array(
        'fileupload' => "@" . $fileupload,
        'name'       => $name,
        'type'       => $type,
        'id'         => $idarea,
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
        echo '<html><body>OK<script>window.parent.$("#' . $idarea . '").insertImage("' . $xml->links->image_link . '","' . $xml->links->thumb_link . '").closeModal().updateUI();</script></body></html>';
    } else {
        // use for drag & drop
        if ($tab['code'] == 500) {
            $html = '<html>
        <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
            <script>
            function redo() {
                window.parent.document.getElementById("iframe_' . $idarea . '").src = "' . $urlSite . 'assets/js/upload2.php?field=' . $idarea . '&type=' . $type . '";
            }
            </script>
            <body>
                <p style="color: red; font-weight: bold;">' . stripslashes($tab['message']) . '<br /><a href="#" onclick="redo(); return false;">Recommencer</a><p>
            </body>
            </html>';
            die($html);
        } else {
            echo '<html>
        <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
            <script>
            function init() {
                window.parent.document.getElementById("' . $idarea . '_img").src = "' . $tab['message'] . '";
                window.parent.$("#' . $idarea . '_img").show();
                window.parent.$("#' . $idarea . '").val("' . $tab['message'] . '");
                // window.parent.$("#iframe_' . $idarea . '").hide();
            }
            function redo() {
                window.parent.document.getElementById("iframe_' . $idarea . '").src = "' . $urlSite . 'assets/js/upload2.php?field=' . $idarea . '&type=' . $type . '";
                window.parent.$("#iframe_' . $idarea . '").show();
                window.parent.$("#' . $idarea . '_img").hide();
                window.parent.$("#' . $idarea . '").val("");
            }
            </script>
            <body onload="init();">
            <p><a href="#" onclick="redo(); return false;">Recommencer</a><p>
            </body>
            </html>';
        }
    }
