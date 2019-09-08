<?php

require_once '../../core/includes.php';

ini_set('display_errors', 1);

$tablename = "Товары";

function preSetting($tablename) {
    echo "Предварительно создаем шаблон ".$tablename."</br>";
    echo "Создаем шаблон c именем ".$tablename."</br>";
    $template = new Template();
    $template->setName($tablename);
    $template->setDescription("Товары для дома");
    $template->save();

    echo "Создаем поле шаблона c именем 'Название'</br>";
    $namefield = new StringField($template->getId());
    $namefield->setName("Название");
    $namefield->save();


    echo "Создаем поле шаблона c именем 'Цена'</br>";
    $pricefield = new IntegerField($template->getId());
    $pricefield->setName("Цена");
    $pricefield->save();

    echo "Сохранили</br>-</br>";
}
////////////////////////////// CREATE
function createTest($templatename) {
    
    $template = Template::getByName($templatename);
    
    $object = new FluffObject($template->getId());
    $object["Название"]="Тряпка половая";
    $object["Цена"]=200;
    $object->save();
    
    $object = new FluffObject($template->getId());
    $object["Название"]="Средство для мытья посуды";
    $object["Цена"]=250;
    $object->save();
    
    $object = new FluffObject($template->getId());
    $object["Название"]="Губка";
    $object["Цена"]=100;
    $object->save();
    
    $object = new FluffObject($template->getId());
    $object["Название"]="Порошок";
    $object["Цена"]=550;
    $object->save();

    $object = new FluffObject($template->getId());
    $object["Название"]="Скотч";
    $object["Цена"]=50;
    $object->save();        

    $object = new FluffObject($template->getId());
    $object["Название"]="Салфетки";
    $object["Цена"]=50;
    $object->save();            
            
}

////////////////////////////// READ
function readTest($tablename) {
    echo "Пытаемся получить объекты из шаблонов"."</br>";
    $template = Template::getByName($tablename);
    $objects = FluffObject::getAllByTemplate($template->getId());
    echo "Количество объектов: ".sizeof($objects)."</br>";
    foreach ($objects as $object) {
        foreach ($template->getFields() as $field) {
            echo $field->getName().": ".$object[$field->getName()].", ";
        }
        echo "</br>";
    }

    echo "Готово</br>";
    echo "-</br>";
}

////////////////////////////// UPDATE
function updateTest() {
    
}

////////////////////////////// DELETE
function removeTest($tablename) {
    echo "Удаляем объекты"."</br>";
    $template = Template::getByName($tablename);
    if ($template==null) return;
    $objects = FluffObject::getAllByTemplate($template->getId());
    foreach ($objects as $object) {
        $object->delete();
    }
    $template->delete();
    echo "Готово</br>";
    echo "-</br>";
}

function postSetting($tablename) {
    echo "Удаляем шаблон"."</br>";
    $template = Template::getByName($tablename);
    if ($template!=null) $template->delete();
    echo "Готово</br>";
    echo "-</br>";
}

removeTest($tablename);



?>
