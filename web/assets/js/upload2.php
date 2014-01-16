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
        $type           = array_key_exists('type', $_GET) ? $_GET["type"] : '';
?>
<link rel="stylesheet" href="//cdn.wysibb.com/css/default/wbbtheme.css" type="text/css" />
<form id="fupform" class="upload" action="<?php echo $urlSite; ?>assets/js/iupload2.php" method="post" enctype="multipart/form-data">
    <input type="hidden" name="MAX_FILE_SIZE" value="10000000" />
    <input name="iframe" value="0" type="hidden" />
    <input name="idarea" value="<?php echo $_REQUEST['field']; ?>" type="hidden" />
    <input name="type" value="<?php echo $type; ?>" type="hidden" />
    <div class="fileupload">
        <input id="fileupl" onchange="document.getElementById('fupform').submit();" class="file" name="img" type="file" />
    </div>
</form>
