<?php function RemoveGroupView() {
    
    if (!isset($_GET["gid"])) {return;}
    $group = Group::getById($_GET["gid"]);
    if (!isset($group)) return;

    if ($_SERVER["REQUEST_METHOD"]=="POST") {
        $group->delete();
        echo 'Удалено';
        return;
    }
    
?>
<form id="new-object-form" action="?page=removegroup&gid=<?=$group->getId()?>" method="post">
    <hr>
    <div class="object-data" style="margin-top: 20px; margin-bottom: 20px;">
        Вы уверены что хотите удалить группу?<br/>
        <button>
            Да
        </button>
        <a href="?page=editgroup&gid=<?=$group->getId()?>" class="button">
            Отмена
        </a>
    </div>
    <hr>
</form>
<?php } ?>
