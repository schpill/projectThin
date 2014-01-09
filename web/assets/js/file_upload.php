<link rel="stylesheet" href="//cdn.wysibb.com/css/default/wbbtheme.css" type="text/css" />
<form id="fupform" class="upload" action="/assets/js/fupload.php" method="post" enctype="multipart/form-data">
    <input type="hidden" name="MAX_FILE_SIZE" value="10000000" />
    <input name="iframe" value="0" type="hidden" />
    <input name="idarea" value="<?php echo $_GET['field']; ?>" type="hidden" />
    <div class="fileupload">
        <input id="fileupl" class="file" name="fileup" type="file" />
        <input type="submit" value="Uploader" />
    </div>
</form>
