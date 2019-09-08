<?php

class ObjectList {

    private $template;

    private $queryParams = array();

    private $expression = null;
    private $offset = 0;
    private $size = 100;

    private $orderBy;
    private $asc;

    private function __construct() {}

    public static function select($name) {
        $objlist = new ObjectList();
        $template = Template::getByName($name);
        if ($template==null) throw new Exception("Template not found");
        $objlist->template = $template->getId();
        return $objlist;
    }

    public function where($expression) {
        preg_match("/\(?\)?(?:(?:`(?:\\'|\\`|[^`']+)` ?(?:<|>|=|LIKE) ?'(?:\\'|\\`|[^`']*)')\(?\)? ?(?:AND|OR)? ?\(?\)?)+/", $expression, $output_array);
        if (!isset($output_array) || strlen($output_array[0])!=strlen($expression)) {
            throw new Exception("Invalid expression");
            return;
        }

        $expression = $this->replaceShortExp($expression);



        foreach ($this->andExp($expression) as $anditem) {

            $ids = $this->queryAndExecute($anditem[0]);
            if ($ids==null) {
                $expression = str_replace($anditem[0], "0", $expression);
                continue;
            }
            for ($i=0; $i<sizeof($ids); $i++) {$ids[$i] = "`id`='".$ids[$i]."'";}
            $ids = implode(" OR ", $ids);
            $expression = str_replace($anditem[0], "(".$ids.")", $expression);

        }
        $this->expression = $expression;



        return $this;
    }

    public function limit($offset,$size) {
        $this->offset = $offset;
        $this->size = $size;
        return $this;
    }


    public function orderBy($field,$asc) {
        $this->orderBy = $field;
        $this->asc = ($asc)?true:false;
        return $this;
    }

    public function replaceShortExp($expression) {
        $re = '/`((?:\\\\\'|\\\\`|[^`\'])+)` ?(=|<|>|LIKE) ?\'((?:\\\\\'|\\\\`|[^`\'])*)\'/';
        preg_match_all($re, $expression, $matches, PREG_SET_ORDER, 0);
        for ($i=0; $i<sizeof($matches); $i++) {
            $this->queryParams["param".$i] = $matches[$i][1];
            $this->queryParams["value".$i] = $matches[$i][3];
            $re = "d".($i+1).".`param` = :param".$i." AND d".($i+1).".`value` ".$matches[$i][2]." :value".$i." AND d".($i+1).".`pid` = d0.`pid`";
            $expression = str_replace($matches[$i][0], $re, $expression);
        }
        return $expression;
    }

    public function andExp($expression) {
        $re = "/(?:d[0-9]+\.`param` ?(?:=|<|>|LIKE) ?:param[0-9]+ AND d[0-9]+\.`value` ?(?:=|<|>|LIKE) ?:value[0-9]+ AND d[0-9]+\.`pid` ?(?:=|<|>|LIKE) ?d[0-9]+\.`pid` AND )*d[0-9]+\.`param` ?(?:=|<|>|LIKE) ?:param[0-9]+ AND d[0-9]+\.`value` ?(?:=|<|>|LIKE) ?:value[0-9]+ AND d[0-9]+\.`pid` ?(?:=|<|>|LIKE) ?d[0-9]+\.`pid`/";
        preg_match_all($re, $expression, $matches, PREG_SET_ORDER, 0);
        return $matches;
    }

    public function queryAndExecute($expression) {
        $from = array();
        $values = array();
        $from[] = "`".DB_TABLE."` as d0";
        $from[] = "`".DB_TABLE."` as t1";
        $re = "/(?:(d[0-9]+)\.`param`)/";
        preg_match_all($re, $expression, $matches, PREG_SET_ORDER, 0);
        foreach ($matches as $item) {
            $from[] = "`".DB_TABLE."` as ".$item[1];
        }
        $re = "/(?::((?:param|value)[0-9]+))/";
        preg_match_all($re, $expression, $matches, PREG_SET_ORDER, 0);
        foreach ($matches as $item) {
            $values[$item[1]] = $this->queryParams[$item[1]];
        }

        $template = " AND d0.`pid` = t1.`id` AND t1.`pid` = :table";
        $values["table"] = $this->template;

        $query = "SELECT DISTINCT d0.`pid` FROM ".implode(", ", $from)." WHERE ".$expression.$template;
        return DataBase::getInstance()->queryGet($query, $values);
    }

    public function execute() {

        $queryParams = array();
        if ($this->expression==null) $queryParams["table"] = $this->template;
        $ids = DataBase::getInstance()->queryGet($this->generateOrderQuery(),$queryParams);

        if (sizeof($ids)==0) return array();
        $result = array();
        foreach ($ids as $id) {
            $result[] = FluffObject::getById($this->template, $id);
        }
        $joe = $result;
        return $joe;
    }


    private function generateOrderQuery() {
        $this->expression = str_replace("`id`", "d1.`pid`", $this->expression);
        $query = "SELECT DISTINCT d1.`pid` FROM `".DB_TABLE."` as t1, `".DB_TABLE."` as d1, `".DB_TABLE."` as d2 WHERE ".((isset($this->orderBy))?"d1.`param`='".$this->orderBy."' AND ":"")."(".(($this->expression==null)?"d1.`pid` = t1.`id` AND t1.`pid` = :table":$this->expression).") AND d2.`param` = 'model' AND d2.`value` = 'object' AND d2.`id` = d1.`pid` ".((isset($this->orderBy))?"ORDER BY d1.`value` ".(($this->asc)?"ASC":"DESC"):"")." LIMIT ".$this->offset.",".$this->size;

        return $query;
    }

}

?>