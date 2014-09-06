<?
require_once("../../shared/db.php");
require_once("../../shared/auth.php");

$album_id = $_GET["album_id"];

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

$page_title = $name." – Фотоальбомы – Сето";
$css_files  = array("/css/parts/template.css", "/css/parts/icon.css", "/css/pages/photos/album.css");
$js_files   = array("/js/pages/photos/album.js");
include_once("../../parts/header.php");
?>
    <div class="template__columns">
        <div class="template__left-column">
            <script>
                var album_id = <?= $album_id ?>;
            </script>
            <div class="album">
                <? if (isLoggedIn()) { ?>
                    <a class="icon__add album__add-photo-icon" href="/photo/<?=$album_id?>/new" title="Добавить фото"></a>
                    <a class="icon__edit album__edit-icon" href="/album/<?=$album_id?>/edit" title="Редактировать альбом"></a>
                    <? if (!in_array($album_id, array(1, 2))) { ?>
                        <a class="icon__delete album__delete-icon" href="/album/<?=$album_id?>/delete" title="Удалить альбом"></a>
                    <? } ?>
                <? } ?>
                <h3 class="album__name"><?=$name?></h3>
                <h5 class="album__photos-count"><?=$photos_count?> фото</h5>
                <? if ($description) { ?>
                    <p class="album__description"><?=$description?>
                <? } ?>
                <div class="album__photos">
                    <?
                        $stmt = $db->prepare("SELECT id, mini_image_path FROM photo WHERE album_id = ? ORDER BY id DESC");
                        $stmt->bind_param('i', $album_id);
                        $stmt->execute();
                        $stmt->bind_result($photo_id, $mini_image_path);
                        while($stmt->fetch()) {
                    ?>
                        <a class="album__photo" href="/photo/<?=$photo_id?>">
                            <img src="<?=$mini_image_path?>">
                        </a>
                    <?
                        }
                        $stmt->close();
                    ?>
                </div>
                <div id="album__comments" class="album__comments"></div>
            </div>
        </div>
        <div class="template__right-column">
            <?
            $idEditOrLoadBlock = 4;
            include ('../../parts/html.php');
            ?>
        </div>
    </div>
<? include_once("../../parts/footer.php"); ?>