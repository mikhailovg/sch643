<?php


class Page{

    //id из бд
    public $id;
    //название страницы
    public $name;
    //название вкладки
    public $title;
    //путь до файла с html
    public $filePath;
    //номер макета, из которого была создана страница
    public $layoutNumber;
    //дата создания
    public $creationDate;
    //активна, удалена, черновик
    public $status;

}
