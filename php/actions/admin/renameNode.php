<?php
include_once("../../support/connectBD.php");
require_once("../../shared/auth.php");

if (!isLoggedIn()) {
    header("Location: /403.php");
    die();
}

$id =  $_POST["id"];
$name =  $_POST["name"];

$stmt = $db->prepare("UPDATE page SET name=? where id=?");
$stmt -> bind_param("si", $name, $id);
$stmt->execute();
$stmt->close();
?>