<?php
/**
 * Created by PhpStorm.
 * User: Yura
 * Date: 07.09.14
 * Time: 12:47
 */

class AdminController {

        public function getPages($params){
            echo "get ".$params->get("number")." of pages";
        }
} 