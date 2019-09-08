<?php function UploadFileView() {

    if (!isset($_GET["path"])) {
        return;
    }

    $path = $_GET["path"];

    if ($_SERVER["REQUEST_METHOD"]=="POST") {
        for ($i=0;$i<sizeof($_FILES['files']['name']);$i++) {
            File::copyTempFile($_FILES['files']['tmp_name'][$i],SITE_PATH."/".$_GET["path"]."/".$_FILES['files']['name'][$i]);
        }
        echo '<h2>Готово</h2>';
        return;
    }

?>
<form action="?page=uploadfiles&path=<?=$path?>" method="post" id="upload-file" enctype="multipart/form-data">
    <div class="title">
        <h1>Загрузка файла в папку <?=$path?></h1>
    </div>
    <div class="menu-buttons">
        <input type="file" name="files[]" id="files" required multiple>
        <a href="javascript:void(0)" class="button" onclick="$('#files').click()">Выбрать</a>
        <a class="button" href="javascript:void(0)" onclick="$('#upload-file').submit()">
            Загрузить
            <i class="fa fa-upload" aria-hidden="true"></i>
        </a>
    </div>
    <hr>

    <ul id="files-list">

    </ul>
    <script>
        $(document).ready(function () {
            $("#files").change(function () {
                $('#files-list').empty();
                for (var i = 0; i < $(this).get(0).files.length; ++i) {
                    $('#file-item').tmpl({"name": $(this).get(0).files[i].name}).appendTo('#files-list');
                }
            });
        });
    </script>
    <script id="file-item" type="text/x-jquery-tmpl">
        <li class="file-item">${name}</li>
    </script>
</form>
<?php }?>