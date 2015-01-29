<?php
include_once("../../support/connectBD.php");
include_once("../../support/dateFormat.php");
include_once("../../../entites/Article.php");
$art=new Article();
$id= $_GET['articleId'];
$stmt = $db->prepare("select * from article where id=?");
$stmt -> bind_param('i', $id);
$stmt -> execute();
$stmt -> bind_result(
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
$stmt -> fetch();
$youtube_video_url_original = str_replace('embed/', 'watch?v=', $youtube_video_url);
$art->youtube_video_url_original;

header('Content-Type: application/json');
echo json_encode($art);
?>