<?php function FilesView() {
    $path = ".";
    if (isset($_GET["path"])) $path = $_GET["path"];
    
    ?>
<div style="overflow: hidden;">
    <div style="float: left; line-height: 50px;">
        <h1 style="margin: 0">Файлы</h1>
    </div>
    <div style="width: 100%; text-align: right; line-height: 30px;">
        <a class="button" href="?page=newfile">
            Создать файл
            <i class="fa fa-plus-square-o" aria-hidden="true"></i>
        </a>
        <a class="button" href="?page=uploadfiles&path=<?=$path?>">
            Загрузить файлы
            <i class="fa fa-upload" aria-hidden="true"></i>
        </a>
    </div>
</div>
<hr>
<div id="files">
    <div class="horisontal-label-input small" style="text-align: right;">
        <label>Поиск:</label>
        <input type="text"/>
    </div>
    <ul class="file-list">
        <li><a href='?page=files&path=<?=preg_replace("/(\/[A-я0-9-_.,]*\/?$)/", "", $path)?>'>..</a></li>
    <?php 
        chdir(SITE_PATH);
        foreach (File::getTree(".",$path) as $file) {
            $icon = "fa-file";
            $mime = $file->getMime();
            if ($mime=="directory") $icon = "fa-folder-o";
            if ($mime=="text/x-php") $icon = "fa-file-code-o";
            ?>
        <li>
            <div class="icon"><i class="fa <?=$icon?>" aria-hidden="true"></i></div>
            <div class="name">
                <?php if ($file->getMime()=="directory") {?>
                        <a href="?page=files&path=<?=$file->getPath()?>"><?=$file->getName()?></a>
                <?php } else if ($file->getMime()=="text/x-php" || $file->getMime()=="text/html" || $file->getMime()=="text/plain") {?>
                        <a href="#" target="popup" onclick="event.preventDefault(); window.open('?page=editview&path=<?=$file->getPath()?>','<?=$file->getPath()?>','width=800,height=600')"><?=$file->getName()?></a>
                <?php } else {?>
                    <a href="<?=SITE_URL."/".$file->getPath()?>"><?=$file->getName()?></a>
                <?php } ?>
            </div>
            <div class="type"><?=$mime?></div>
            <div style="display: inline-block;"><?=0?></div>
            <div style="display: inline-block;"><?=0?></div>
        </li>
    <?php }?>
    </ul>
</div>
<?php }?>
