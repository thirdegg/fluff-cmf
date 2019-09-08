<?php

class ObjectField extends TemplateField {
    
    private $object;
    protected $isArray;
    protected $isNullable;

    public function __construct($template) {
        parent::__construct($template);
    }

    public function setObject($object) {$this->object = $object;}
    public function getObject() {return $this->object;}

    public function isNullable() {return $this->isNullable;}
    public function isArray() {return $this->isArray;}

    public function setIsArray($isArray) {$this->isArray=$isArray;}
    public function setIsNullable($isNullable) {$this->isNullable = $isNullable;}

    public function save() {
        if ($this->id==-1) {
            parent::save();
            DataBase::createNewRow("object", $this->object,$this->id);
            DataBase::createNewRow("array", ($this->isArray)?"true":"false", $this->id);
            DataBase::createNewRow("nullable", ($this->isNullable)?"true":"false", $this->id);
            return $this;
        } else {
            parent::save();
            DataBase::updateValueByPidAndParam("object",$this->object, $this->id);
            DataBase::updateValueByPidAndParam("array", ($this->isArray)?"true":"false", $this->id);
            DataBase::updateValueByPidAndParam("nullable", ($this->isNullable)?"true":"false", $this->id);
            return $this;
        }
        
    }

    static function getById($id) {
        $parent = DataBase::getPidById($id);
        $result = DataBase::getAllByPid($id);
        if (sizeof($result)==0) return null; 
        $intfield = new ObjectField($parent);
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
                case "position":
                    $intfield->setPosition($item["value"]);
                    break;
                case "object":
                    $intfield->setObject($item["value"]);
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
        $array["object"] = $this->object;
        $array["template"] = $this->template;
        $array["isArray"] = $this->isArray;
        $array["isNullable"] = $this->isNullable;
        $array["position"] = $this->position;
        return $array;
    }

    public function toJson() {
        return json_encode($this->toArray());
    }
    
}
