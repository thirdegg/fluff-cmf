<?php

abstract class TemplateField {

    protected $id;
    protected $name;
    protected $template;
    protected $position;
            
    function __construct($template) {
        $this->id = -1;
        $this->template = $template;
        $this->position = -1;
    }
    
    public function getId() {return $this->id;}
    
    public function getName() {return $this->name;}

    public function getType() {return get_class($this);}

    public function getPosition() {return $this->position;}

    public function setName($name) {$this->name=$name;}

    public function setPosition($position) {$this->position=$position;}

    static function getById($id) {
        $result = DataBase::getValueByPidAndParam($id, "type");
        if (!$result) return null;
        return $result::getById($id);
    }
    
    public function delete() {
        DataBase::deleteById($this->id);
    }

    public function isArray() {
        return false;
    }

    public function save() {
        if ($this->id==-1) {
            
            //проверить дупликаты полей
            
            $this->id = DataBase::createNewRow("model", "templatefield",$this->template);
            DataBase::createNewRow("name", $this->name, $this->id);
            DataBase::createNewRow("type", get_class($this), $this->id);
            DataBase::createNewRow("position", $this->getPosition(), $this->id);
        } else {
            DataBase::updateValueByPidAndParam("name", $this->name, $this->id);
            DataBase::updateValueByPidAndParam("type", get_class($this), $this->id);
            DataBase::updateValueByPidAndParam("position", $this->getPosition(), $this->id);
        }
        return $this;
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

?>