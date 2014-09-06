<?
require_once("../../shared/db.php");
require_once("../../shared/auth.php");

if (!isLoggedIn()) {
    header("Location: /403");
    die();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $db_table_name = $_POST["db_table_name"];
    $name_file = $_POST['name_file'];
    $description = $_POST['description'];

    if (isset($_POST["id_document"]) && !empty($_POST["id_document"])) {

        $id_document = $_POST["id_document"];
        $stmt = $db->prepare("UPDATE $db_table_name SET name_file = ?, description = ? WHERE id = ?");
        $stmt -> bind_param('ssi', $name_file, $description, $id_document);
    }
    else{

        $file_path = basename($_FILES['file']['name']);
        $file_upload_path = __DIR__. "/../../../uploads/files/" . $db_table_name. "/" . $file_path;
        if(file_exists($file_upload_path)){
            $file_upload_path = __DIR__. "/../../../uploads/files/" . $db_table_name. "/" .time(). $file_path;
        }
        copy($_FILES['file']['tmp_name'], $file_upload_path);

        $stmt = $db->prepare("INSERT INTO $db_table_name (name_file, file_path, description) VALUES (?,?,?)");
        $stmt -> bind_param('sss', $name_file, $file_path, $description);
    }
    $stmt->execute();
    $stmt->fetch();
    $stmt->close();
    header("Location: /$db_table_name");

}

$page_title = "Редактирование ". ($_GET["type"] ==='service'? "Услуг" : "Литературных произведений") ." – Сето";
$css_files = array("/css/parts/template.css", "/css/pages/documents/edit-document.css");
$js_files = array("/js/pages/documents/edit-document.js");
include_once("../../parts/header.php");

if($_SERVER['REQUEST_METHOD'] == 'GET'){

$db_table_name = $_GET["type"];
$name_file = "";
$description = "";
$idUpload = true;
    if (isset($_GET['id'])) {
        $idUpload = false;
        $id_document = $_GET["id"];
        $stmt = $db->prepare("SELECT name_file, description FROM $db_table_name WHERE id = ?");
        $stmt->bind_param('i', $id_document);
        $stmt->execute();
        $stmt->bind_result($name_file, $description);
        $stmt->fetch();
    }
?>
    <div class="template__columns">
        <div class="template__left-column">
            <form class="edit-document" action="<?= $currentUrl?>" enctype="multipart/form-data" method="POST">
                <?php
                    if(!isset($_GET["id"])){
                ?>
                <div class="edit-document__file">
                    <h3>Документ</h3>
                    <input type="file" name="file">
                </div>
                <?php
                    }
                ?>
                <div class="edit-document__name">
                    <h3>Название документа</h3>
                    <input class="edit-document__name-input" name="name_file" value="<?= $name_file ?>">
                </div>
                <div class="edit-document__description">
                    <h3>Описание документа</h3>
                    <textarea id="edit-document__description-textarea" name="description">
                        <?= $description ?>
                    </textarea>
                </div>
                <input type="hidden" name="db_table_name" value="<?= $db_table_name ?>">
                <input type="hidden" name="id_document" value="<?= $id_document ?>">
                <input type="submit" value="Опубликовать">
            </form>
        </div>
        <div class="template__right-column">

        </div>
    </div>
<? }
   include_once("../../parts/footer.php"); ?>