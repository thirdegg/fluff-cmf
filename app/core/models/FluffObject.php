<?php

class FluffObject implements ArrayAccess  {

    private $id;
    private $template;
    private $data;

    public function __construct($template) {
        $this->id = -1;
        $this->template = $template;
        $this->data = array();
    }
    
    ////////// магические методы
    
    public function offsetSet($offset, $value) {
        foreach ($this->getTemplate()->getFields() as $field) {
            if ($field->getName()==$offset) {
                if (method_exists($field,'isUnique') && $field->isUnique() && !$this->isUniqueValue($offset,$value)) throw new Exception("Unique field is duplicate");
                $this->data[$offset] = $value;
                return;
            }
        }
        throw new Exception("Unknown field");
    }

    public function offsetUnset($offset) {
        unset($this->data[$offset]);
    }
    
    public function offsetExists($offset) {
        return isset($this->data[$offset]);
    }

    public function offsetGet($offset) {
        return $this->offsetExists($offset) ? $this->data[$offset] : null;
    }
    
    //////////

    private function getData() {
        return $this->data;
    }

    private function setData($data) {
        $this->data = $data;
    }


    public function getId() {
        return $this->id;
    }

    public function getTemplate() {
        return Template::getById($this->template);
    }

    public function isUniqueValue($param,$value) {
        $result = DataBase::getPidByChildAndParentPidParamValue("model", "object", $param, $value,$this->template);
        if (sizeof($result)==0) return true;
        foreach ($result as $mod) {
            if ($mod!=$this->getId()) return false;
        }
        return true;
    }

    static function count($template, $where=null) {
        if ($where==null) {
            return sizeof(ObjectList::select($template)->limit(0, 10000)->execute());
        } else {
            return sizeof(ObjectList::select($template)->where($where)->limit(0, 10000)->execute());
        }
    }


    static function getAllByTemplate($template,$offset=0,$size=200) {

        $result = DataBase::getIdsByParamValue("model", "object", $offset, $size, $template);

        if (sizeof($result)==0) return array();
        $objects = array();
        foreach ($result as $mod) {
            $object = FluffObject::getById($template, $mod);
            array_push($objects,$object);
        }
        return $objects;
    }
    
    static function getById($template, $id) {
        $oid = DataBase::getObjectIdByIdAndTemplate($id,$template);
        if (sizeof($oid)==0) return null;
        $result = DataBase::getAllByPid($oid);
        if (sizeof($result)==0) return null;
        $object = new FluffObject($template);
        $object->id = $id;

        $data = array();
        $template = $object->getTemplate();
        foreach ($result as $var) {
            //hack
            $field = $template->getFieldByName($var["param"]);
            if ($field==null) continue;
            if ($field->getType() == "BooleanField") {
                $data[$var["param"]] = ($var["value"]);
            } else {
                if ($field->isArray()) $data[$var["param"]] = json_decode($var["value"]);
                else $data[$var["param"]] = $var["value"];
            }
        }
        $object->setData($data);
        return $object;

    }
    
    public function save() {
        if ($this->id==-1) {
            $this->id = DataBase::createNewRow('model', 'FluffObject', $this->getTemplate()->getId());
            foreach ($this->getTemplate()->getFields() as $field) {
                if ($field->isArray()) {
                    DataBase::createNewRow($field->getName(), json_encode($this->data[$field->getName()]), $this->id);
                } else {
                    DataBase::createNewRow($field->getName(), $this->data[$field->getName()],$this->id);
                }
            }
        } else {
            DataBase::deleteByPid($this->id);
            foreach ($this->getTemplate()->getFields() as $field) {
                if (sizeof(DataBase::getValueByPidAndParam($field->getName(),$this->id))>0) {
                    if ($field->isArray()) {
                        DataBase::updateValueByPidAndParam($field->getName(), json_encode($this->data[$field->getName()]), $this->id);
                    } else {
                        DataBase::updateValueByPidAndParam($field->getName(), $this->data[$field->getName()],$this->id);
                    }
                } else {
                    if ($field->isArray()) {
                        DataBase::createNewRow($field->getName(), json_encode($this->data[$field->getName()]), $this->id);
                    } else {
                        DataBase::createNewRow($field->getName(), $this->data[$field->getName()],$this->id);
                    }
                }
                
            }
        }
        return $this;
    }

    public function delete() {
        DataBase::deleteById($this->id);
    }

    public function toArray() {
        return array("id"=>$this->id,"data"=>$this->data);
    }

    public function toJson() {
        return json_encode($this->toArray());
    }

    public function getObjectString() {
        $result = array();
        foreach ($this->getTemplate()->getFields() as $field) {
            $result[] = $field->getName().":".print_r($this[$field->getName()], 1);
        }
        return implode("<br/>",$result);
    }



}


?>

