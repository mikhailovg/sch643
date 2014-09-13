<?php

header('Content-Type: application/json');

class AdminController {

    private $settings;

    function __construct($settings) {
        $this->settings=$settings;
        include_once("./entites/dto/PageDto.php");
        include_once("./entites/Page.php");
        include_once("./entites/dto/LayoutDto.php");
        include_once("./entites/Layout.php");
    }

    public function getPagesByParent($params){
        $page = new Page();
        $db = $this->settings->get("db");

        $parentId = $params->get("parentId");


        if (intval($parentId) !== 0) {
            $stmt = $db->prepare("SELECT id, name, title, filePath, layoutNumber, creationDate, status, parent_id FROM page where parent_id=?");
            $stmt -> bind_param("i", $parentId);
        } else {
            $query = "SELECT id, name, title, filePath, layoutNumber, creationDate, status, parent_id FROM page where parent_id IS NULL";
            $stmt = $db->prepare($query);
        }
        $stmt->bind_result($page->id, $page->name, $page->title, $page->filePath, $page->layoutNumber, $page->creationDate, $page->status, $page->parentId);

        $stmt->execute();



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
        $stmt->close();
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

    public function addNode($params){
        $db = $this->settings->get("db");

        $name = $params->get("name");
        $title = $params->get("title");
        $layout = "1";
        $status = "node";
        $date = date('Y/m/d H:i:s');

        $stmt = $db->prepare("INSERT INTO page(name, title, layoutNumber, creationDate, status) VALUES (?, ?, ?, ?, ?)");
        $stmt -> bind_param("ssids", $name, $title, $layout, $date, $status);
        $stmt->execute();
        $stmt->close();
    }
}
?>