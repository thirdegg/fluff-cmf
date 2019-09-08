<?php 

function ObjectsView() {
    
    if (isset($_GET["template"])) {
        $page = (isset($_GET["offset"])?intval($_GET["offset"]):0);
        $offset = $page*20;
        $template = Template::getByName($_GET["template"]);

        $objects = array();

        if (isset($_GET["filter"]) && $_GET["filter"]!="") {
            $fields = array();
            foreach ($template->getFields() as $field) {
                $fields[] = "`".$field->getName()."` LIKE '%".$_GET["filter"]."%'";
            }
            $fields = implode(" OR ",$fields);
            $count = FluffObject::count($template->getName(),$fields);
            $objects = ObjectList::select($template->getName())->where($fields)->limit($offset,20)->execute();
        } else {
            $count = FluffObject::count($template->getName());
            $objects = FluffObject::getAllByTemplate($template->getId(),$offset,20);
        }
        $jsonarray = array();
        foreach ($objects as $object) {
            $jsonarray[] = $object->toArray();
        }
    }
    
?>
<div id="objects">
    <div class="title">
        <h1 style="margin: 0"><a href="?page=objectslist">Обьекты</a> > <?=$template->getName()?></h1>
    </div>
    <div class="menu-buttons">
        <a class="button" href="?page=newobject&template=<?=$template->getName()?>">
            Добавить объект
            <i class="fa fa-plus-square-o" aria-hidden="true"></i>
        </a>
    </div>

    <hr>
        <?php if (sizeof($objects)>0) { ?>
            <form method="get" action="" class="find">
                <label>Поиск:</label>
                <input name="page" value="objects" type="hidden"/>
                <input name="template" value="<?=$template->getName()?>" type="hidden"/>
                <input name="filter" type="text" value="<?php echo (isset($_GET["filter"])?$_GET["filter"]:"")?>"/>
            </form>
            <div class="offset">
                <?php for ($i=0;$i<$count/20;$i++) {?>
                    <?php if ($page==$i) {?>
                        <a class="selected" href="?page=objects&template=<?=$template->getName()?>&offset=<?=$i?><?php echo (isset($_GET["filter"])?"&filter=".$_GET["filter"]:"")?>"><?=$i+1?></a>
                    <?php } else {?>
                        <a href="?page=objects&template=<?=$template->getName()?>&offset=<?=$i?><?php echo (isset($_GET["filter"])?"&filter=".$_GET["filter"]:"")?>"><?=$i+1?></a>
                    <?php }?>
                <?php }?>
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
            <div class="offset">
                <?php for ($i=0;$i<$count/20;$i++) {?>
                    <?php if ($page==$i) {?>
                        <a class="selected" href="?page=objects&template=<?=$template->getName()?>&offset=<?=$i?><?php echo (isset($_GET["filter"])?"&filter=".$_GET["filter"]:"")?>"><?=$i+1?></a>
                    <?php } else {?>
                        <a href="?page=objects&template=<?=$template->getName()?>&offset=<?=$i?><?php echo (isset($_GET["filter"])?"&filter=".$_GET["filter"]:"")?>"><?=$i+1?></a>
                    <?php }?>
                <?php }?>
            </div>
                <script>
                    var objects = <?=json_encode($jsonarray)?>;
                    var template = <?=$template->toJson()?>;
                </script>
            <script src="js/object-utils.js"></script>
            <div id="image-preview"></div>
            <div id="object-preview">
                <table id="object-table-preview">

                </table>
            </div>
            <?php require_once("views/objects/ObjectLine.php");?>
        <?php } else { ?>
            <div>Обьекты этого типа еще не созданы.</div>
        <?php } ?>
</div>
<?php } ?>