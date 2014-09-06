<?
require_once("../../shared/db.php");
require_once("../../shared/auth.php");
$page_title = "Фотоальбомы – Сето";
$css_files  = array("/css/parts/template.css", "/css/parts/icon.css", "/css/pages/photos/albums.css");
$js_files   = array("/js/pages/photos/albums.js");
include_once("../../parts/header.php");
?>
    <div class="template__columns">
        <div class="template__left-column">
            <div class="albums">
                <? if (isLoggedIn()) { ?>
                    <a class="icon__add albums__add-photo-album-icon" href="/album/new" title="Создать фотоальбом"></a>
                <? } ?>
                <h3 class="albums__label">Все фотоальбомы</h3>
                <ul class="albums__albums-list">
                    <?
                        $stmt = $db->prepare("SELECT album.id, album.name, photo.mini_image_path, photos.count
                                              FROM album
                                              LEFT JOIN photo
                                              ON album.id = photo.album_id
                                              LEFT JOIN (SELECT album_id, count(id) count
                                                    FROM photo
                                                    GROUP BY album_id) photos
                                              ON album.id = photos.album_id
                                              WHERE photo.id IS NULL
                                              OR photo.id IN (SELECT MAX(id)
                                              		          FROM photo
                                                              GROUP BY album_id);

                        ");
                        $stmt->execute();
                        $stmt->bind_result($album_id, $name, $mini_image_path, $photos_count);
                        while($stmt->fetch()) {
                    ?>
                        <li class="albums__album">
                            <a class="albums__photo" href="/album/<?=$album_id?>">
                                <? if ($mini_image_path != null) { ?>
                                <img src="<?=$mini_image_path?>">
                                <? } ?>
                            </a>
                            <h5 class="albums__photos-count"><?=$photos_count == null ? 0 : $photos_count?> фото</h5>
                            <h3 class="albums__album-name">
                                <a href="/album/<?=$album_id?>"><?=$name?></a>
                            </h3>
                        </li>
                    <?
                        }
                        $stmt->close();
                    ?>
                </ul>
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