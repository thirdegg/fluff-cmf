<?php function PagesView() {
    $pages = Page::getAllPages();
?>
<div id="pages">
    <div class="title">
        <h1>Страницы</h1>
    </div>
    <div class="menu-buttons">
        <a class="button" href="?page=newpage">
            Добавить страницу
            <i class="fa fa-plus-square-o" aria-hidden="true"></i>
        </a>
    </div>
    <hr>
    <?php if (sizeof($pages)>0) { ?>
    <table border="0">
        <thead>
            <td>Имя</td>
            <td>URL</td>
            <td>Файл</td>
            <td>Кэширование</td>
            <td>Дата последнего обновления</td>
            <td></td>
        </thead>
        <?php foreach ($pages as $page) { ?>
            <tr>
                <td><?=$page->getName()?></td>
                <td><?=$page->getUrl()?></td>
                <td><?=$page->getFilePath()?></td>
                <td><?=($page->isCache())?"Да":""?></td>
                <td><?=$page->getLastEdit()?></td>
                <td><a href="?page=editpage&pageid=<?=$page->getId()?>"><i class="fa fa-edit" aria-hidden="true"></i></a></td>
            </tr>
        <?php }?>
    </table>
    <?php } else {?>
        <div>Страницы еще не созданы.</div>
    <?php }?>
</div>
<?php } ?>
