<?php
include_once("../../../entites/dto/PageDto.php");
include_once("../../../entites/Page.php");
include_once("../../../entites/dto/LayoutDto.php");
include_once("../../../entites/Layout.php");
include_once("../../support/connectBD.php");

$page = new Page();

$parentId  = $_POST["parentId"];

if (intval($parentId) !== 0) {
    $stmt = $db->prepare("SELECT id, name, title, filePath, layoutNumber, creationDate, status, parent_id FROM page where parent_id=?");
    $stmt -> bind_param("i", $parentId);
} else {
    $query = "SELECT id, name, title, filePath, layoutNumber, creationDate, status, parent_id FROM page where parent_id IS NULL";
    $stmt = $db->prepare($query);
}
$stmt->execute();
$stmt->bind_result($page->id, $page->name, $page->title, $page->filePath, $page->layoutNumber, $page->creationDate, $page->status, $page->parentId);


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
header('Content-Type: application/json');
echo json_encode($pages/*,JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE*/);
?>