<?
require_once("../../shared/db.php");
require_once("../../shared/auth.php");

$db_table_name = $_GET["type"];

$page_title = $db_table_name == "service" ? "Справочник услуг Сето" : "Литературные произведения – Сето";
$css_files = array("/css/parts/template.css", "/css/pages/documents/documents.css");
include_once("../../parts/header.php");


?>

<div class="template__columns">
    <div class="template__left-column">
        <div class="documents">
            <?php
                    if(isLoggedIn()){
                        ?>
            <a class="documents__add-document-icon" href="/<?= $db_table_name ?>/new"></a>
                <?php
                    }
            ?>
            <h3 class="documents__label"><?= $db_table_name == "service" ? "Услуги" : "Литература Сето" ?></h3>
            <ol class="documents__list">

                <?php

                $stmt = $db->prepare("SELECT id, name_file, file_path, description FROM $db_table_name ");
                $stmt->execute();
                $stmt->bind_result($id_document, $name_file, $file_path, $description);
                while($stmt->fetch()){
                ?>
                <li class="documents__document">
                    <?php
                    if(isLoggedIn()){
                        ?>
                    <a class="documents__edit-document-icon"  href="/<?= $db_table_name . "/" . $id_document ?>/edit"></a>
                    <span class="documents__delete-document-icon"></span>
                    <input type="hidden" value="<?= $id_document ?>" class="document__idBusiness">
                        <?php
                    }
                    ?>
                    <a class="documents__name" href="/document/download?file=<?= $file_path ?>&type=<?= $db_table_name ?>"><?= $name_file ?></a>
                    <p class="documents__description">
                        <?= $description ?>
                    </p>
                </li>
                    <?php
                }
                ?>
            </ol>
        </div>
    </div>
    <div class="template__right-column">
        <?
        $idEditOrLoadBlock = 4;
        include ('../../parts/html.php');
        ?>
    </div>
</div>

<?php
if(isLoggedIn()){
    ?>
<div id="document__deleteDialog" title="Удаление события" style="display: none">
    <form id = "document__deleteDialogForm" action = "/document/delete" enctype="application/x-www-form-urlencoded" method="POST">
        <input type="hidden" id="document__deleteDialogIdEvent" name = "id" value="">
        <input type="hidden" id="document__deleteDBTableName" name = "db_name" value="<?= $db_table_name ?>">
    </form>
    <p id="document__deleteDialogMessage">Вы уверены, что хотите удалить предприятие?</p>
</div>
<?
}
?>

<? include_once("../../parts/footer.php"); ?>
<script type="text/javascript" src="/js/pages/documents/documents.js"></script>