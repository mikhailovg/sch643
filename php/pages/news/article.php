<?
include_once("../../support/connectBD.php");
include_once("../../support/dateFormat.php");
require_once("../../shared/auth.php");

if (isset($_GET['article_id'])) {
    $id= $_GET['article_id'];
    $stmt = $db->prepare("select * from article where id=?");
    $stmt -> bind_param('s', $id);
    $stmt -> execute();
    $stmt -> bind_result($id, $title, $announcement, $text, $date, $original_image_path, $small_image_thumbnail_path, $medium_image_thumbnail_path, $big_image_thumbnail_path, $youtube_video_url);
    $stmt -> fetch();
    $stmt->close();

    $page_title = $title;
    if ($stmt && $announcement!="") {

        include_once("../../parts/header.php");
        ?>

        <link rel="stylesheet" href="/css/pages/news/article.css">
        <link rel="stylesheet" href="/css/pages/news/articles.css">
        <link rel="stylesheet" href="/css/parts/icon.css">
        <link rel="stylesheet" href="/css/parts/template.css">
        <script src="/js/pages/article.js"></script>

        <div class="template__columns">
        <div class="template__left-column" style="position: relative">
        <script>
            var article_id = <?=$id?>;
        </script>
        <div style="position: relative">
            <? if (isLoggedIn()) { ?>
                <a class="icon__delete article__delete-article-icon" title="Удалить новость" href="/article/<?echo $id?>/delete"></a>
                <a class="icon__edit article__edit-article-icon" title="Редактировать новость" href="/article/<?echo $id?>/edit"></a>
            <? } ?>

            <div class="article__announcement">
                <? echo $title; ?>
            </div>

            <?
            echo '<div class="article__block">';
            if ($big_image_thumbnail_path != null) {
                echo "<img src='" . $big_image_thumbnail_path . "' class='article__img' originalImagePath='" . $original_image_path . "'>";
                echo "<div>" . $text . "</div>";
            }
            else
                echo "<div style='width: 640px'>" . $text . "</div>";
            echo "</div>";
            if ($youtube_video_url != null) {
                echo '<div class="article__video"><iframe width="300" height="200" src="' . $youtube_video_url . '" frameborder="0" allowfullscreen></iframe></div>';
            }

            if ($date != null) {
                $articleDate = getFormatDate($date);
                echo "<div class='article__date'>" . $articleDate . "</div>";
            }
            ?>
            <div id="article__like"></div>
        </div>
        <div id="article__comments" style="margin-bottom: 40px;"></div>
<?
    }
    else {
        header("Location: ../404");
        die();
    }
}
?>
    </div>
    <div class="template__right-column">
        <?
        $idEditOrLoadBlock = 4;
        include ('../../parts/html.php');
        ?>
    </div>
</div>

<?php include_once("../../parts/footer.php"); ?>