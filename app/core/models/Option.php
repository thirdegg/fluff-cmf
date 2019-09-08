<?php

class Option {
    
    private $id;
    private $param;
    private $value;
    
    public function __construct() {
        $this->id=-1;
    }
    
    public function getId() {
        return $this->id;
    }
    
    public function getParam() {
        return $this->param;
    }
    
    public function getValue() {
        return $this->value;
    }

    public function setParam($name) {
        $this->param = $name;
    }
    
    public function setValue($value) {
        $this->value = $value;
    }
    
    static function getById($id) {
        $result = DataBase::getAllByPid($id);
        if (sizeof($result)==0) return null;
        $option = new Option();
        $option->id = $id;
        foreach ($result as $item) {
            switch ($item["param"]) {
                case "param":
                    $option->setParam($item["value"]);
                    break;
                case "value":
                    $option->setValue($item["value"]);
                    break;
                default:
                    break;
            }
        }
        return $option;
    }

    static function getByParam($name) {
        $result = DataBase::getPidByChildAndParentParamValue("model", "option", "param", $name)[0];
        if (sizeof($result)==0) return null;
        return Option::getById($result);
    }

    static function getAll($offset=0, $size=100) {
        $result = DataBase::getIdsByParamValue("model", "option", $offset, $size);
        if (sizeof($result)==0) return array();
        $options = array();
        foreach ($result as $mod) {
            $option = Option::getById($mod);
            array_push($options,$option);
        }
        return $options;
    }

    public function toArray() {
        $array = array();
        $array["id"] = $this->getId();
        $array["param"] = $this->getParam();
        $array["value"] = $this->getValue();
        return $array;
    }

    public function toJson() {
        return json_encode($this->toArray());
    }

    static function getAllJson($offset=0, $size=100) {
        $options = array();
        foreach (Option::getAll($offset,$size) as $mod) {
            array_push($options,$mod->toArray());
        }
        return json_encode($options);
    }

    function delete() {
        DataBase::deleteById($this->id);
    }

    public static function deleteAll() {
        foreach (Option::getAll(0, 1000) as $item) {
            $item->delete();
        }
    }

    public function save() {
        if ($this->id==-1) {
            $this->id = DataBase::createNewRow("model", "option");
            DataBase::createNewRow("param", $this->param, $this->id);
            DataBase::createNewRow("value", $this->value, $this->id);
        } else {
            DataBase::updateValueByPidAndParam("param",$this->param, $this->id);
            DataBase::updateValueByPidAndParam("value",$this->value, $this->id);
        }
        return $this;
    }
    
}
