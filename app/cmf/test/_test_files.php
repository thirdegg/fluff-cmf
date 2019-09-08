<?php

require_once '../core/includes.php';

ini_set('display_errors', 1);

chdir("../");

$path = ".";

if (isset($_GET["path"])) {
    $path = $_GET["path"];
}

//print_r(File::getTree($_SERVER['DOCUMENT_ROOT']));

echo "<a href='_test_files.php?path=".preg_replace("/(\/[A-я0-9-_.,]*\/?$)/", "", $path)."'>..</a><br/>";
foreach (File::getTree(".",$path) as $file) {
    echo "<a href='_test_files.php?path=".$path."/".$file->getName()."'>".$file->getName()."</a><br/>";
}

//createUserTest("admin", "admin", "Администратор", "admin@mail.ru", createGroupTest("Администраторы"));

//readTest($group);
//loginTest("user", "pass");
//removeTest();

?>