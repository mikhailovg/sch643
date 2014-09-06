<?php
include_once("../../support/connectBD.php");
include_once("../../support/dateFormat.php");
require_once("../../shared/auth.php");

if (!isLoggedIn()) {
    header("Location: /403");
    die();
}
$idBusiness = $_GET["id"];
$nameBlock = "";
$profileBlock = "";
$contactBlock = "";
$infoBlock = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $nameBlock = $_POST['name'];
    $profileBlock = $_POST['profile'];
    $contactBlock = $_POST['contact'];
    $infoBlock = $_POST['info'];

    if (isset($_POST['id']) && !empty($_POST["id"])) {
        $idEvent = $_POST['id'];
        $stmt = $db->prepare("UPDATE business SET name = ?, profile = ?, contact = ?, info = ? WHERE id = ?");
        $stmt -> bind_param('ssssi', $nameBlock, $profileBlock, $contactBlock, $infoBlock,  $idBusiness);
    }
    else{
        $stmt = $db->prepare("INSERT INTO business (name, profile, contact, info) VALUES (?,?,?,?)");
        $stmt -> bind_param('ssss', $nameBlock, $profileBlock, $contactBlock, $infoBlock);
    }
    $stmt->execute();
    $stmt->fetch();
    header("Location: /business");
}
include_once("../../parts/header.php");
?>

<script src="/js/pages/business/business.js"></script>
<link href="/css/parts/template.css" rel="stylesheet" >
<link href="/css/pages/business/business.css" rel="stylesheet" >

<div class="template__columns">
    <div class="template__left-column">
        <div class="editBusiness">
<?php

    if($_SERVER['REQUEST_METHOD'] == 'GET'){

        if (isset($_GET['id'])) {
            $stmt = $db->prepare("SELECT name, profile , contact , info FROM business WHERE id = ?");
            $stmt->bind_param('i', $idBusiness);
            $stmt->execute();
            $stmt->bind_result($nameBlock, $profileBlock, $contactBlock, $infoBlock);
            $stmt->fetch();
        }
?>
        <div class="editBusiness__header">
            <?php
            if(isset($_GET['id'])){
                echo "Редактирование предприятия";
            } else {
                echo "Добавление предприятия";
            }
            ?>
        </div>

        <form action="<?= $currentUrl?>" enctype="application/x-www-form-urlencoded" method="POST">

            <div class="editBusiness__nameBlock">
                <label class="editBusiness__label">Название</label>
                <input type="text" class="editBusiness__nameInput" name = "name" value='<?php echo addcslashes($nameBlock,"'")?>'>
            </div>

            <div class="editBusiness__profileBlock">
                <label class="editBusiness__label">Профиль</label>
                <input type="text" class="editBusiness__profileInput" name = "profile" value='<?php echo addcslashes($profileBlock,"'")?>'>
            </div>

            <div class="editBusiness__contactBlock">
                <label class="editBusiness__label">Контакты</label>
                <textarea class="editBusiness__contactInput" name = "contact">
                    <?php echo $contactBlock?>
                </textarea>
            </div>

            <div class="editBusiness__infoBlock">
                <label class="editBusiness__label">Полная информация</label>
                <textarea class="editBusiness__infoInput" name = "info">
                    <?php echo $infoBlock?>
                </textarea>
            </div>

            <input type="hidden" name="id" value="<? echo $idBusiness ?>">
            <button class="editBusiness_button" type="submit">Опубликовать предприятие</button>
        </form>
        <? } ?>
        </div>
    </div>
    <div class="template__right-column">
        <div class="html">
            <a class="html__config-icon" href=""></a>
            <h3>Погода в Пскове</h3>
            <img src="/img/weather.png">
        </div>
    </div>
</div>
<?php include_once("../../parts/footer.php"); ?>