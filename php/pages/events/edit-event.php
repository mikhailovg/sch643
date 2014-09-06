<?php

include_once("../../support/connectBD.php");
require_once("../../shared/auth.php");

if (!isLoggedIn()) {
header("Location: /403");
die();
}

include_once("../../support/dateFormat.php");

    $idEvent = $_GET["id"];
    $dateStartBlock = "";
    $dateFinishBlock = "";
    $titleBlock = "";
    $descriptionBlock = "";
    $infoBlock = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $dateStartBlock = $_POST['dateStart'];
    $dateFinishBlock = $_POST['dateFinish'];
    $titleBlock = $_POST['title'];
    $descriptionBlock = $_POST['description'];
    $infoBlock = $_POST['info'];

    if (isset($_POST['id']) && !empty($_POST["id"])) {
        $idEvent = $_POST['id'];
        $stmt = $db->prepare("UPDATE event SET date_start = ?, date_finish = ?, title = ?, description = ?, info = ? WHERE id = ?");
        $stmt -> bind_param('sssssi', $dateStartBlock, $dateFinishBlock, $titleBlock, $descriptionBlock, $infoBlock, $idEvent);
    }
    else{
        $stmt = $db->prepare("INSERT INTO event (date_start, date_finish, title, description, info) VALUES (?,?,?,?,?)");
        $stmt -> bind_param('sssss', $dateStartBlock, $dateFinishBlock, $titleBlock, $descriptionBlock, $infoBlock);
    }
    $stmt->execute();
    $stmt->fetch();
    header("Location: /events");
}
$page_title = "Редактирование события";
include_once("../../parts/header.php");
?>
<script src="/js/pages/events/events.js"></script>
<link href="/css/parts/template.css" rel="stylesheet" >
<link href="/css/pages/events/events.css" rel="stylesheet" >

<div class="template__columns">
    <div class="template__left-column">
        <div class="editEvent">

<?php

    if($_SERVER['REQUEST_METHOD'] == 'GET'){

        if (isset($_GET['id'])) {
            $stmt = $db->prepare("SELECT date_start, date_finish, title, description, info  FROM event WHERE id = ?");
            $stmt->bind_param('i', $idEvent);
            $stmt->execute();
            $stmt->bind_result($dateStartBlock, $dateFinishBlock, $titleBlock, $descriptionBlock, $infoBlock);
            $stmt->fetch();
        }
?>
    <div class="editEvent__header">
        <?php
            if(isset($_GET['id'])){
                echo "Редактирование события";
            } else {
                echo "Добавление события";
            }
?>
    </div>

        <form action="<? echo $currentUrl?>" enctype="application/x-www-form-urlencoded" method="POST">
    <div class="editEvent__titleBlock">
        <label class="editEvent__label">Название</label>
        <input type="text" class="editEvent__titleInput" name = "title" value='<?php echo addcslashes($titleBlock,"'")?>'>
    </div>

    <div class="editEvent__dateBlock">
        <label class="editEvent__label">Дата</label>
       <label class="editEvent__labelDateStart">C</label> <input type="text" class="editEvent__date editEvent__dateStartInput" readonly name = "dateStart" value="<?php echo $dateStartBlock?>">
        <label class="editEvent__labelDateFinish">по</label> <input type="text" class="editEvent__date editEvent__dateFinishInput" readonly name = "dateFinish" value="<?php echo $dateFinishBlock?>">
    </div>

    <div class="editEvent__titleBlock">
        <label class="editEvent__label">Описание</label>
        <input type="text" class="editEvent__descriptionInput" name = "description" value='<?php echo addcslashes($descriptionBlock,"'")?>'>
    </div>

    <div class="editEvent__infoBlock">
        <label class="editEvent__label">Полная информация</label>
        <textarea class="editEvent__infoInput" name = "info">
            <?php echo $infoBlock?>
        </textarea>
    </div>
<input type="hidden" name="id" value="<? echo $idEvent ?>">
        <button class="editEvent_button" type="submit">Опубликовать событие</button>
        </form>
<?php
    }
?>
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

<?php
include_once("../../parts/footer.php");
?>


