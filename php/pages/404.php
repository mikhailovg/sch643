<?php
require_once("../shared/auth.php");
$page_title = "Нет такой страницы – Сето";
include_once("../parts/header.php");
?>
    <link rel="stylesheet" href="/css/pages/404.css">
    <div class="page-not-found">
        <div class="page-not-found__error-code">Ошибка 404:</div>
        <div class="page-not-found__description">Нет такой страницы</div>
    </div>

<?php include_once("../parts/footer.php"); ?>