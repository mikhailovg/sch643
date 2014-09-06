<?
require_once("../../shared/db.php");
require_once("../../shared/youtube.php");
require_once("../../shared/auth.php");

if (!isLoggedIn()) {
    header("Location: /403");
    die();
}

if (isset($_GET["video_id"])) {
    $video_id = intval($_GET["video_id"]);
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $url = $_POST["url"];
    $title = $_POST["title"];
    $description = $_POST["description"];
    $youtube_id = youtube_id_from_url($url);
    if ($video_id) {
        $stmt = $db->prepare("UPDATE video SET url = ?, youtube_id = ?, title = ?, description = ? WHERE id = ?");
        $stmt->bind_param("ssssi", $url, $youtube_id, $title, $description, $video_id);
    } else {
        $stmt = $db->prepare("INSERT INTO video (url, youtube_id, title, description) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $url, $youtube_id, $title, $description);
    }
    $stmt->execute();
    $stmt->close();
    header("Location: /videos");
    die();
} else {
    if ($video_id) {
        $stmt = $db->prepare("SELECT url, youtube_id, title, description FROM video WHERE id = ?");
        $stmt->bind_param("i", $video_id);
        $stmt->execute();
        $stmt->bind_result($url, $youtube_id, $title, $description);
        $not_found = !$stmt->fetch();
        $stmt->close();

        if($not_found) {
            header("Location: /404");
            die();
        }
    }
    $page_title = $video_id ? "Редактировать видео – Сето" : "Добавить видео – Сето";
    $css_files  = array("/css/parts/template.css", "/css/parts/icon.css", "/css/pages/videos/edit-video.css");
    $js_files   = array("/js/pages/videos/edit-video.js");
    include_once("../../parts/header.php");
    ?>
        <div class="template__columns">
            <div class="template__left-column">
                <form class="edit-video" method="POST" enctype="multipart/form-data">
                    <div class="edit-video__url">
                        <h3 class="edit-video__url-label">Ссылка на видео</h3>
                        <input id="edit-video__url-input" class="edit-video__url-input" name="url" value="<?=$url?>">
                    </div>
                    <div id="edit-video__preview" class="edit-video__preview" <? if (!$video_id) { ?>style="display: none"<? } ?>>
                        <h3 class="edit-video__preview-label">Предпросмотр</h3>
                        <iframe id="video__preview-iframe" width="640" height="480" <? if ($video_id) { echo 'src="//www.youtube.com/embed/'.$youtube_id.'"'; } ?> frameborder="0" allowfullscreen></iframe>
                    </div>
                    <div class="edit-video__title">
                        <h3 class="edit-video__title-label">Заголовок видео</h3>
                        <input id="edit-video__title-input" class="edit-video__title-input" name="title" value="<?=$title?>">
                    </div>
                    <div class="edit-video__description">
                        <h3 class="edit-video__description-title">Описание видео</h3>
                        <textarea id="edit-video__description-textarea" name="description"><?=$description?></textarea>
                    </div>
                    <input id="edit-video__video-id-input" type="hidden" name="video_id" >
                    <input type="submit" class="edit-video__submit" value="<?=$video_id ? "Сохранить изменения" : "Добавить видео"?>">
                </form>
            </div>
            <div class="template__right-column">

            </div>
        </div>
    <?
    include_once("../../parts/footer.php");
}
?>