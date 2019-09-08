<?php

class Template {

    private $id;
    private $name;
    private $description;
    private $fields;
            
    function __construct() {
        $this->id = -1;
        $this->fields = array();
    }

    public function getId() {
        return $this->id;
    }
    
    public function getName() {
        return $this->name;
    }

    public function getDescription() {
        return $this->description;
    }
    
    public function setName($name) {
        $this->name = $name;
    }

    public function getFields() {
        return $this->fields;
    }

    public function getFieldByName($name) {
        foreach ($this->fields as $field) {
            if ($field->getName()==$name) return $field;
        }
        return null;
    }

    public function fieldsToArray() {
        $result = array();
        foreach ($this->fields as $field) {
            $result[] = $field->toArray();
        }
        return $result;
    }

    public function getFieldsJson() {
        return json_encode($this->fieldsToArray());
    }

    public function toArray() {
        $array = array();
        $array["id"] = $this->id;
        $array["name"] = $this->name;
        $array["description"] = $this->description;
        $array["fields"] = $this->fieldsToArray();
        return $array;
    }

    public function toJson() {
        return json_encode($this->toArray());
    }

    public function setDescription($description) {
        $this->description = $description;
    }
    
    public static function getById($id) {
        $result = DataBase::getAllByPid($id);
        if (!$result || sizeof($result)==0) return null;
        $template = new Template();
        $template->id = $id;
        foreach ($result as $item) {
            if ($item["param"]=="model" && $item["value"]=="templatefield") {
                $template->fields[] = TemplateField::getById($item["id"]);
                continue;
            }
            $template->$item["param"] = $item["value"];
        }
        usort($template->fields, function($a, $b){
            return ($a->getPosition() - $b->getPosition());
        });
        return $template;
    }
    
    public static function getByName($name) {
        $result = DataBase::getPidByChildAndParentParamValue("model", "template", "name", $name)[0];
        if (!$result || sizeof($result)==0) return null;
        return Template::getById($result);
    }

    
    public static function getAllTemplates($offset=0,$limit=15) {
        $result = DataBase::getIdsByParamValue("model","template",$offset,$limit);
        if (!$result || sizeof($result)==0) return array();
        $templates = array();
        foreach ($result as $mod) {
            $template = Template::getById($mod);
            array_push($templates,$template);
        }
        return $templates;
    }
    
    public function delete() {
        foreach (FluffObject::getAllByTemplate($this->getId()) as $object) {
            $object->delete();
        }
        
        foreach ($this->fields as $field) {
            $field->delete();
        }
        
        DataBase::deleteById($this->id);
    }

    public function save() {
        if ($this->id==-1) {
            
            if (null != Template::getByName($this->name)) {
                throw new Exception("Template already exists");
            }

            $this->id = DataBase::createNewRow("model", "template");
            DataBase::createNewRow("name", $this->name,$this->id);
            DataBase::createNewRow("description", $this->description,$this->id);
           
            return $this;
        } else {
            DataBase::updateValueByPidAndParam("name",$this->name, $this->id);
            DataBase::updateValueByPidAndParam("description",$this->description, $this->id);
            return $this;
        }
    }
    
}


?>