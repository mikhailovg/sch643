<?
require_once("../../shared/db.php");
require_once("../../shared/date.php");
require_once("../../shared/auth.php");

if (!isLoggedIn()) {
    header("Location: /403");
    die();
}
$photo_id = intval($_GET["photo_id"]);
assert($photo_id !== 0);

$stmt = $db->prepare("SELECT date_uploaded, album_id, album.name, photo.description, original_image_path, big_image_path FROM photo JOIN album ON album.id = photo.album_id WHERE photo.id = ?");
$stmt->bind_param("i", $photo_id);
$stmt->execute();
$stmt->bind_result($date_uploaded, $album_id, $album_name, $description, $original_image_path, $big_image_path);
$not_found = !$stmt->fetch();
$stmt->close();

if ($not_found) {
    header("Location: /404");
    die();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $stmt = $db->prepare("DELETE FROM photo WHERE id = ?");
    $stmt->bind_param("i", $photo_id);
    $stmt->execute();
    $stmt->close();
    header("Location: /album/".$album_id);
    die();
} elseif ($_SERVER["REQUEST_METHOD"] == "GET") {

    $page_title = "Удалить фотографию – Сето";
    $css_files  = array("/css/parts/template.css", "/css/parts/icon.css", "/css/pages/photos/delete-photo.css");
    $js_files   = array("/js/pages/photos/delete-photo.js");
    include_once("../../parts/header.php");
    ?>
    <div class="template__columns">
        <div class="template__left-column">
            <div class="delete-photo">
                <form class="delete-photo__form" method="POST" enctype="multipart/form-data">
                    <h3 class="delete-photo__album-name">
                        <a href="/album/<?=$album_id?>"><?=$album_name?></a>
                    </h3>
                    <div class="delete-photo__photo"><img src="<?=$big_image_path?>"></div>
                    <div class="delete-photo__details">
                        <div class="delete-photo__description"><?=$description?></div>
                        <div class="delete-photo__other-info">
                            <h5 class="delete-photo__date-uploaded"><?=format_date_with_month_name($date_uploaded)?></h5>
                            <h5 class="delete-photo__original-size-image" style="<?=$big_image_path === $original_image_path ? "display: none" : ""?>">
                                <a href="<?=$original_image_path?>">Оригинальный размер</a>
                            </h5>
                        </div>
                    </div>
                    <input class="delete-photo__submit" type="submit" value="Удалить фото">
                </form>
            </div>
        </div>
        <div class="template__right-column">

        </div>
    </div>
    <?
    include_once("../../parts/footer.php");
}
?>