<?php

class FileField extends TemplateField {
    
    private $params;

    protected $isArray;
    protected $isNullable;

    public function __construct($template) {
        parent::__construct($template);
    }
    
    public function setParams($params) {$this->params=$params;}
    public function getParams() {return $this->params;}

    public function isNullable() {return $this->isNullable;}
    public function isArray() {return $this->isArray;}

    public function setIsArray($isArray) {$this->isArray=$isArray;}
    public function setIsNullable($isNullable) {$this->isNullable = $isNullable;}

    static function getById($id) {
        $parent = DataBase::getPidById($id);
        $result = DataBase::getAllByPid($id);
        if (sizeof($result)==0) return null; 
        $intfield = new FileField($parent);
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
                case "params":
                    $intfield->setParams($item["value"]);
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
            DataBase::createNewRow("params", $this->params,$this->id);
            DataBase::createNewRow("array", ($this->isArray)?"true":"false", $this->id);
            DataBase::createNewRow("nullable", ($this->isNullable)?"true":"false", $this->id);
            return $this;
        } else {
            parent::save();
            DataBase::updateValueByPidAndParam("params",$this->params, $this->id);
            DataBase::updateValueByPidAndParam("array", ($this->isArray)?"true":"false", $this->id);
            DataBase::updateValueByPidAndParam("nullable", ($this->isNullable)?"true":"false", $this->id);
            return $this;
        }

    }


    public function toArray() {
        $array = array();
        $array["id"] = $this->id;
        $array["name"] = $this->name;
        $array["type"] = $this->getType();
        $array["template"] = $this->template;
        $array["isArray"] = $this->isArray;
        $array["isNullable"] = $this->isNullable;
        $array["position"] = $this->position;
        $array["params"] = $this->params;
        return $array;
    }

    public function toJson() {
        return json_encode($this->toArray());
    }

    
}
