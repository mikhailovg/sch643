<?php
include_once("../../support/connectBD.php");
require_once("../../shared/auth.php");

if (!isLoggedIn()) {
    header("Location: /403.php");
    die();
}

$name = $_POST["name"];
$title = $_POST["title"];
$layout = "1";
$status = "draft";
$date = date('Y/m/d H:i:s');

$stmt = $db->prepare("INSERT INTO page(name, title, layoutNumber, creationDate, status) VALUES (?, ?, ?, ?, ?)");
$stmt -> bind_param("ssids", $name, $title, $layout, $date, $status);
$stmt->execute();
$stmt->close();
?>