<?php
include_once("../../support/connectBD.php");
require_once("../../shared/auth.php");

if (!isLoggedIn()) {
    header("Location: /403.php");
    die();
}

$parentId = $_POST["parentId"];
$name = $_POST["name"];
$title = $_POST["title"];
$layout = "1";
$status = "draft";
$date = date('Y/m/d H:i:s');

$stmt = $db->prepare("INSERT INTO page(name, title, layoutNumber, creationDate, status, parent_id) VALUES (?, ?, ?, ?, ?, ?)");
$stmt -> bind_param("ssidsi", $name, $title, $layout, $date, $status, $parentId);
$stmt->execute();
$stmt->close();
?>