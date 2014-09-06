<?
require_once("../../shared/db.php");
require_once("../../shared/date.php");
require_once("../../shared/auth.php");

if (!isLoggedIn()) {
    header("Location: /403");
    die();
}
$video_id = intval($_GET["video_id"]);
assert($video_id !== 0);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $stmt = $db->prepare("DELETE FROM video WHERE id = ?");
    $stmt->bind_param("i", $video_id);
    $stmt->execute();
    $stmt->close();
    header("Location: /videos");
    die();
} else {
    $stmt = $db->prepare("SELECT date_added, url, youtube_id, title, description FROM video WHERE id = ?");
    $stmt->bind_param("i", $video_id);
    $stmt->execute();
    $stmt->bind_result($date_added, $url, $youtube_id, $title, $description);
    $not_found = !$stmt->fetch();
    $stmt->close();

    if ($not_found) {
        header("Location: /404");
        die();
    }

    $page_title = "Удалить видео – Сето";
    $css_files  = array("/css/parts/template.css", "/css/parts/icon.css", "/css/pages/videos/delete-video.css");
    $js_files   = array("/js/pages/videos/delete-video.js");
    include_once("../../parts/header.php");
    ?>
    <div class="template__columns">
        <div class="template__left-column">
            <form class="delete-video" method="POST" enctype="multipart/form-data">
                <iframe class="delete-video__iframe" width="640" height="480" src="//www.youtube.com/embed/<?=$youtube_id?>" frameborder="0" allowfullscreen></iframe>
                <? if ($title) { ?>
                    <h3 class="videos__title"><a href="<?=$url?>"><?=$title?></a></h3>
                <? } ?>
                <h5 class="delete-video__date"><?=format_date_with_month_name($date_added)?></h5>
                <? if ($description) { ?>
                    <p class="delete-video__description"><?=$description?></p>
                <? } ?>
                <input type="submit" class="delete-video__submit" value="Удалить видео">
            </form>
        </div>
        <div class="template__right-column">

        </div>
    </div>
    <?
    include_once("../../parts/footer.php");
}
?>