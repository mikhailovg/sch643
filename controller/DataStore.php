<?php
/**
 * Created by PhpStorm.
 * User: Yura
 * Date: 07.09.14
 * Time: 14:10
 */

class DataStore {

    private $vars=array();

    public function set($key,$data){
        $this->vars[$key]=$data;
    }

    public function get($key){
        return $this->vars[$key];
    }
} 