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
    public $htmlContent="";
    //номер макета, из которого была создана страница
    public $layoutNumber;
    //дата создания
    public $creationDate;
    //активна, удалена, черновик
    public $status;
    //
    public $parentId;


    public function map(&$page) {
        if ($page->filePath !== '' && !is_null($page->filePath) && file_exists($page->filePath)) {
            $this->htmlContent=file_get_contents($page->filePath);
        }
        $this->id=$page->id;
        $this->name=$page->name;
        $this->title=$page->title;
        $this->layoutNumber=$page->layoutNumber;
        $this->creationDate=$page->creationDate;
        $this->status=$page->status;
        $this->parentId=$page->parentId;

        return $this;
    }

} 