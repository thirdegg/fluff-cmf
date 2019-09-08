<?php

class StringField extends TemplateField {

    protected $isArray;
    protected $isNullable;
    protected $isUnique;

    public function __construct($template) {
        parent::__construct($template);
    }

    public function isNullable() {return $this->isNullable;}
    public function isArray() {return $this->isArray;}
    public function isUnique() {return $this->isUnique;}

    public function setIsArray($isArray) {$this->isArray=$isArray;}
    public function setUnique($isUnique) {$this->isUnique = $isUnique;}
    public function setIsNullable($isNullable) {$this->isNullable = $isNullable;}

    static function getById($id) {
        $parent = DataBase::getPidById($id);
        $result = DataBase::getAllByPid($id);
        if (sizeof($result)==0) return null; 
        $intfield = new StringField($parent);
        $intfield->id = $id;
        foreach ($result as $item) {
            switch ($item["param"]) {
                case "name":
                    $intfield->setName($item["value"]);
                    break;
                case "array":
                    $intfield->setIsArray(($item["value"] === 'true'));
                    break;
                case "nullable":
                    $intfield->setIsNullable(($item["value"] === 'true'));
                    break;
                case "unique":
                    $intfield->setUnique(($item["value"] === 'true'));
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
            DataBase::createNewRow("array", ($this->isArray)?"true":"false", $this->id);
            DataBase::createNewRow("nullable", ($this->isNullable)?"true":"false", $this->id);
            DataBase::createNewRow("unique", ($this->isUnique)?"true":"false", $this->id);
        } else {
            parent::save();
            DataBase::updateValueByPidAndParam("array", ($this->isArray)?"true":"false", $this->id);
            DataBase::updateValueByPidAndParam("nullable", ($this->isNullable)?"true":"false", $this->id);
            DataBase::updateValueByPidAndParam("unique", ($this->isUnique)?"true":"false", $this->id);
        }
        return $this;
    }

    public function toArray() {
        $array = array();
        $array["id"] = $this->id;
        $array["name"] = $this->name;
        $array["type"] = $this->getType();
        $array["template"] = $this->template;
        $array["isArray"] = $this->isArray;
        $array["isNullable"] = $this->isNullable;
        $array["isUnique"] = $this->isUnique;
        $array["position"] = $this->position;
        return $array;
    }

    public function toJson() {
        return json_encode($this->toArray());
    }

}
