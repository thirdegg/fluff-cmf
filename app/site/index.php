<?php

header("Content-Type: text/html; charset=UTF-8");

ini_set('display_errors', 1);

setlocale(LC_ALL, 'ru_RU.UTF-8');

require_once("../core/includes.php");


if (!isset($_GET["fluffpage"])) $_GET["fluffpage"]="index.html";

$page = Page::getByURL($_GET["fluffpage"]);

unset($_GET["fluffpage"]);

if (is_null($page)) {
    echo '404';
    return;
}

//if (!file_exists(".cache")) mkdir(".cache");
//
//if (file_exists(".cache/".md5($page->getFilePath()))) {
//    include(".cache/".md5($page->getFilePath()));
//} else {
    ob_start();
    include($page->getFilePath());
    $htm = ob_get_clean();
//    file_put_contents(".cache/".md5($page->getFilePath()),$htm);
    echo $htm;
//}


