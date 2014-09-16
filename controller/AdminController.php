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
        $status = "draft";
        $date = date('Y/m/d H:i:s');

        $stmt = $db->prepare("INSERT INTO page(name, title, layoutNumber, creationDate, status) VALUES (?, ?, ?, ?, ?)");
        $stmt -> bind_param("ssids", $name, $title, $layout, $date, $status);
        $stmt->execute();
        $stmt->close();
    }

    public function addSection($params){
        $db = $this->settings->get("db");

        $parentId = $params->get("parentId");
        $name = $params->get("name");
        $title = $params->get("title");
        $layout = "1";
        $status = "draft";
        $date = date('Y/m/d H:i:s');

        $stmt = $db->prepare("INSERT INTO page(name, title, layoutNumber, creationDate, status, parent_id) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt -> bind_param("ssidsi", $name, $title, $layout, $date, $status, $parentId);
        $stmt->execute();
        $stmt->close();
    }
    
    public function renameNode($params){
        $db = $this->settings->get("db");

        $id = $params->get("id");
        $name = $params->get("name");

        $stmt = $db->prepare("UPDATE page SET name=? where id=?");
        $stmt -> bind_param("si", $name, $id);
        $stmt->execute();
        $stmt->close();
    }
    
    public function deleteNode($params){
        $db = $this->settings->get("db");

        $id = $params->get("id");

        $stmt = $db->prepare("DELETE from page where id=?");
        $stmt -> bind_param("i", $id);
        $stmt->execute();
        $stmt->close();
    } 
    
    public function renameSection($params){
        $db = $this->settings->get("db");

        $id = $params->get("id");
        $name = $params->get("name");

        $stmt = $db->prepare("UPDATE page SET name=? where id=?");
        $stmt -> bind_param("si", $name, $id);
        $stmt->execute();
        $stmt->close();
    }
    
    public function deleteSection($params){
        $db = $this->settings->get("db");
        $filePath='';
        $id = $params->get("id");

        $stmt = $db->prepare("SELECT filePath from page where id=?");
        $stmt -> bind_param("i", $id);
        $stmt->execute();
        $stmt->bind_result($filePath);
        $stmt->close();

        $stmt = $db->prepare("DELETE from page where id=?");
        $stmt -> bind_param("i", $id);
        $stmt->execute();
        $stmt->close();

        echo $filePath;
        unlink($filePath);
    } 
    
    public function updateSection($params){
        $db = $this->settings->get("db");

        $nodeId = $params->get("nodeId");
        $sectionId = $params->get("sectionId");
        $htmlContent = $params->get("filePath");
		$status = "active";
		$filePath = getcwd() . "\\php\\pages\\custom\\" . $sectionId . ".php";

        $stmt = $db->prepare("UPDATE page set filePath=?, status=? where id=?");
        $stmt -> bind_param("ssi", $filePath, $status, $sectionId);
        $stmt->execute();
        $stmt->close();

        ini_set('display_errors', 'On');
        error_reporting(E_ALL);

        echo "123_".is_writable($filePath);

        echo getcwd() . "____" . $filePath;
        $fp = fopen($filePath, 'w');

        if (false === $fp) {
            throw new RuntimeException('Unable to open file for writing');
        }

        $write=fwrite($fp, $htmlContent);
        if(!$write){
            echo 'error writing';
        }
        fclose($fp);
    } 
}	

?>
