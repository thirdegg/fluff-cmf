<?php 
function MainView($content) {?>
<!doctype html>
<html class="js" lang="">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Fluffy CMF</title>
    <base href="<?=Url::baseHref()?>">
    <meta name="description" content="">
    <meta name="keywords" content="">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="apple-touch-icon" href="apple-touch-icon.png">
    <link rel="shortcut icon" href="img/favicon.png" type="image/png">
   
    <link rel="stylesheet" type="text/css" href="css/fonts/font-awesome.css"> 
    <link rel="stylesheet" type="text/css" href="css/style.css">

    <script src="//code.jquery.com/jquery-3.2.1.min.js"></script>
    <script src="js/jquery.tmpl.min.js"></script>
    <script src="js/utils.js"></script>
</head>
<body>

<!--[if lt IE 8]>
<p class="browserupgrade">Похоже, ваш браузер <strong>устарел</strong>. Пожалуйста, <a href="http://browsehappy.com/">обновите его</a>, что бы воспользоваться дополнительными функциями сайта.</p>
<![endif]-->

<div id="header">
    <div id="logo">
        <a href="/">
            <img src="img/fluff2.svg" height="50" width="50">
            <span id="logo-title">Fluffy</span>
        </a>
    </div>
    <div id="user">
        <a href="?page=logout">ВЫЙТИ</a>
        <a href="?page=edituser&user=<?=User::getCurrent()->getId()?>">НАСТРОЙКИ</a>
        <a href="<?=SITE_URL?>">ПЕРЕЙТИ НА САЙТ</a>
    </div>
</div>

<div id="nav">
    <ul>
        <li class="item <?php echo (!isset($_GET["page"])) ? 'selected' : ''; ?>">
            <a href=""><i class="fa fa-home" aria-hidden="true"></i> Главная</a>
        </li>
        <?php if (User::getCurrent()->getGroup()->isEditUsers()) {?>
            <li class="item <?php echo ($_GET["page"]=="groups") ? 'selected' : ''; ?>">
                <a href="?page=groups"><i class="fa fa-users" aria-hidden="true"></i> Пользователи</a>
            </li>
        <?php }?>

        <?php if (User::getCurrent()->getGroup()->isEditObject()) {?>
            <li class="item <?php echo ($_GET["page"]=="objectslist") ? 'selected' : ''; ?>">
                <a href="?page=objectslist"><i class="fa fa-gavel" aria-hidden="true"></i> Объекты</a>
            </li>
        <?php }?>

        <?php if (User::getCurrent()->getGroup()->isEditPages()) {?>
            <li class="item <?php echo ($_GET["page"]=="pages") ? 'selected' : ''; ?>">
                <a href="?page=pages"><i class="fa fa-file-text-o" aria-hidden="true"></i> Страницы</a>
            </li>
        <?php }?>

        <?php if (User::getCurrent()->getGroup()->isEditFiles()) {?>
            <li class="item <?php echo ($_GET["page"]=="files") ? 'selected' : ''; ?>">
                <a href="?page=files"><i class="fa fa-files-o" aria-hidden="true"></i> Файлы</a>
            </li>
        <?php }?>

        <?php if (User::getCurrent()->getGroup()->isEditOptions()) {?>
            <li class="item <?php echo ($_GET["page"]=="options") ? 'selected' : ''; ?>">
                <a href="?page=options"><i class="fa fa-cog" aria-hidden="true"></i> Опции</a>
            </li>
        <?php }?>
<!--        <li class="item --><?php //echo ($_GET["page"]=="cron") ? 'selected' : ''; ?><!--">-->
<!--            <a href="?page=cron"><i class="fa fa-calendar-check-o" aria-hidden="true"></i> CRON</a>-->
<!--        </li>-->
<!--        <li class="item --><?php //echo ($_GET["page"]=="about") ? 'selected' : ''; ?><!--">-->
<!--            <a href="?page=about"><i class="fa fa-info" aria-hidden="true"></i> О CRM</a>-->
<!--        </li>-->
    </ul>
</div>

<div id="main">
    <div id="content">
        <?=$content()?>
    </div>
</div>
</body>
</html>
<?php }?>