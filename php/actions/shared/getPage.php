<?include_once("../../../entites/dto/PageDto.php");
include_once("../../../entites/Page.php");
include_once("../../../entites/dto/LayoutDto.php");
include_once("../../../entites/Layout.php");
include_once("../../support/connectBD.php");
$page = new Page();
$query = "SELECT * FROM page where id=?";
$stmt = $db->prepare($query);
$stmt->bind_param("i", $_GET["id"]);
$stmt->bind_result($page->id, $page->name, $page->title, $page->filePath, $page->layoutNumber, $page->creationDate, $page->status, $page->parentId);
$stmt->execute();
$pages = array();
while ($stmt->fetch()) {
    $addPage = new Page();
    $addPage->id = $page->id;
    $addPage->name = $page->name;
    $addPage->title = $page->title;
    $addPage->filePath = $page->filePath;
    $addPage->layoutNumber = $page->layoutNumber;
    $addPage->creationDate = $page->creationDate;
    $addPage->status = $page->status;
    $pageDto = new \dto\PageDto();
    $pageDto = $pageDto->map($page);
    array_push($pages, $pageDto);

}
header('Content-Type: application/json');
echo json_encode($pages);
?>