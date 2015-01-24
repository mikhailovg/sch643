<?include_once("../../support/connectBD.php");
include_once("../../support/dateFormat.php");
require_once("../../shared/youtube.php");
require_once("../../shared/auth.php");
$page_title = "Редактирование новости – Школа №643";

if (!isLoggedIn()) {
    header("Location: /403");
    die();
}
$id="";
$title="";
$announcement="";
$text="";
$original_image_path="";
$small_image_thumbnail_path="";
$medium_image_thumbnail_path="";
$big_image_thumbnail_path="";
$youtube_video_url="";
$date = date('Y/m/d H:i:s');
$currentUrl = $_SERVER["REQUEST_URI"];
$oldImagePath = false;


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include_once("../../shared/upload-and-resize-images.php");

    $title = $_POST['title'];
    $text = $_POST['text'];
    if (strpos($text, "\n")!=null) {
        $announcement = substr($text, 0, strpos($text, "\n"));

    }
    else if (substr($text, 0, 500)!=null)
        $announcement = substr($text, 0, 500) . "...";
    else if (substr($text, 0, 400)!=null)
        $announcement = substr($text, 0, 400) . "...";
    else if (substr($text, 0, 300)!=null)
        $announcement = substr($text, 0, 300) . "...";
    else if (substr($text, 0, 50)!=null)
        $announcement = substr($text, 0, 50) . "...";
    if ($_POST['youtube_video_url'] != null)
        $youtube_video_url = "//www.youtube.com/embed/" . youtube_id_from_url($_POST['youtube_video_url']);
    $paths = upload_and_resize_image($_FILES["image"], array("original", "40x40", "145x145", "220x"));

    if ($paths != null) {
        $original_image_path          = $paths["original"];
        $small_image_thumbnail_path   = $paths["40x40"];
        $medium_image_thumbnail_path  = $paths["145x145"];
        $big_image_thumbnail_path     = $paths["220x"];
    }

    if (isset($_GET['article_id'])) {
        $id = $_POST['id'];
        if ($_POST['img'] == null) {
            $stmt = $db->prepare("UPDATE article SET title=?, announcement=?, text=?, date=?, original_image_path=?, small_image_thumbnail_path=?, medium_image_thumbnail_path=?, big_image_thumbnail_path=?, youtube_video_url=? WHERE id=?");
            $stmt -> bind_param('ssssssssss', $title, $announcement, $text, $date, $original_image_path, $small_image_thumbnail_path, $medium_image_thumbnail_path, $big_image_thumbnail_path, $youtube_video_url, $id);
        }
        else {
            $stmt = $db->prepare("UPDATE article SET title=?, announcement=?, text=?, date=?, youtube_video_url=? WHERE id=?");
            $stmt -> bind_param('ssssss', $title, $announcement, $text, $date, $youtube_video_url, $id);
        }
    }
    else {
        $stmt = $db->prepare("INSERT INTO article (title, announcement, text, date, original_image_path, small_image_thumbnail_path, medium_image_thumbnail_path, big_image_thumbnail_path, youtube_video_url) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt -> bind_param('sssssssss', $title, $announcement, $text, $date, $original_image_path, $small_image_thumbnail_path, $medium_image_thumbnail_path, $big_image_thumbnail_path, $youtube_video_url);
    }
    $stmt->execute();
    $stmt->close();

    header('Location: ./php/pages/news/articles.php');
    die();
}

