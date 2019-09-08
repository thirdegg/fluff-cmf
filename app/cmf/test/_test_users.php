<?php

require_once '../../core/includes.php';

ini_set('display_errors', 1);

$group = "users";

function createGroupTest($groupname, $privileges) {
    echo "Создаем группу пользователей"."</br>";
    $group = new Group();
    $group->setName($groupname);
    $group->setPrivileges($privileges);
    $group->save();
    echo "Готово</br>";
    echo "-</br>";
    return $group->getId();
}

function createUserTest($login, $pass, $username, $email, $groupid) {
    
    echo "Создаем пользователя в группе"."</br>";
    $user = new User();
    $user->setLogin($login);
    $user->setEmail($email);
    $user->setUsername($username);
    $user->setGroup($groupid);
    $user->save($pass);
    echo "Готово</br>";
    echo "-</br>";
}


function readTest($groupname) {
    echo "Получаем список всех групп</br>";
    echo "Количество групп: ".sizeof(Group::getGroupsList())."</br>";
    echo "Получаем группу </br>";
    $group = Group::getByName($groupname);
    echo "Список пользователей. Количество: ".sizeof($group->getUsers()).". Список:</br>";
    foreach ($group->getUsers() as $user) {
        echo $user->getId()." - ".$user->getLogin()." - ".$user->getUsername()." - ".$user->getGroup()->getName()."</br>";
    }
    echo "Готово</br>";
    echo "-</br>";
}

function loginTest($login, $password) {
    echo "Проверяем логин</br>";
    User::authorize($login, $password);
    echo "Получаем имя пользователя: ".User::getCurrent()->getUsername()."</br>";
    echo "Выходим</br>";
    User::logout();
    echo "Готово</br>";
    echo "-</br>";
}

////////////////////////////// DELETE
function removeTest() {
    echo "Удаляем объекты"."</br>";
    $groups = Group::getGroupsList();
    if ($groups==null) return;
    foreach ($groups as $group) {
        foreach ($group->getUsers() as $user) $user->delete();
        $group->delete();
    }
    echo "Готово</br>";
    echo "-</br>";
}

//1 бит - редактирование групп пользователей
//2 бит - редактирование пользователей
//3 бит - редактирование шаблонов
//4 бит - редактирование объектов
//5 бит - редактирование страниц
//6 бит - редактирование файлов
//7 бит - редактирование опций

createUserTest("admin", "3m7i9x1", "Администратор", "admin@mail.ru", createGroupTest("Администраторы",0b1111111));
createUserTest("moderator", "3m7i9x1", "Модератор", "moderator@mail.ru", createGroupTest("Модераторы",0b1101011));

//readTest($group);
//loginTest("user", "pass");
//removeTest();

?>