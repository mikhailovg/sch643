<?php
class AdminController {

    private $settings;

    function __construct($settings) {
        $this->settings=$settings;
    }

        public function getPages(){
            /*$host='localhost';
            $database='school';
            $user='root';
            $pswd='';
            $db = new mysqli($host, $user, $pswd, $database);
            $db -> set_charset("utf8");
*/
            $id="";
            $title="";
            $name="";
            $filePath="";
            $layoutNumber="";
            $status="";
            $creationDate = date('Y/m/d H:i:s');
            $db = $this->settings->get("db");

            $query = "SELECT id, name, title, filePath, layoutNumber, creationDate, status FROM page";
            $stmt = $db->prepare($query);
            $stmt->execute();
            $stmt->bind_result($id, $name, $title, $filePath, $layoutNumber, $creationDate, $status);

            $pages = array();

            while($stmt->fetch()){
                $page = new stdClass;
                $page->id = $id;
                $page->name = $name;
                $page->title = $title;
                $page->filePath = $filePath;
                $page->layoutNumber = $layoutNumber;
                $page->creationDate = $creationDate;
                $page->status = $status;

                array_push($pages, $page);
            }
            echo json_encode($pages);
        }
}
?>