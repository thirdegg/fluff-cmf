<?php function RemoveObjectView() {
    
    if (!isset($_GET["object"]) || !isset($_GET["template"])) {
        return;
    }
    
    $template = Template::getByName($_GET["template"]);
    $object = FluffObject::getById($template->getId(), $_GET["object"]);
    if (!isset($object)) return;

    if ($_SERVER["REQUEST_METHOD"]=="POST") {
        $object->delete();
        echo 'Удалено';
        return;
    }
    
?>
<form id="new-object-form" action="?page=removeobject&object=<?=$object->getId()?>&template=<?=$template->getName()?>" method="post">
    <hr>
    <div class="object-data" style="margin-top: 20px; margin-bottom: 20px;">
        Вы уверены что хотите удалить объект?<br/>
        <button>
            Да
        </button>
        <a href="?page=objectslist" class="button">
            Отмена
        </a>
    </div>
    <hr>
</form>
<?php } ?>
