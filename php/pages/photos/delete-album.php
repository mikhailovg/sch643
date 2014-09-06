<?
require_once("../../shared/db.php");
require_once("../../shared/auth.php");

if (!isLoggedIn()) {
    header("Location: /403");
    die();
}
$album_id = intval($_GET["album_id"]);
assert($album_id !== 0);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $stmt = $db->prepare("DELETE FROM album WHERE id = ?");
    $stmt->bind_param("i", $album_id);
    $stmt->execute();
    $stmt->close();
    header("Location: /albums");
    die();
} else {
    $stmt = $db->prepare("SELECT name, album.description, count(photo.id)
                          FROM album
                          LEFT JOIN photo
                          ON album.id = photo.album_id
                          GROUP BY album.id, name, description
                          HAVING album.id = ?");
    $stmt->bind_param('i', $album_id);
    $stmt->execute();
    $stmt->bind_result($name, $description, $photos_count);
    $not_found = !$stmt->fetch();
    $stmt->close();

    if ($not_found) {
        header("Location: /404");
        die();
    }

    $page_title = "Удалить альбом – Сето";
    $css_files  = array("/css/parts/template.css", "/css/parts/icon.css", "/css/pages/photos/delete-album.css");
    $js_files   = array("/js/pages/photos/delete-album.js");
    include_once("../../parts/header.php");
    ?>

    <div class="template__columns">
        <div class="template__left-column">
            <form class="delete-album" method="POST" enctype="multipart/form-data">
                <h3 class="album__name"><a href="/album/<?=$album_id?>"><?=$name?></a></h3>
                <h5 class="album__photos-count"><?=$photos_count?> фото</h5>
                <p class="album__description"><?=$description?></p>
                <input type="submit" class="edit-album__submit" value="Удалить альбом"">
            </form>
        </div>
        <div class="template__right-column">

        </div>
    </div>
    <?
    include_once("../../parts/footer.php");
}
?>