<?php
include_once("../../support/connectBD.php");
include_once("../../../globalVars.php");
require_once("../../shared/auth.php");

if (!isLoggedIn()) {
    header("Location: /403.php");
    die();
}

$nodeId =  $_POST["nodeId"];
$sectionId =  $_POST["sectionId"];
$htmlContent =  $_POST["htmlContent"];
$status = "active";
$filePath = $absolute_path . "/php/pages/custom/" . $sectionId . ".php";

$stmt = $db->prepare("UPDATE page set filePath=?, status=? where id=?");
$stmt -> bind_param("ssi", $filePath, $status, $sectionId);
$stmt->execute();
$stmt->close();

ini_set('display_errors', 'On');
error_reporting(E_ALL);
$fp = fopen($filePath, 'w');

if (false === $fp) {
    throw new RuntimeException('Unable to open file for writing');
}

$write=fwrite($fp, $htmlContent);
if(!$write){
    echo 'error writing';
}
fclose($fp);
?>