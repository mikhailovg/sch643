<?
require_once("../../shared/db.php");
require_once("../../shared/date.php");
require_once("../../shared/auth.php");

$page_size = 4;
// Нумерация страниц с едеиницы
$page_number = max(intval($_GET["page_number"]), 1);

$page_title = "Видео – Сето";
$css_files  = array("/css/parts/template.css", "/css/parts/icon.css", "/css/pages/videos/videos.css");
$js_files   = array("/js/pages/videos/videos.js");
include_once("../../parts/header.php");
?>
    <div class="template__columns">
        <div class="template__left-column">
            <div class="videos">
            <? if (isLoggedIn()) { ?>
            <a class="icon__add videos__add-icon" href="/video/new" title="Добавить видео"></a>
            <?   }   ?>
                <h3 class="videos__label">Все видео</h3>
                <ul class="videos__list">
                    <?

                        $limit = $page_size;
                        $offset = ($page_number - 1) * $page_size;
                        $stmt = $db->prepare("SELECT id, date_added, url, youtube_id, title, description FROM video ORDER BY date_added DESC LIMIT ? OFFSET ? ");
                        $stmt->bind_param("ii", $limit, $offset);
                        $stmt->execute();
                        $stmt->bind_result($video_id, $date_added, $url, $youtube_id, $title, $description);
                        while ($stmt->fetch()) {
                    ?>
                        <li class="videos__video">
                            <? if (isLoggedIn()) { ?>
                            <a class="icon__edit videos__edit-icon" href="/video/<?=$video_id?>/edit" title="Редактировать видео"></a>
                            <a class="icon__delete videos__delete-icon" href="/video/<?=$video_id?>/delete" title="Удалить видео"></a>
                            <?  }  ?>

                                    <iframe class="videos__iframe" width="640" height="480" src="//www.youtube.com/embed/<?=$youtube_id?>" frameborder="0" allowfullscreen></iframe>
                            <? if ($title) { ?>
                                <h3 class="videos__title"><a href="<?=$url?>"><?=$title?></a></h3>
                            <? } ?>
                            <h5 class="videos__date"><?=format_date_with_month_name($date_added)?></h5>
                            <? if ($description) { ?>
                                <p class="videos__description"><?=$description?></p>
                            <? } ?>
                        </li>
                    <?
                        }
                        $stmt->close();
                    ?>
                </ul>
                <?
                    $stmt = $db->prepare("SELECT count(*) FROM video");
                    $stmt->execute();
                    $stmt->bind_result($total_videos_count);
                    $stmt->fetch();
                    $stmt->close();
                    $pages_count = ceil($total_videos_count / $page_size);

                    if ($pages_count > 1) {
                ?>
                    <div class="videos__pages">
                        <? if ($page_number > 1) { ?>
                            <a class="videos__prev-page-icon" href="<?= $page_number - 1 > 1 ? "/videos/".($page_number - 1) : "/videos" ?>" title="Назад"></a>
                        <? }
                        for  ($page = 1; $page <= $pages_count; $page++) {
                            if (abs($page_number - $page) <= 3) { ?>
                                <a class="videos__page <?= $page === $page_number ? "videos__page--current" : ""?>" href="<?= $page > 1 ? "/videos/".($page) : "/videos" ?>"><?=($page === $page_number - 3 || $page === $page_number + 3) ? "&hellip;" : $page?></a>
                            <? }
                        }
                        if ($page_number < $pages_count) { ?>
                            <a class="videos__next-page-icon" href="<?="/videos/".($page_number + 1)?>" title="Вперед"></a>
                        <? } ?>
                    </div>
                <? } ?>
            </div>
        </div>
        <div class="template__right-column">
            <?/*
            $idEditOrLoadBlock = 4;
            include ('../../parts/html.php');
            */?>
        </div>
    </div>
<? include_once("../../parts/footer.php"); ?>