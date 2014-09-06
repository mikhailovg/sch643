<?php
include_once("../../support/connectBD.php");
require_once("../../shared/auth.php");

if (!isLoggedIn()) {
    header("Location: /403");
    die();
}
$stmt = $db->prepare("DELETE FROM business WHERE id = ?");
$stmt -> bind_param('i', $_POST["id"]);
$stmt->execute();
$stmt->fetch();
header("Location: /business");
?>