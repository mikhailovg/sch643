<?php
include_once("../../support/connectBD.php");
require_once("../../shared/auth.php");

if (!isLoggedIn()) {
    header("Location: /403");
    die();
}
$db_name = $_POST["db_name"];
$stmt = $db->prepare("DELETE FROM $db_name WHERE id = ?");
$stmt -> bind_param('i', $_POST["id"]);
$stmt->execute();
$stmt->fetch();
header("Location: /$db_name");
?>