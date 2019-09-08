<?php function UsersView() { 
    if (isset($_GET["gid"])) {
        $group = Group::getById($_GET["gid"]);
        if ($group==null) return;
    }?>
<div id="users">
    <div class="title">
        <h1><a href="?page=groups">Группы</a> > <?=$group->getName()?></h1>
    </div>
    <div class="menu-buttons">
        <a class="button" href="?page=newuser">
            Добавить пользователя
            <i class="fa fa-plus-square-o" aria-hidden="true"></i>
        </a>
    </div>
    <hr>
    <table border="0">
        <thead>
            <td>ID</td>
            <td>Логин</td>
            <td>Имя</td>
            <td>Группа</td>
            <td>Email</td>
            <td>Дата создания</td>
        </thead>
    <?php 
        foreach ($group->getUsers() as $user) { ?>
        <tr>
            <td><?=$user->getId()?></td>
            <td><?=$user->getLogin()?></td>
            <td><?=$user->getUsername()?></td>
            <td><?=$user->getGroup()->getName()?></td>
            <td><?=$user->getEmail()?></td>
            <td>21.11.2017</td>
        </tr>
    <?php }?>
    </table>
</div>
<?php }?>