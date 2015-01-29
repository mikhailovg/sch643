<?
    $host='localhost';
   /* $database='c67school';
    $user='c67admin';
    $pswd='lokiju123';*/
$database='school';
$user='root';
$pswd='';

    $db = new mysqli($host, $user, $pswd, $database);
    $db -> set_charset("utf8");
?>