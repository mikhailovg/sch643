<?php
/**
 * Created by PhpStorm.
 * User: Yura
 * Date: 08.09.14
 * Time: 22:33
 */

namespace dto;


class LayoutDto {

    public $id;
    public $name;
    public $title;
    public $htmlContent;

    public function map(&$layout){
        $this->id=$layout->id;
        $this->name=$layout->name;
        $this->title=$layout->title;
        $this->htmlContent=file_get_contents($layout->filePath);
        return $this;
    }
} 