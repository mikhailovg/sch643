<?php
/**
 * Created by PhpStorm.
 * User: Yura
 * Date: 07.09.14
 * Time: 11:44
 */

namespace dto;

//класс для обмена между клиентом и сервером
class PageDto {

    //id из бд
    public $id;
    //название страницы
    public $name;
    //название вкладки
    public $title;
    //содержимое html страницы
    public $htmlContent;
    //номер макета, из которого была создана страница
    public $layoutNumber;
    //дата создания
    public $creationDate;
    //активна, удалена, черновик
    public $status;


    public function map(&$page){
        $this->id=$page->id;
        $this->name=$page->name;
        $this->title=$page->title;
        $this->htmlContent=file_get_contents($page->filePath);
        $this->layoutNumber=$page->layoutNumber;
        $this->creationDate=$page->creationDate;
        $this->status=$page->status;
    }

} 