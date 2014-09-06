<?php
require_once("../shared/auth.php");
$page_title = "Доступ запрещен – Сето";
include_once("../parts/header.php");
?>
    <link rel="stylesheet" href="/css/pages/403.css">
    <div class="forbidden">
        <div class="forbidden__error-code">Ошибка 403:</div>
        <div class="forbidden__description">Доступ запрещен</div>
    </div>

<?php include_once("../parts/footer.php"); ?>