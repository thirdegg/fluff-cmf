<?php function ObjectsPopupView() {

    if (isset($_GET["template"])) {
        $template = Template::getById($_GET["template"]);
        $objects = FluffObject::getAllByTemplate($template->getId());
        $jsonarray = array();
        foreach ($objects as $object) {$jsonarray[] = $object->toArray();}
    }


    ?>
    <!doctype html>
    <head>
        <link rel="stylesheet" type="text/css" href="css/style.css">
        <script src="//code.jquery.com/jquery-3.2.1.min.js"></script>
        <script src="js/jquery.tmpl.min.js"></script>
        <script src="js/utils.js"></script>
        <link rel="stylesheet" type="text/css" href="css/fonts/font-awesome.css">
        <link rel="stylesheet" type="text/css" href="css/style.css">
    </head>
    <body id="files-popup">
    <div id="files">
        <div style="overflow: hidden;">
            <div style="float: left; line-height: 50px;">
                <h1 style="margin: 0"><a href="?page=objectslist">Обьекты</a> > <?=$template->getName()?></h1>
            </div>
        </div>
        <hr>
        <?php if (sizeof($objects)>0) { ?>
            <div class="horisontal-label-input small" style="text-align: right;">
                <label>Поиск:</label>
                <input type="text"/>
            </div>
            <table border="0">
                <thead>
                <?php foreach ($template->getFields() as $field) { ?>
                    <td><?=$field->getName()?></td>
                <?php }?>
                </thead>
                <tbody id="object-table">

                </tbody>
            </table>
            <script>
                var objects = <?=json_encode($jsonarray)?>;
                var template = <?=$template->toJson()?>;
            </script>
            <script src="js/object-utils.js"></script>
            <div id="image-preview"></div>
        <?php require_once("views/objects/ObjectPopupLine.php");?>
        <?php } else { ?>
            <div>Обьекты этого типа еще не созданы.</div>
        <?php } ?>
    </div>
    </body>
<?php }?>
