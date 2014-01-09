<?php

?>
<link rel="stylesheet" href="//cdn.wysibb.com/css/default/wbbtheme.css" type="text/css" />
<form id="fupform" class="upload" action="/assets/js/iupload2.php" method="post" enctype="multipart/form-data">
    <input type="hidden" name="MAX_FILE_SIZE" value="3000000" />
    <input name="iframe" value="0" type="hidden" />
    <input name="idarea" value="<?php echo $_REQUEST['field']; ?>" type="hidden" />
    <div class="fileupload">
        <input id="fileupl" onchange="document.getElementById('fupform').submit();" class="file" name="img" type="file" />
    </div>
</form>
