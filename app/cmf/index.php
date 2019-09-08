<?php

session_start();

header("Content-Type: text/html; charset=UTF-8");

ini_set('display_errors', 1);

set_include_path(__DIR__);

setlocale(LC_ALL, 'ru_RU.UTF-8');

require_once("../core/includes.php");
require_once("./includes.php");


if (is_null(User::getCurrent())) {
    LoginView();
    return;
}

$page = "index";
if (isset($_GET['page'])) {
    $page = $_GET['page'];
}

switch ($page) {
    case "ajax":
        require_once("views/ajax.php");
        break;
    case "index":
        MainView("IndexView");
        break;
    case "groups":
        MainView("GroupsView");
        break;
    case "newgroup":
        MainView("NewGroupView");
        break;
    case "editgroup":
        MainView("EditGroupView");
        break;
    case "removegroup":
        MainView("RemoveGroupView");
        break;
    case "newuser":
        MainView("NewUserView");
        break;
    case "edituser":
        MainView("EditUserView");
        break;
    case "users":
        MainView("UsersView");
        break;
    case "templates":
        MainView("TemplatesView");
        break;
    case "edittemplate":
        MainView("EditTemplateView");
        break;
    case "newtemplate":
        MainView("NewTemplateView");
        break;
    case "objects":
        MainView("ObjectsView");
        break;
    case "objectslist":
        MainView("ObjectsListView");
        break;
    case "newobject":
        MainView("NewObjectView");
        break;
    case "editobject":
        MainView("EditObjectView");
        break;
    case "removeobject":
        MainView("RemoveObjectView");
        break;
    case "pages":
        MainView("PagesView");
        break;
    case "newpage":
        MainView("NewPageView");
        break;
    case "editpage":
        MainView("EditPageView");
        break;
    case "options":
        MainView("OptionsView");
        break;
    case "files":
        MainView("FilesView");
        break;
    case "uploadfiles":
        MainView("UploadFileView");
        break;
    case "editview":
        EditViewView();
        break;
    case "objectspopup":
        ObjectsPopupView();
        break;
    case "filespopup":
        FilesPopupView();
        break;
    case "logout":
        LogoutView();
        break;
    default:
        echo '404';
        break;
}
