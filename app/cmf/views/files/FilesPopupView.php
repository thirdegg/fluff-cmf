<?php function FilesPopupView() {
    $path = ".";
    if (isset($_GET["path"])) $path = $_GET["path"];
    
    $filter = null;
    if (isset($_GET["filter"])) {
        if ($_GET["filter"]=="images") {
            $filter = array("image/svg+xml","image/jpeg","image/png","directory");
        }
        if ($_GET["filter"]=="scripts") {
            $filter = array("text/x-php","text/html","directory");
        }
    }?>
<!doctype html>
<head>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <script src="//code.jquery.com/jquery-3.2.1.min.js"></script>
    <script src="js/utils.js"></script>
    <link rel="stylesheet" type="text/css" href="css/fonts/font-awesome.css"> 
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body id="files-popup">
    <div id="files">
    <div class="horisontal-label-input small" style="text-align: right;">
        <label>Поиск:</label>
        <input type="text"/>
    </div>
    <ul class="file-list">
        <li><a href='?page=filespopup&path=<?=preg_replace("/(\/[A-я0-9-_.,]*\/?$)/", "", $path)?><?php if (isset($_GET["filter"])) echo "&filter=".$_GET["filter"];?>'>..</a></li>
        <?php
            chdir(SITE_PATH);
            foreach (File::getTree(".",$path) as $file) {
                if ($filter!=null && !in_array($file->getMime(), $filter)) continue;
                $icon = "fa-file";
                $mime = $file->getMime();
                if ($mime=="directory") $icon = "fa-folder-o";
                if ($mime=="text/x-php") $icon = "fa-file-code-o";
                ?>
            <li>
                <div class="icon"><i class="fa <?=$icon?>" aria-hidden="true"></i></div>
                <div class="name">
                    <?php if ($file->getMime()=="directory") {?>
                        <a href="?page=filespopup&path=<?=$file->getPath()?><?php if (isset($_GET["filter"])) echo "&filter=".$_GET["filter"];?>"><?=$file->getName()?></a>
                    <?php } else if ($file->getMime()=="text/x-php" || $file->getMime()=="text/html") {?>
                        <a href="javascript:void(0)" target="popup" onclick="$.popupResult(window,'<?=preg_replace("/^(\.\/)/","",$file->getPath())?>')"><?=$file->getName()?></a>
                    <?php } else {?>
                        <a href="javascript:void(0)" target="popup" onclick="$.popupResult(window,'<?=preg_replace("/^(\.\/)/","",$file->getPath())?>')"><?=$file->getName()?></a>
                    <?php } ?>
                </div>
                <div class="type"><?=$mime?></div>
                <div style="display: inline-block;"><?=0?></div>
                <div style="display: inline-block;"><?=0?></div>
            </li>
        <?php }?>
        </ul>
    </div>
</body>
<?php }?>