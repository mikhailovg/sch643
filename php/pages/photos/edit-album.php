<?
require_once("../../shared/db.php");
require_once("../../shared/auth.php");

if (!isLoggedIn()) {
    header("Location: /403");
    die();
}

if (isset($_GET["album_id"])) {
    $album_id = intval($_GET["album_id"]);
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $description = $_POST["description"];
    if ($album_id) {
        $stmt = $db->prepare("UPDATE album SET name = ?, description = ? WHERE id = ?");
        $stmt->bind_param("ssi", $name, $description, $album_id);
    } else {
        $stmt = $db->prepare("INSERT INTO album (name, description) VALUES (?, ?)");
        $stmt->bind_param("ss", $name, $description);
    }
    $stmt->execute();
    $stmt->close();
    header("Location: /album/".$album_id);
    die();
} else {
    if ($album_id) {
        $stmt = $db->prepare("SELECT name, description FROM album WHERE id = ?");
        $stmt->bind_param("i", $album_id);
        $stmt->execute();
        $stmt->bind_result($name, $description);
        $not_found = !$stmt->fetch();
        $stmt->close();
        if ($not_found) {
            header("Location: /404");
            die();
        }
    }
    $page_title = $album_id ? "Редактировать альбом – Сето" : "Создать альбом – Сето";
    $css_files  = array("/css/parts/template.css", "/css/parts/icon.css", "/css/pages/photos/edit-album.css");
    $js_files   = array("/js/pages/photos/edit-album.js");
    include_once("../../parts/header.php");
    ?>
    <div class="template__columns">
        <div class="template__left-column">
            <form class="edit-album" method="POST" enctype="multipart/form-data">
                <div class="edit-album__name">
                    <h3>Название альбома</h3>
                    <input class="edit-album__name-input" name="name" value="<?=$name?>">
                </div>
                <div class="edit-album__description">
                    <h3>Описание албома</h3>
                    <textarea id="edit-album__description-textarea" name="description"><?=$description?></textarea>
                </div>
                <input type="submit" class="edit-album__submit" value="<?=$album_id ? "Сохранить изменения" : "Создать альбом"?>">
            </form>
        </div>
        <div class="template__right-column">

        </div>
    </div>
    <?
    include_once("../../parts/footer.php");
}
?>