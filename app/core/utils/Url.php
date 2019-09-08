<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Url
 *
 * @author User
 */
class Url {
    
    public static function baseHref() {
        $href = '//'.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']);
        if ($href[strlen($href)-1]!='/') $href=$href.'/';
        return $href;
    }
    
}
?>