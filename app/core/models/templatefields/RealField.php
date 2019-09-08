<?php

class RealField extends TemplateField {

    protected $isNullable;

    public function __construct($template) {
        parent::__construct($template);
    }

    public function isNullable() {return $this->isNullable;}
    public function setIsNullable($isNullable) {$this->isNullable = $isNullable;}

    static function getById($id) {
        $parent = DataBase::getPidById($id);
        $result = DataBase::getAllByPid($id);
        if (sizeof($result)==0) return null; 
        $intfield = new RealField($parent);
        $intfield->id = $id;
        foreach ($result as $item) {
            switch ($item["param"]) {
                case "name":
                    $intfield->setName($item["value"]);
                    break;
                case "nullable":
                    $intfield->setIsNullable(($item["value"] === 'true'));
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

    public function save() {
        if ($this->id==-1) {
            parent::save();
            DataBase::createNewRow("nullable", ($this->isNullable)?"true":"false", $this->id);
        } else {
            parent::save();
            DataBase::updateValueByPidAndParam("nullable", ($this->isNullable)?"true":"false", $this->id);
        }
        return $this;
    }

    public function toArray() {
        $array = array();
        $array["id"] = $this->id;
        $array["name"] = $this->name;
        $array["type"] = $this->getType();
        $array["template"] = $this->template;
        $array["isNullable"] = $this->isNullable;
        $array["position"] = $this->position;
        return $array;
    }

    public function toJson() {
        return json_encode($this->toArray());
    }

}
