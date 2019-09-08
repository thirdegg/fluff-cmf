<?php

class Group {

    private $id;
    private $name;
    private $privileges;

    public function __construct() {
        $this->id=-1;
    }
    
    public function getId() {
        return $this->id;
    }
    
    public function getName() {
        return $this->name;
    }

    public function getPrivileges() {
        return $this->privileges;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function setPrivileges($privileges) {
        $this->privileges = $privileges;
    }

    //биты
    //1 бит - редактирование групп пользователей
    //2 бит - редактирование пользователей
    //3 бит - редактирование шаблонов
    //4 бит - редактирование объектов
    //5 бит - редактирование страниц
    //6 бит - редактирование файлов
    //7 бит - редактирование опций

    public function isEditGroups() {
        if (($this->privileges&0b0000001)>0) return true;
        return false;
    }

    public function isEditUsers() {
        if (($this->privileges&0b0000010)>0) return true;
        return false;
    }

    public function isEditTemplates() {
        if (($this->privileges&0b0000100)>0) return true;
        return false;
    }

    public function isEditObject() {
        if (($this->privileges&0b0001000)>0) return true;
        return false;
    }

    public function isEditPages() {
        if (($this->privileges&0b0010000)>0) return true;
        return false;
    }

    public function isEditFiles() {
        if (($this->privileges&0b0100000)>0) return true;
        return false;
    }

    public function isEditOptions() {
        if (($this->privileges&0b1000000)>0) return true;
        return false;
    }

    public function isAdministrator() {
        if (($this->privileges^0b1111111)==0) return true;
        return false;
    }

    static function getById($id) {
        $result = DataBase::getAllByPid($id);
        if (!$result || sizeof($result)==0) return null;
        $group = new Group();
        $group->id = $id;
        foreach ($result as $item) {
            switch ($item["param"]) {
                case "name":
                    $group->name=$item["value"];
                    break;
                case "privileges":
                    $group->privileges=$item["value"];
                    break;
                default:
                    break;
            };
        }
        return $group;
    }

    static function getByName($name) {
        $result = DataBase::getPidByChildAndParentParamValue("model", "group", "name", $name)[0];
        if (!$result || sizeof($result)==0) return null;
        return Group::getById($result);
    }
    
    static function getGroupsList($begin=0,$size=10) {
        $groups = array();
        $query = "SELECT `id` FROM `".DB_TABLE."` WHERE `param` = 'model' AND `value` = 'group' LIMIT :begin,:size";
        $gids = DataBase::getInstance()->queryGet($query,array("begin"=>$begin,"size"=>$size));
        foreach ($gids as $gid) {
            $groups[] = Group::getById($gid);
        }
        return $groups;
    }
    
    function getUsers() {
        $users = array();
        $query = "SELECT d2.`id` FROM `".DB_TABLE."` as d1,`".DB_TABLE."` as d2 WHERE d1.`param` = 'group' AND d1.`value` = :gid AND d2.`param` = 'model' AND d2.`value` = 'user' AND d1.`pid`=d2.`id`";
        $uids = DataBase::getInstance()->queryGet($query,array("gid"=>$this->id));
        for ($i=0;$i<sizeof($uids);$i++) {
            $users[] = User::getById($uids[$i]);
        }
        return $users;
    }


    function delete() {
        DataBase::deleteById($this->id);
    }

    public function save() {
        if ($this->id==-1) {
            
            if (null != Group::getByName($this->name)) {
                throw new Exception("Group already exists");
            }
            
            $this->id = DataBase::createNewRow("model", "group");
            DataBase::createNewRow("name", $this->name, $this->id);
            DataBase::createNewRow("privileges", $this->privileges, $this->id);
        } else {
            DataBase::updateValueByPidAndParam("name",$this->name, $this->id);
            DataBase::updateValueByPidAndParam("privileges", $this->privileges, $this->id);
        }
        
        return $this;
    }

}

?>