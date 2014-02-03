<?php

?>
<link rel="stylesheet" href="//cdn.wysibb.com/css/default/wbbtheme.css" type="text/css" />
<form id="fupform" class="upload" action="/assets/js/iupload.php" method="post" enctype="multipart/form-data">
    <input type="hidden" name="MAX_FILE_SIZE" value="3000000" />
    <input name="iframe" value="0" type="hidden" />
    <input name="idarea" value="<?php echo $_REQUEST['field']; ?>" type="hidden" />
    <div class="fileupload">
        <input id="fileupl" class="file" name="img" type="file" />
        <button id="nicebtn" class="wbb-button">Télécharger</button>
    </div>
</form>
