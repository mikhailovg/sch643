<?
require_once("../../shared/db.php");
require_once("../../shared/auth.php");
require_once("../../shared/upload-and-resize-images.php");

if (!isLoggedIn()) {
    header("Location: /403");
    die();
}

// Если это редактирование фотографии, достаем ее из БД.
if (!empty($_GET["photo_id"])) {
    $photo_id = intval($_GET["photo_id"]);
    $stmt = $db->prepare("SELECT album_id, description, big_image_path FROM photo WHERE id = ?");
    $stmt->bind_param("i", $photo_id);
    $stmt->execute();
    // Все данные не нужны, только те, что будут светиться на форме.
    $stmt->bind_result($album_id, $description, $big_image_path);
    $stmt->fetch();
    $stmt->close();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Если это обновление фотографии, можно лишь изменить описание.
    if (isset($photo_id)) {
        $description = $_POST["description"];
        $stmt = $db->prepare("UPDATE photo SET description = ? WHERE id = ?");
        $stmt->bind_param("si", $description, $photo_id);
        $stmt->execute();
        $stmt->close();

    }
    // Иначе - это добавление одной или нескольких фоток.
    else {
        // В URL-е должен обязательно быть указан id альбома.
        assert(!empty($_GET["album_id"]));
        // Все фотки попадут в этот альбом.
        $album_id = intval($_GET["album_id"]);
        // С одним и тем же описанием.
        $description = $_POST["description"];
        // Но пути к уменьшенныйм, обрезанным копиям,
        // для каждой отдельной фотке будут разными.
        $paths = upload_and_resize_images($_FILES["files"], array("original", "40x40", "145x145", "640x"));
        foreach($paths as $paths) {
            if ($paths != null) {
                $original_image_path = $paths["original"];
                $micro_image_path    = $paths["40x40"];
                $mini_image_path     = $paths["145x145"];
                $big_image_path      = $paths["640x"];
                $stmt = $db->prepare("INSERT INTO photo (album_id, description, original_image_path, micro_image_path, mini_image_path, big_image_path) VALUES (?, ?, ?, ?, ?, ?)");
                $stmt->bind_param("isssss", $album_id, $description, $original_image_path, $micro_image_path, $mini_image_path, $big_image_path);
                $stmt->execute();
                $stmt->close();
            }
        }
    }
    header("Location: /album/".$album_id);
    die();
} else if ($_SERVER["REQUEST_METHOD"] == "GET") {

    $stmt = $db->prepare("SELECT name FROM album JOIN photo ON album.id = photo.album_id WHERE photo.id = ?");
    $stmt->bind_param("i", $album_id);
    $stmt->execute();
    $stmt->bind_result($album_name);
    $stmt->fetch();
    $stmt->close();

    $page_title =  $album_name." – Фотоальбомы – Сето";
    $css_files  = array("/css/parts/template.css", "/css/parts/icon.css", "/css/pages/photos/edit-photo.css");
    $js_files   = array("/js/pages/photos/edit-photo.js");
    include_once("../../parts/header.php");
?>
    <div class="template__columns">
        <div class="template__left-column">
            <div class="edit-photo">
                <form class="edit-photo__form" method="POST" enctype="multipart/form-data">
                    <div class="edit-photo__file" >
                        <h3 class="class="edit-photo__file-lable">Фотография</h3>
                        <? if (isset($photo_id)) { ?>
                            <div class="edit-photo__photo">
                                <img src="<?=$big_image_path?>">
                            </div>
                        <? } else { ?>
                            <input class="edit-photo__file" type="file" name="files[]" multiple="true">
                        <? } ?>
                    </div>
                    <div id="edit-photo__description" class="edit-photo__description">
                        <h3 class="edit-photo__description-label">Описание фотографии</h3>
                        <textarea name="description">
                            <?=$description?>
                        </textarea>
                    </div>
                    <input class="edit-photo__submit" type="submit" value="<?= $photo_id ? "Сохранить изменения" :  "Загрузить фото" ?>">
                </form>
            </div>
        </div>
        <div class="template__right-column"></div>
    </div>
<?
    include_once("../../parts/footer.php");
}
?>