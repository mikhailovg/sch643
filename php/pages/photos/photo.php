<?
require_once("../../shared/db.php");
require_once("../../shared/auth.php");
require_once("../../shared/date.php");

$photo_id = intval($_GET["photo_id"]);
$stmt = $db->prepare("SELECT album.id, name, count(photo.id)
                      FROM album
                      JOIN photo
                      ON album.id = photo.album_id
                      GROUP BY album.id, name
                      HAVING album.id IN (SELECT album_id
                                          FROM photo
                                          WHERE id = ?)");
$stmt->bind_param("i", $photo_id);
$stmt->execute();
$stmt->bind_result($album_id, $album_name, $album_photos_count);
$not_found = !$stmt->fetch();
$stmt->close();

if ($not_found) {
    header("Location: /404");
}

$page_title = $album_name." – Фотоальбомы – Сето";

class Photo {
    public $photo_id;
    public $date_uploaded;
    public $description;
    public $original_image_path;
    public $micro_image_path;
    public $big_image_path;

    function __construct($photo_id, $date_uploaded, $description, $original_image_path, $micro_image_path, $big_image_path) {
        $this->photo_id = $photo_id;
        $this->date_uploaded = $date_uploaded;
        $this->description = $description;
        $this->original_image_path = $original_image_path;
        $this->micro_image_path = $micro_image_path;
        $this->big_image_path = $big_image_path;
    }

    function to_json() {
        return '{
                    "photo_id"            : '.$this->photo_id.',
                    "date_uploaded"       : new Date('.milliseconds($this->date_uploaded).'),
                    "description"         :"'.$this->description.'",
                    "original_image_path" :"'.$this->original_image_path.'",
                    "micro_image_path"    :"'.$this->micro_image_path.'",
                    "big_image_path"      :"'.$this->big_image_path.'"
                }';
    }

}

$stmt = $db->prepare("SELECT id, date_uploaded, description, original_image_path, micro_image_path, big_image_path
                      FROM photo
                      WHERE album_id = ?
                      ORDER BY id DESC");
$stmt->bind_param("i", $album_id);
$stmt->execute();

$album_photos = array();
$stmt->bind_result($album_photo_id, $date_uploaded, $description, $original_image_path, $micro_image_path, $big_image_path);
while($stmt->fetch()) {

    $album_photos[] = new Photo($album_photo_id, $date_uploaded, $description, $original_image_path, $micro_image_path, $big_image_path);
}
$stmt->close();
foreach($album_photos as $ap => $album_photo) {
    if ($album_photo->photo_id === $photo_id) {
        $photo = $album_photo;
        $photo_index = $ap;
    }
}

if ($photo_index != 0)
    $prev_photo = $album_photos[($photo_index - 1)];
if ($photo_index != count($album_photos) - 1)
    $next_photo = $album_photos[($photo_index + 1)];


$css_files  = array("/css/parts/template.css", "/css/parts/icon.css", "/css/pages/photos/photo.css");
$js_files   = array("/js/pages/photos/photo.js");
include_once("../../parts/header.php");
?>
    <script>
        var album_photos = [
            <? foreach($album_photos as $ap => $album_photo) {
                echo($album_photo->to_json());
                if ($ap !== count($album_photos) - 1) {
                    echo(",");
                }
                echo("\n");
            } ?>
        ];
    </script>
    <div class="template__columns">
        <div class="template__left-column">
            <script>
                var photo_id = <?= $photo_id ?>;
            </script>
            <div class="photo">
                <h3 class="photo__album-name">
                    <a href="/album/<?=$album_id?>"><?=$album_name?></a>
                </h3>
                <h5 class="photo__album-photos-count"><?=$album_photos_count?> фото</h5>
                <div class="photo__next-photos-thumbnails">
                    <? if ($prev_photo) { ?>
                        <a class="photo__prev-page-icon" href="/photo/<?=$prev_photo->photo_id?>" title="Предыдущее фото"></a>
                    <? }
                        foreach($album_photos as $ap => $album_photo) {
                            if ($ap >= $photo_index - 2 && $ap <= $photo_index + 2 || ($photo_index < 2 && $ap < 5) || ($photo_index > count($album_photos) - 3 && $ap > count($album_photos) - 6)) { ?>
                                <a class="photo__next-photo-thumbnail <?=$album_photo->photo_id == $photo->photo_id ? "photo__next-photo-thumbnail--current" : ""?>" href="/photo/<?=$album_photo->photo_id?>">
                                    <img src="<?=$album_photo->micro_image_path?>">
                                </a>
                            <? }
                        }
                    ?>
                    <? if ($next_photo) { ?>
                        <a class="photo__next-page-icon" href="/photo/<?=$next_photo->photo_id?>" title="Следующее фото"></a>
                    <? } ?>
                </div>
                <div class="photo__photo">
                    <? if (isLoggedIn()) { ?>
                        <a id="photo__delete-icon" class="icon__delete photo__delete-icon" href="/photo/<?=$photo->photo_id?>/delete" title="Удалить фото"></a>
                    <? } ?>
                    <a id="photo__image" class="photo__image" href="/photo/<?=$next_photo ? $next_photo->photo_id : $photo->photo_id?>">
                        <img src="<?=$photo->big_image_path?>">
                    </a>
                </div>
                <div class="photo__details">
                    <? if (isLoggedIn()) { ?>
                        <a id="photo__edit-icon" class="icon__edit photo__edit-icon" href="/photo/<?=$photo->photo_id?>/edit" title="Редактировать фото"></a>
                    <? } ?>
                    <div id="photo__description" class="photo__description"><?=$photo->description?></div>
                    <div class="photo__other-info">
                        <div id="photo__like" class="photo__like"></div>
                        <h5 class="photo__date-uploaded"><?=format_date_with_month_name($photo->date_uploaded)?></h5>
                        <h5 id="photo__original-size-image" class="photo__original-size-image" style="<?=$photo->big_image_path === $photo->original_image_path ? "display: none" : ""?>">
                            <a href="<?=$photo->original_image_path?>">Оригинальный размер</a>
                        </h5>
                    </div>
                </div>
                <div id="photo__comments" class="photo__comments"></div>
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