else if ($_SERVER['REQUEST_METHOD'] == 'GET') {

    if (isset($_GET['article_id'])) {
        $id= $_GET['article_id'];
        $stmt = $db->prepare("select * from article where id=?");
        $stmt -> bind_param('s', $id);
        $stmt -> execute();
        $stmt -> bind_result($id, $title, $announcement, $text, $date, $original_image_path, $small_image_thumbnail_path, $medium_image_thumbnail_path, $big_image_thumbnail_path, $youtube_video_url);
        $stmt -> fetch();
        $youtube_video_url_original = str_replace('embed/', 'watch?v=', $youtube_video_url);
    }
    ?>
    <? include_once("../../parts/header.php"); ?>

    <link rel="stylesheet" href="/css/pages/news/article.css">
    <link rel="stylesheet" href="/css/parts/template.css">
    <link rel="stylesheet" href="/css/pages/layout1.css">
    <script src="/js/pages/edit-article.js"></script>

    <form method="POST" enctype="multipart/form-data">
        <div class="template__columns">
            <div class="template__left-column">
                <div class='editArticle__id' style="display: none">
                    <h3 for="id" class='editArticle__title'>Id</h3>
                    <input type='hidden' class='editArticle__content' name="id" value='<? echo $id ?>'>
                </div>
                <div class='editArticle__titleString'>
                    <h3 for="title" class='editArticle__title'>Заголовок новости</h3>
                    <input type='text' class='editArticle__content' name="title" value='<? echo $title ?>'>
                </div>
                <div class='editArticle__text'>
                    <h3 for="text" class='editArticle__title'>Текст новости</h3>
                    <textarea class='editArticle__content' id='editArticle__content' name="text" rows="10" cols="30"><? echo $text ?></textarea>
                </div>
                <br/>
            </div>

            <div class='template__right-column'>

                <div class='editArticle__img'>
                    <h3 for="img" class='editArticle__title'>Изображение</h3>
                    <input type="hidden" name="img" value="<?
                    if ($big_image_thumbnail_path != null) {
                        $oldImagePath = true;
                        echo $big_image_thumbnail_path;
                    }
                    ?>">
                    <? if ($big_image_thumbnail_path != null) { ?>
                        <div class="editArticle__img__forImg">
                            <img width="300px" height="220px" class='editArticle__imgContent' src='<? echo $big_image_thumbnail_path ?>'>
                        </div>
                        <div class='editArticle__imgButtons'>
                            <button type="button" class="seto__button deleteImg">Удалить</button>
                            <input type="file" name="image" id="uploaded_image_src">
                        </div>
                    <? } else {?>
                        <div class='editArticle__imgButtons'>
                            <button type="button" class="seto__button deleteImg" style="display: none">Удалить</button>
                            <input type="file" name="image" id="uploaded_image_src">
                        </div>
                    <? } ?>
                </div>
                <div class='editArticle__video'>
                    <h3 for="youtube_video_url" class='editArticle__title'>Видео</h3>
                    <input type='text' class="youtube_video_url_original" placeholder="Ссылка на видео" value = "<?
                            if (isset ($youtube_video_url_original))
                                echo $youtube_video_url_original;
                            else
                                echo $youtube_video_url
                        ?>">

                    <input type="hidden" name="youtube_video_url" value = "<? echo $youtube_video_url ?>">
                    <? if ($youtube_video_url != null) { ?>
                        <div class="editArticle__video__forIframe">
                            <iframe width="300" height="200" src="<? echo $youtube_video_url ?>" frameborder="0" allowfullscreen></iframe>
                        </div>
                        <div class='editArticle__videoButtons'>
                            <button type="button" class="seto__button uploadVideo" onclick=' $(".uploadVideo__dialog").dialog("open"); '>Загрузить</button>
                            <button type="button" class="seto__button deleteVideo">Удалить</button>
                        </div>
                    <? } else {?>
                        <div class="editArticle__video__forIframe"></div>
                        <div class='editArticle__videoButtons'>
                            <button type="button" class="seto__button uploadVideo" onclick=' $(".uploadVideo__dialog").dialog("open"); '>Загрузить</button>
                            <button type="button" class="seto__button deleteVideo">Удалить</button>
                        </div>
                    <? } ?>
                </div>
            </div>
        </div>
        <div class="uploadImage__dialog" title="Загрузка изображения" style="display:none;">

        </div>
        <button class="layout__save" type="submit">Опубликовать новость</button>
    </form>

    <div class="deleteArticle__dialog" title="Удаление новости" style="display:none;">
        <p>Вы уверены, что хотите удалить новость?</p>
    </div>
<?
}
include_once("../../parts/footer.php"); ?>