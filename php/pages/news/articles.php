<?
require_once('../../shared/db.php');
require_once('../../shared/auth.php');
require_once('../../shared/paging.php');
$page_title = "Новости – Сето";
$css_files = array("/css/pages/news/articles.css", "/css/pages/news.css", "/css/parts/template.css");
$js_files = array("/js/pages/news.js");
include_once("../../parts/header.php");
include_once("../../support/dateFormat.php");
?>

    <div class="template__columns">
        <div class="template__left-column">
            <script>
                var ids=[];
            </script>
            <div class="articles">
                <? if (isLoggedIn()) { ?>
                    <a class="articles__create-new-icon" href="/article/new"></a>
                <? }

                $_PAGING = new Paging($db);

                if(isset($_POST["search__input"])) {
                    $search = $_POST["search__input"];
                    $search = trim($search);
                    $search = mysql_real_escape_string($search);
                    $search = htmlspecialchars($search);
                    $r = $_PAGING->get_page("SELECT * FROM article WHERE UPPER(title) like UPPER('%$search%') OR UPPER(text) like UPPER('%$search%') ORDER BY date DESC");
                    ?>
                    <div class="articles__label">Результаты поиска:</div>
                <?
                }
                else {
                    $r = $_PAGING->get_page( 'SELECT * FROM article ORDER BY date DESC' );
                    ?>
                    <div class="articles__label">Последние новости Сето</div>
                <?
                }



                /*if ($r->fetch_assoc() != null) {*/
                    while($row = $r->fetch_assoc()) {
                    ?>

                        <div class="articles__article">
                            <? if (isLoggedIn()) { ?>
                                <a class="articles__edit-article-icon" href="/article/<?echo $row["id"]?>/edit"></a>
                                <a class="articles__delete-article-icon" href="/article/<?echo $row["id"]?>/delete"></a>
                            <? } ?>
                            <div class="articles__article-photo-wrapper">
                                <?
                                if ($row["medium_image_thumbnail_path"] != null) {
                                    ?>
                                    <a href="/article/<?echo $row["id"]?>"><img class="articles__article-photo" src="<?echo $row["medium_image_thumbnail_path"]?>"></a>
                                <?
                                }
                                ?>
                            </div>
                            <div class="articles__article-text-wrapper">
                                <a class="articles__article-title" href="/article/<?echo $row["id"]?>"><?echo $row["title"]?></a>
                                <h5 class="articles__article-date"><?echo getFormatDate($row["date"])?></h5>
                                <div class="articles__article-announcement">
                                    <p>
                                        <?echo $row["announcement"]?>
                                    </p>
                                </div>
                                <a class="articles__article-read" href="/article/<?echo $row["id"]?>">Читать дальше</a>
                                <div id="article__like<?echo $row["id"]?>" style="float: right;"></div>
                                <script>
                                   ids.push(<?echo $row["id"]?>);
                                </script>
                            </div>
                        </div>

                    <?
                    }
               /* } else
                    echo 'Новостей не найдено.';*/
                ?>

                <div class="articles__pages">
                    <? echo $_PAGING->get_prev_page_link() . $_PAGING->get_page_links() . $_PAGING->get_next_page_link();
                    ?>
                </div>
            </div>

        </div>
        <div class="template__right-column">
            <form class="articles__search" enctype="application/x-www-form-urlencoded" method="POST">
                <label class="search__label" for="search__input">Поиск по новостям</label>
                <span title="Найти" class="search__icon" onclick="$('.articles__search').submit()"></span>
                <input class="search__input" name="search__input" placeholder="Введите тему для поиска...">
            </form>

            <?php
            $idEditOrLoadBlock = 4;
            include_once('../../parts/html.php');
            ?>

        </div>
    </div>

<?php include_once("../../parts/footer.php"); ?>