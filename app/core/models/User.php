<?php

class User {

    private $id;
    private $login;
    private $username;
    private $email;
    private $group;

    public function __construct() {
        $this->id=-1;
    }
    
    public function getId() {
        return $this->id;
    }

    public function getLogin() {
        return $this->login;
    }
    
    public function getUsername() {
        return $this->username;
    }

    public function getEmail() {
        return $this->email;
    }
    
    public function getGroup() {
        return Group::getById($this->group);
    }
    
    public function setLogin($login) {
        $this->login = $login;
    }
    
    public function setUsername($username) {
        $this->username = $username;
    }

    public function setEmail($email) {
        $this->email = $email;
    }
    
    public function setGroup($group) {
        $this->group = $group;
    }

    public static function authorize($login,$password) {
        $query = "SELECT lo.`pid` FROM `".DB_TABLE."` as lo, `".DB_TABLE."` as pas WHERE lo.`param` = 'login' AND lo.`value` = :login AND pas.`param`= 'passhash' AND pas.`value` = :passhash AND lo.`pid` = pas.`pid`";
        $id = DataBase::getInstance()->queryGet($query, array("login"=>$login,"passhash"=>md5($password.User::getSolt())), PDO::FETCH_COLUMN)[0];
        if (!$id || sizeof($id)==0) return false;
        $_SESSION[SESSION_USER] = $id;
        return true;
    }
    
    public static function getCurrent() {
        if (!isset($_SESSION[SESSION_USER])) return null;
        return User::getById($_SESSION[SESSION_USER]);
    }

    public static function logout() {
        unset($_SESSION[SESSION_USER]);
    }

    
    static function getById($id) {
        $query = "SELECT * FROM `".DB_TABLE."` WHERE `pid` = (SELECT `id` FROM `".DB_TABLE."` WHERE `id`=:id AND `param`='model' AND `value`='user')";
        $result = DataBase::getInstance()->queryGet($query, array("id"=>$id), PDO::FETCH_ASSOC);
        if (!$result || sizeof($result)==0) return null;
        $user = new User();
        $user->id = $id;
        foreach ($result as $item) {
            switch ($item["param"]) {
                case "login":
                    $user->login=$item["value"];
                    break;
                case "username":
                    $user->username=$item["value"];
                    break;
                case "email":
                    $user->email=$item["value"];
                    break;
                case "group":
                    $user->group=$item["value"];
                    break;
                default:
                    break;
            };
        }
        return $user;
    }

    static function getByLogin($login) {
        $query = "SELECT d2.`pid` FROM `".DB_TABLE."` as d1, `".DB_TABLE."` as d2 WHERE d1.`param`='model' AND d1.`value`='user' AND d2.`param`='login' AND d2.`value`=:login AND d1.`id` = d2.`pid`";
        $result = DataBase::getInstance()->queryGet($query, array("login"=>$login))[0];
        if (!$result || sizeof($result)==0) return null;
        return User::getById($result);
    }
    
    private static function getSolt() {
        $solt = DataBase::getInstance()->queryGet("SELECT `value` FROM `".DB_TABLE."` WHERE `param`='solt' AND `pid`=-1")[0];
        if ($solt==null) {
            $solt = Random::str(32);
            DataBase::getInstance()->queryPost("INSERT INTO `".DB_TABLE."` (`id`, `pid`, `param`, `value`) VALUES (NULL, '-1', 'solt', '".$solt."');");
        }
        return $solt;
    }
   
    public function newPassword($oldpassword,$newpassword) {
        $query = "SELECT `id` FROM `".DB_TABLE."` WHERE `param`='passhash' AND `pid`=:pid AND `value`=:value";
        $id = DataBase::getInstance()->queryGet($query,array("pid"=>$this->id,"value"=>md5($oldpassword.User::getSolt())))[0];
        if (!$id || sizeof($id)==0) {
            throw new Exception("Incorrect old password");
        }
        $query = "UPDATE `".DB_TABLE."` SET `value` = :newpass WHERE `id`=:id;";
        DataBase::getInstance()->queryPost($query,array("id"=>$id,"newpass"=>md5($newpassword.User::getSolt())));
    }

    public function save($pass) {
        if ($this->id==-1) {
            
            if (null != User::getByLogin($this->username)) {
                throw new Exception("User already exists");
            }
            
            DataBase::getInstance()->queryPost("INSERT INTO `".DB_TABLE."` (`id`, `pid`, `param`, `value`) VALUES (NULL, '-1', 'model', 'user');",array());
            
            $id = DataBase::getInstance()->lastInsertId();
            
            $query = "INSERT INTO `".DB_TABLE."` (`id`, `pid`, `param`, `value`) VALUES (NULL, :pid, :param, :value);";
            DataBase::getInstance()->queryPost($query,array("pid"=>$id,"param"=>"login","value"=>$this->login));
            DataBase::getInstance()->queryPost($query,array("pid"=>$id,"param"=>"group","value"=>$this->group));
            DataBase::getInstance()->queryPost($query,array("pid"=>$id,"param"=>"passhash","value"=>md5($pass.User::getSolt())));
            DataBase::getInstance()->queryPost($query,array("pid"=>$id,"param"=>"username","value"=>$this->username));
            DataBase::getInstance()->queryPost($query,array("pid"=>$id,"param"=>"email","value"=>$this->email));
            
            $this->id = $id;
        } else {
            $query = "UPDATE `".DB_TABLE."` SET `value` = :value WHERE `pid`=:pid AND `param`=:param; ";
            DataBase::getInstance()->queryPost($query,array("pid"=>$this->id,"param"=>"login","value"=>$this->login));
            DataBase::getInstance()->queryPost($query,array("pid"=>$this->id,"param"=>"group","value"=>$this->group));
            DataBase::getInstance()->queryPost($query,array("pid"=>$this->id,"param"=>"username","value"=>$this->username));
            DataBase::getInstance()->queryPost($query,array("pid"=>$this->id,"param"=>"email","value"=>$this->email));
        }
        return $this;
    }
    
    public function delete() {
        DataBase::getInstance()->queryPost("DELETE FROM `".DB_TABLE."` WHERE `pid`=:id",array(":id"=>$this->id));
        DataBase::getInstance()->queryPost("DELETE FROM `".DB_TABLE."` WHERE `id`=:id",array(":id"=>$this->id));
    }
}

?>