<?php

class SetField extends TemplateField {
    
    private $params;

    public function __construct($template) {
        parent::__construct($template);
    }

    public function isArray() {
        return true;
    }

    public function setParams($array) {$this->params=$array;}

    public function save() {
        if ($this->id==-1) {
            parent::save();
            DataBase::createNewRow("params", json_encode($this->params),$this->id);
            return $this;
        } else {
            parent::save();
            DataBase::updateValueByPidAndParam("params",json_encode($this->params), $this->id);
            return $this;
        }
    }

    static function getById($id) {
        $parent = DataBase::getPidById($id);
        $result = DataBase::getAllByPid($id);
        if (sizeof($result)==0) return null; 
        $intfield = new SetField($parent,array());
        $intfield->id = $id;
        foreach ($result as $item) {
            switch ($item["param"]) {
                case "name":
                    $intfield->setName($item["value"]);
                    break;
                case "position":
                    $intfield->setPosition($item["value"]);
                    break;
                case "params":
                    $intfield->setParams(json_decode($item["value"]));
                    break;
                default:
                    break;
            }
        }
        return $intfield;
    }

    public function toArray() {
        $array = array();
        $array["id"] = $this->id;
        $array["name"] = $this->name;
        $array["type"] = $this->getType();
        $array["template"] = $this->template;
        $array["position"] = $this->position;
        $array["params"] = $this->params;
        return $array;
    }

    public function toJson() {
        return json_encode($this->toArray());
    }

}
