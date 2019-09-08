<?php

class Page {

    private $id;
    private $url;
    private $filepath;
    private $name;
    private $lastedit;
    private $cache;
    private $params;
    
    public function __construct() {
        $this->id = -1;
    }
    
    public function getId() {return $this->id;}
    public function getUrl() {return $this->url;}
    public function getFilePath() {return $this->filepath;}
    public function getName() {return $this->name;}
    public function getLastEdit() {return $this->lastedit;}
    public function getParams() {return $this->params;}  
    public function isCache() {return $this->cache;}
    
    public function setUrl($url) {
        preg_match("/^".$url."/", "");
        $this->url = $url;
    }
    public function setFilePath($filepath) {$this->filepath = $filepath;}
    public function setName($name) {$this->name = $name;}
    public function setLastEdit($lastedit) {$this->lastedit = $lastedit;}
    public function setIsCache($cache) {$this->cache = $cache;}
    public function setParams($params) {$this->params = $params;}
    
    static function getById($id) {
        $result = DataBase::getAllByPid($id);
        if (sizeof($result)==0) return null;
        $page = new Page();
        $page->id = $id;
        foreach ($result as $item) {
            $page->$item["param"] = $item["value"];
        }
        return $page;
    }

    static function getByURL($url) {
        $pages = Page::getAllPages();
        if (sizeof($pages)==0) return null;
        foreach ($pages as $page) {
            $re = "/^".$page->getUrl()."$/";
            if (preg_match($re, $url)) {
               preg_match_all($re, $url, $matches, PREG_SET_ORDER, 0);
               $page->setParams($matches);
               return $page;
            }
        }
        return null;
        
    }

    static function getAllPages($offset=0,$limit=100) {
        $result = DataBase::getIdsByParamValue("model","page",$offset,$limit);
        if (sizeof($result)==0) return null;
        $pages = array();
        foreach ($result as $mod) {
            $page = Page::getById($mod);
            array_push($pages,$page);
        }
        return $pages;
    }
    
    public function save() {
        if ($this->id==-1) {
            $this->id = DataBase::createNewRow("model", "page");
            DataBase::createNewRow("url", $this->url, $this->id);
            DataBase::createNewRow("filepath", $this->filepath, $this->id);
            DataBase::createNewRow("name", $this->name, $this->id);
            DataBase::createNewRow("lastedit", $this->lastedit, $this->id);
            DataBase::createNewRow("cache", ($this->cache)?"true":"false", $this->id);
        } else {
            DataBase::updateValueByPidAndParam("url",$this->url, $this->id);
            DataBase::updateValueByPidAndParam("filepath",$this->filepath, $this->id);
            DataBase::updateValueByPidAndParam("name",$this->name, $this->id);
            DataBase::updateValueByPidAndParam("lastedit",$this->lastedit, $this->id);
            DataBase::updateValueByPidAndParam("cache", ($this->cache)?"true":"false", $this->id);
        }
        
        return $this;
    }
    
    public function delete() {
        DataBase::deleteById($this->id);
    }
    
}

?>