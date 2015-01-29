<?php
include_once("../../support/connectBD.php");
include_once("../../support/dateFormat.php");
require_once("../../shared/youtube.php");
require_once("../../shared/auth.php");
if (!isLoggedIn()) {
    header("Location: /403.php");
    die();
}
$id = $_POST["articleId"];
$title=$_POST["title"];
$announcement="";
$text=$_POST["title"];
$original_image_path=$_POST["title"];
$small_image_thumbnail_path=$_POST["title"];
$medium_image_thumbnail_path="";
$big_image_thumbnail_path="";
$youtube_video_url=$_POST["youtube_video_url"];
$date = date('Y/m/d H:i:s');
$currentUrl = $_SERVER["REQUEST_URI"];
$oldImagePath = false;

if (strpos($text, "\n")!=null) {
    $announcement = substr($text, 0, strpos($text, "\n"));

}
else if (substr($text, 0, 500)!=null)
    $announcement = substr($text, 0, 500) . "...";
else if (substr($text, 0, 400)!=null)
    $announcement = substr($text, 0, 400) . "...";
else if (substr($text, 0, 300)!=null)
    $announcement = substr($text, 0, 300) . "...";
else if (substr($text, 0, 50)!=null)
    $announcement = substr($text, 0, 50) . "...";

$paths = upload_and_resize_image($_FILES["image"], array("original", "40x40", "145x145", "220x"));

if ($paths != null) {
    $original_image_path          = $paths["original"];
    $small_image_thumbnail_path   = $paths["40x40"];
    $medium_image_thumbnail_path  = $paths["145x145"];
    $big_image_thumbnail_path     = $paths["220x"];
}

if(is_null($id) || !isset($_POST["id"])){
    $stmt = $db->prepare("INSERT INTO article (title, announcement, text, date, original_image_path, small_image_thumbnail_path, medium_image_thumbnail_path, big_image_thumbnail_path, youtube_video_url) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt -> bind_param('sssssssss', $title, $announcement, $text, $date, $original_image_path, $small_image_thumbnail_path, $medium_image_thumbnail_path, $big_image_thumbnail_path, $youtube_video_url);
} else {
    if ($_POST['img'] == null) {
        $stmt = $db->prepare("UPDATE article SET title=?, announcement=?, text=?, date=?, original_image_path=?, small_image_thumbnail_path=?, medium_image_thumbnail_path=?, big_image_thumbnail_path=?, youtube_video_url=? WHERE id=?");
        $stmt -> bind_param('ssssssssss', $title, $announcement, $text, $date, $original_image_path, $small_image_thumbnail_path, $medium_image_thumbnail_path, $big_image_thumbnail_path, $youtube_video_url, $id);
    }
    else {
        $stmt = $db->prepare("UPDATE article SET title=?, announcement=?, text=?, date=?, youtube_video_url=? WHERE id=?");
        $stmt -> bind_param('ssssss', $title, $announcement, $text, $date, $youtube_video_url, $id);
    }
    $stmt->execute();
    $stmt->close();

}




?>