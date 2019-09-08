<?php function GroupsView() {?>
<div id="groups">
    <div class="title">
        <h1>Группы пользователей</h1>
    </div>
    <div class="menu-buttons">
        <a class="button" href="?page=newgroup">
            Добавить группу
            <i class="fa fa-plus-square-o" aria-hidden="true"></i>
        </a>
    </div>
    <hr>
    <table border="0">
        <thead>
            <td>ID</td>
            <td>Группа</td>
            <td></td>
        </thead>
    <?php
        $groups=Group::getGroupsList();
        foreach ($groups as $group) { ?>
        <tr>
            <td><a href="?page=users&gid=<?=$group->getId()?>"><?=$group->getId()?></a></td>
            <td><a href="?page=users&gid=<?=$group->getId()?>"><?=$group->getName()?></a></td>
            <td><a href="?page=editgroup&gid=<?=$group->getId()?>"><i class="fa fa-edit" aria-hidden="true"></i></a></td>
        </tr>
    <?php }?>
    </table>
</div>
<?php }?>