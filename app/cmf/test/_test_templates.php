<?php

require_once '../core/includes.php';

ini_set('display_errors', 1);

$tablenames = ["Таблица2","Таблица2","Таблица3","Таблица4","Таблица5"];

////////////////////////////// CREATE
function createTest($tablename) {
    
    $boolfieldname = "Булево";
    $intfieldname = "Число";
    $realfieldname = "ДробноеЧисло";
    $stringfieldname = "Строка";
    $textareafieldname = "ТекстовоеПоле";
    $setfieldname = "Список";
    $enumfieldname = "НесколькоИз";
    $filefieldname = "Файл";
    $objectfieldname = "Объект";
    
    try {
    
        echo "Создаем шаблон c именем ".$tablename."</br>";
        $template = new Template();
        $template->setName($tablename);
        $template->setDescription("Описание");
        $template->save();

        echo "Создаем поле шаблона c именем ".$boolfieldname."</br>";
        $boolfield = new BooleanField($template->getId());
        $boolfield->setName($boolfieldname);
        $boolfield->save();


        echo "Создаем поле шаблона c именем ".$intfieldname."</br>";
        $intfield = new IntegerField($template->getId());
        $intfield->setName($intfieldname);
        $intfield->save();

        echo "Создаем поле шаблона c именем ".$realfieldname."</br>";
        $realfield = new RealField($template->getId());
        $realfield->setName($realfieldname);
        $realfield->save();

        echo "Создаем поле шаблона c именем ".$stringfieldname."</br>";
        $stringfield = new StringField($template->getId());
        $stringfield->setName($stringfieldname);
        $stringfield->save();

        echo "Создаем поле шаблона c именем ".$textareafieldname."</br>";
        $textareafield = new StringField($template->getId());
        $textareafield->setName($textareafieldname);
        $textareafield->save();

        echo "Создаем поле шаблона c именем ".$setfieldname."</br>";
        $setfield = new StringField($template->getId());
        $setfield->setName($setfieldname);
        $setfield->save();

        echo "Создаем поле шаблона c именем ".$enumfieldname."</br>";
        $enumfield = new StringField($template->getId());
        $enumfield->setName($enumfieldname);
        $enumfield->save();

        echo "Создаем поле шаблона c именем ".$filefieldname."</br>";
        $filefield = new StringField($template->getId());
        $filefield->setName($filefieldname);
        $filefield->save();

        echo "Создаем поле шаблона c именем ".$objectfieldname."</br>";
        $objfield = new StringField($template->getId());
        $objfield->setName($objectfieldname);
        $objfield->save();

        echo "Сохранили"."</br>-</br>";
    } catch (Exception $e) {
        echo "Отловили ".$e->getMessage()."</br>-</br>";
    }
}

////////////////////////////// READ
function readTest($tablename) {
    echo "Пытаемся получить шаблон из базы"."</br>";
    $template = Template::getByName($tablename);
    echo "Имя: ".$template->getName()." Описание:".$template->getDescription()." Поля:</br>";
    foreach ($template->getFields() as $field) {
        echo "Поле: ".$field->getName()." Тип: ".$field->getType()."</br>";
    }

    echo "Готово</br>";
    echo "-</br>";
}

////////////////////////////// DELETE
function removeTest($tablename) {
    echo "Удаляем шаблон"."</br>";
    $template = Template::getByName($tablename);
    if ($template!=null) $template->delete();
    echo "Готово</br>";
    echo "-</br>";
}

foreach ($tablenames as $tablename) {
    createTest($tablename);
}

foreach ($tablenames as $tablename) {
    readTest($tablename);
}

foreach ($tablenames as $tablename) {
    removeTest($tablename);
}

?>
