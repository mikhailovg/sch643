<?
$db = new mysqli('localhost', 'root', '', 'school');
$db -> set_charset("utf8");

if ($db->connect_errno) {
    printf("Connect failed: %s\n", $mysqli->connect_error);
    exit();
}

?>