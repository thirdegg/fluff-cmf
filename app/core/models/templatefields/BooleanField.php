<?php

class BooleanField extends TemplateField {
    
    public function __construct($template) {
        parent::__construct($template);
    }

    static function getById($id) {
        $parent = DataBase::getPidById($id);
        $result = DataBase::getAllByPid($id);
        if (sizeof($result)==0) return null; 
        $intfield = new BooleanField($parent);
        $intfield->id = $id;
        foreach ($result as $item) {
            switch ($item["param"]) {
                case "name":
                    $intfield->setName($item["value"]);
                    break;
                case "position":
                    $intfield->setPosition($item["value"]);
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
        return $array;
    }

    public function toJson() {
        return json_encode($this->toArray());
    }

}
