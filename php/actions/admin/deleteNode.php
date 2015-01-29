<?php
include_once("../../support/connectBD.php");
require_once("../../shared/auth.php");

if (!isLoggedIn()) {
    header("Location: /403.php");
    die();
}

$filePath='';
$id = $_POST["id"];

$stmt = $db->prepare("SELECT filePath from page where id=?");
$stmt -> bind_param("i", $id);
$stmt->bind_result($filePath);
$stmt->execute();

$filePath = $stmt->fetch();
$stmt->close();

$stmt = $db->prepare("DELETE from page where id=?");
$stmt -> bind_param("i", $id);
$stmt->execute();
if(!is_null($page->filePath) && file_exists($page->filePath))
    unlink($filePath);
$stmt->close();
?>