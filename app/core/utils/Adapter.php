<?php

class Adapter {

    var $fields;
    var $array;

    public function setClass($class) {
        $this->fields = get_class_vars($class);
    }

    public function setArray($array) {
        $this->array = $array;
    }

}