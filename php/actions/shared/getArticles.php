<?php
include_once("../../support/connectBD.php");
include_once("../../../entites/Article.php");
include_once("../../../entites/PagingResponse.php");
require_once("../../shared/auth.php");


$limit = 10;
$limit = $_GET["limit"];
$pageNumber = $_GET["pageNumber"];
$search = $_GET["search"];
$numberOfPages = 0;
if (is_null($pageNumber)) {
    //если инициализируется страница с нговостями
    $stmt = $db->prepare("select count(*) from article");
    $stmt->execute();
    $countAllArticles = 0;
    $stmt->bind_result($countAllArticles);

    if (intval($countAllArticles) > 0) {
        $numberOfPages = round($countAllArticles / $limit)+1;
    }
    $pageNumber = 0;
    $stmt->close();
}
$startRow = $pageNumber * $limit;
$lastRow = $pageNumber * $limit + $limit;
if(empty($search)){

    $stmt1 = $db->prepare("select * from article limit ?,?");
    $stmt1->bind_param('ii', $startRow, $lastRow);
}
else {

    $stmt1 = $db->prepare("SELECT count(*) FROM article WHERE UPPER(title) like UPPER('%?%') OR UPPER(text) like UPPER('%?%')");
    $stmt1->bind_param("ss", $search, $search);
    $stmt1->execute();
    $stmt1->bind_result($countAllArticles);
    if (intval($countAllArticles) > 0) {
        $numberOfPages = round($countAllArticles / $limit)+1;
    }
    $stmt1->close();
    $stmt1 = $db->prepare("SELECT * FROM article WHERE UPPER(title) like UPPER('%?%') OR UPPER(text) like UPPER('%?%') ORDER BY date DESC limit ?,?");
    $stmt1->bind_param("ssii", $search, $search, $startRow, $lastRow);
}


$stmt1->execute();
$art = new Article();
$stmt1->bind_result(
    $art->id,
    $art->title,
    $art->announcement,
    $art->text,
    $art->date,
    $art->original_image_path,
    $art->small_image_thumbnail_path,
    $art->medium_image_thumbnail_path,
    $art->big_image_thumbnail_path,
    $art->youtube_video_url);

$arts = array();
while ($stmt1->fetch()) {
    $addArt = new Article();
    $addArt->id = $art->id;
    $addArt->title = $art->title;
    $addArt->announcement = $art->announcement;
    $addArt->text = $art->text;
    $addArt->date = $art->date;
    $addArt->original_image_path = $art->original_image_path;
    $addArt->small_image_thumbnail_path = $art->small_image_thumbnail_path;
    $addArt->medium_image_thumbnail_path = $art->medium_image_thumbnail_path;
    $addArt->original_image_path = $art->original_image_path;
    $addArt->big_image_thumbnail_path = $art->big_image_thumbnail_path;
    $addArt->youtube_video_url = $art->youtube_video_url;

    array_push($arts, $addArt);
}
$resp = new PagingResponse();
$resp->articles = $arts;
$resp->limit = $limit;
$resp->numberOfPages = $numberOfPages;
$resp->isAdmin = isLoggedIn();
header('Content-Type: application/json');
echo json_encode($resp);

?>