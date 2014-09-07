<?php
class AdminController {

    private $settings;

    function __construct($settings) {
        $this->settings=$settings;
    }

        public function getPages(){
            $page = $this->settings->get("Page");
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

                array_push($pages, $addPage);
            }
            echo json_encode($pages);
        }
}
?>