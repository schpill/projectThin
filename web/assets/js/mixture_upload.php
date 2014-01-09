<form id="fupform" class="upload" action="/assets/js/mupload.php" method="post" enctype="multipart/form-data">
    <input name="iframe" value="0" type="hidden" />
    <input name="idarea" value="<?php echo $_REQUEST['field']; ?>" type="hidden" />
    <div class="fileupload">
        <input id="fileupl" class="file" name="fileup" type="file" />
        <button id="nicebtn" class="wbb-button">Télécharger</button>
    </div>
</form>
