<?php


class DataBase {

    private $charset = "UTF8";
    private $pdo;

    protected static $_instance; 
    
    private function __construct() {
        $dsn = "mysql:host=".DB_HOST.";dbname=".DB_NAME.";charset=$this->charset";
        $opt = array(
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_PERSISTENT => true,
            PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => true,
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
        );
        $this->pdo = new PDO($dsn, DB_USER, DB_PASSWORD, $opt);
        $this->pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        
        $this->pdo->exec("SET NAMES 'utf8'");
        $this->pdo->exec("SET CHARACTER SET 'utf8'");
        
    }

    public static function getInstance() {
        if (self::$_instance === null) {
            self::$_instance = new self;   
        }
        return self::$_instance;
    }
    
    public function getConnection() {
        return $this->pdo;
    }
            
    public function queryGet($query,$params = array(),$fetchmethod = PDO::FETCH_COLUMN) {
        $stmt = $this->pdo->prepare($query);
        $data = $stmt->execute($params);
        if ($data) {
            while ($row = $stmt->fetchAll($fetchmethod)) {
                return $row;
            }
        } else {
            throw new Exception();
        }
    }

    public function queryPost($query,$params = array()) {
        $stmt = $this->pdo->prepare($query);
        $stmt->execute($params);
    }

    public function lastInsertId() {
        return $this->pdo->lastInsertId();
    }
    
    public static function createNewRow($param,$value,$pid=-1) {
        $query = "INSERT INTO `".DB_TABLE."` (`id`, `pid`, `param`, `value`) VALUES (NULL, :pid, :param, :value); ";
        DataBase::getInstance()->queryPost($query, array("pid"=>$pid,"param"=>$param,"value"=>$value));
        return DataBase::getInstance()->lastInsertId();
    }
    
    public static function updateValueByPidAndParam($param,$value,$pid) {
        $query = "UPDATE `".DB_TABLE."` SET `value` = :value WHERE `pid`=:pid AND `param`=:param; ";
        DataBase::getInstance()->queryPost($query, array("pid"=>$pid,"param"=>$param,"value"=>$value)); 
    }
    
    public static function getAllByPid($pid) {
        $query = "SELECT * FROM `".DB_TABLE."` WHERE `pid`=:pid; ";
        return DataBase::getInstance()->queryGet($query, array("pid"=>$pid), PDO::FETCH_ASSOC);
    }

    public static function getPidById($pid) {
        $query = "SELECT `pid` FROM `".DB_TABLE."` WHERE `id`=:id;";
        return DataBase::getInstance()->queryGet($query, array("id"=>$pid), PDO::FETCH_ASSOC)[0];
    }

    public static function getValueByPidAndParam($pid,$param) {
        $query = "SELECT `value` FROM `".DB_TABLE."` WHERE `pid`=:pid AND `param` = :param; ";
        return DataBase::getInstance()->queryGet($query, array("pid"=>$pid,"param"=>$param))[0];
    }
    
    public static function getIdsByParamValue($param,$value,$offset=0,$size=1000,$pid=-1) {
        $query = "SELECT `id` FROM `".DB_TABLE."` WHERE `param`=:param AND `value`=:value AND `pid`=:pid LIMIT :offset,:size; ";
        return DataBase::getInstance()->queryGet($query, array("pid"=>$pid,"param"=>$param,"value"=>$value,"offset"=>$offset,"size"=>$size));
    }
    
    public static function getPidByChildAndParentParamValue($parentParam,$parentValue,$childParam,$childValue) {
        $query = "SELECT d2.`pid` FROM `".DB_TABLE."` as d1, `".DB_TABLE."` as d2 WHERE d1.`param`=:pparam AND d1.`value`=:pvalue AND d2.`param`=:cparam AND d2.`value`=:cvalue AND d1.`id` = d2.`pid`";
        return DataBase::getInstance()->queryGet($query, array("pparam"=>$parentParam,"pvalue"=>$parentValue,"cparam"=>$childParam,"cvalue"=>$childValue));
    }

    public static function getPidByChildAndParentPidParamValue($parentParam,$parentValue,$childParam,$childValue,$pid) {
        $query = "SELECT d2.`pid` FROM `".DB_TABLE."` as d1, `".DB_TABLE."` as d2 WHERE d1.`param`=:pparam AND d1.`value`=:pvalue AND d2.`param`=:cparam AND d2.`value`=:cvalue AND d1.`id` = d2.`pid` AND `d1`.pid = :pid";
        return DataBase::getInstance()->queryGet($query, array("pparam"=>$parentParam,"pvalue"=>$parentValue,"cparam"=>$childParam,"cvalue"=>$childValue,"pid"=>$pid));
    }

    public static function getObjectIdByIdAndTemplate($id, $template) {
        $query = "SELECT o1.`id` FROM `".DB_TABLE."` as t1, `".DB_TABLE."` as o1 WHERE t1.`id` = :template AND t1.`param`= 'model' AND t1.`value` = 'template' AND o1.`pid`=t1.`id` AND o1.`param`='model' AND o1.`value` = 'object' AND o1.`id` = :id LIMIT 0,1";
        return DataBase::getInstance()->queryGet($query, array("id"=>$id,"template"=>$template))[0];
    }

    public static function deleteById($id) {
        $query = "DELETE FROM `".DB_TABLE."` WHERE `id`=:id;";
        DataBase::getInstance()->queryPost($query, array("id"=>$id));
        DataBase::deleteByPid($id);
    }

    public static function deleteByPid($pid) {
        $query = "DELETE FROM `".DB_TABLE."` WHERE `pid`=:pid;";
        DataBase::getInstance()->queryPost($query, array("pid"=>$pid));
    }

}

?>