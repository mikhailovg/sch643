<?
include_once("../../support/connectBD.php");
require_once("../../shared/auth.php");
if (isset($_GET['article_id'])) {
    $id= $_GET['article_id'];
    $stmt = $db->prepare("select * from article where id=?");
    $stmt -> bind_param('s', $id);
    $stmt -> execute();
    $stmt -> bind_result($id, $title, $announcement, $text, $date, $original_image_path, $small_image_thumbnail_path, $medium_image_thumbnail_path, $big_image_thumbnail_path, $youtube_video_url);
    $not_found = !$stmt->fetch();
    $stmt->close();
}

if ($not_found) {
    header("Location: /404");
    die();
}

if (!isLoggedIn()) {
    header("Location: /403");
    die();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $stmt = $db->prepare("DELETE from article where id=?");
    $stmt -> bind_param('s', $id);
    $stmt -> execute();
    $stmt -> fetch();

    header('Location: /news');
    die();
}
elseif ($_SERVER["REQUEST_METHOD"] == "GET") {
    $page_title = "Удалить новость – Сето";
    include_once("../../parts/header.php");
    ?>
    <link rel="stylesheet" href="/css/pages/news/article.css">
    <div class="template__columns">
        <div class="template__left-column">
            <div class="delete-article">
                <form class="delete-article__form" method="POST" enctype="multipart/form-data">
                    <div class="article__announcement">
                        <? echo $title; ?>
                    </div>
                <? echo '<div class="article__block">';
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
                ?>

                <input class="delete-article__submit" type="submit" value="Удалить новость" style="margin: 10px 0;">

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
