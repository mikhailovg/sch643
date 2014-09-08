<?php


class AdminController {

    private $settings;

    function __construct($settings) {
        $this->settings=$settings;
        include_once("./entites/dto/PageDto.php");
        include_once("./entites/Page.php");
        include_once("./entites/dto/LayoutDto.php");
        include_once("./entites/Layout.php");
    }

    public function getPages(){
        $page = new Page();
        $db = $this->settings->get("db");

        $query = "SELECT id, name, title, filePath, layoutNumber, creationDate, status FROM page";
        $stmt = $db->prepare($query);
        $stmt->execute();
        $stmt->bind_result($page->id, $page->name, $page->title, $page->filePath, $page->layoutNumber, $page->creationDate, $page->status);

        $pages = array();
        while($stmt->fetch()){
            $addPage = new Page();
            $addPage->id = $page->id;
            $addPage->name = $page->name;
            $addPage->title = $page->title;
            $addPage->filePath = $page->filePath;
            $addPage->layoutNumber = $page->layoutNumber;
            $addPage->creationDate = $page->creationDate;
            $addPage->status = $page->status;
            $pageDto=new \dto\PageDto();
            $pageDto=$pageDto->map($page);
            array_push($pages, $pageDto);
        }
        echo json_encode($pages,JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    }

    public function getLayouts(){
        $db = $this->settings->get("db");
        $layout = new Layout();
        $query = "SELECT id, name, title, filePath FROM layout";
        $stmt = $db->prepare($query);
        $stmt->execute();
        $stmt->bind_result($layout->id, $layout->name, $layout->title, $layout->filePath);
        $layouts = array();
        while($stmt->fetch()){
            $addLayout = new Layout();
            $addLayout->id = $layout->id;
            $addLayout->name = $layout->name;
            $addLayout->title = $layout->title;
            $addLayout->filePath = $layout->filePath;
            $layoutDto=new \dto\LayoutDto();
            $layoutDto=$layoutDto->map($addLayout);
            array_push($layouts, $layoutDto);
        }
        echo json_encode($layouts,JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    }
}
?>