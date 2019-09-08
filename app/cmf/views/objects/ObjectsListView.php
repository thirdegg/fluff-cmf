<?php
function ObjectsListView() { 
    $templates = Template::getAllTemplates();?>
<div id="object-list">
    <div class="title">
        <h1>Список объектов</h1>
    </div>
    <div class="menu-buttons">
        <?php if (User::getCurrent()->getGroup()->isEditTemplates()) {?>
            <a class="button" href="?page=newtemplate">
                Создать шаблон
                <i class="fa fa-plus-square-o" aria-hidden="true"></i>
            </a>
        <?php } ?>
    </div>
    <hr>
    <?php if (sizeof($templates)>0) { ?>
    <table border="0">
        <thead>
        <?php if (User::getCurrent()->getGroup()->isAdministrator()) {?><td>ID</td><?php } ?>
        <td>Название</td>
        <td>Описание</td>
        <td>Количество</td>
        <?php if (User::getCurrent()->getGroup()->isEditTemplates()) {?><td></td><?php } ?>
        </thead>
        <tbody>
            <?php foreach ($templates as $template) { ?>
                <tr>
                    <?php if (User::getCurrent()->getGroup()->isAdministrator()) {?>
                        <td><a href="?page=objects&template=<?=$template->getName()?>"><?=$template->getId()?></a></td>
                    <?php } ?>
                    <td><a href="?page=objects&template=<?=$template->getName()?>"><?=$template->getName()?></a></td>
                    <td><a href="?page=objects&template=<?=$template->getName()?>"><?=$template->getDescription()?></a></td>
                    <td><a href="?page=objects&template=<?=$template->getName()?>"><?=sizeof(FluffObject::getAllByTemplate($template->getId()))?></a></td>
                    <?php if (User::getCurrent()->getGroup()->isEditTemplates()) {?>
                        <td><a href="?page=edittemplate&template=<?=$template->getName()?>"><i class="fa fa-edit" aria-hidden="true"></i></a></td>
                    <?php } ?>
                </tr>
            <?php }?>
        </tbody>
        <?php } else {?>
            <div>Шаблоны еще не созданы</div>
        <?php }?>
    </table>
</div>
<?php } ?>
