<?php
include_once("../../support/connectBD.php");
require_once("../../shared/auth.php");
$page_title = "Справочник организаций Сето";
include_once("../../parts/header.php");
?>
<link href="/css/pages/business/business.css" rel="stylesheet" >
<link href="/css/parts/template.css" rel="stylesheet" >
<script src="/js/pages/business/business.js"></script>

<div class="template__columns">
    <div class="template__left-column">
        <div class="business">
<?php
            if(isLoggedIn()){
?>
            <a class="business__add-event-icon" href="/business/new"></a>

<?
            }
?>
            <h3 class="business__label">Карта предприятий</h3>
            <table class="business__table">

                <thead>
                <tr>
                    <th class="business__name-column">Название</th>
                    <th class="business__profile-column">Профиль</th>
                    <th class="business__contact-column">Конакты</th>
                </tr>
                </thead>
<?php
    if(isset($_POST["search"])){
        $search = $_POST["search"];
        $search = trim($search);
        $search = mysql_real_escape_string($search);
        $search = htmlspecialchars($search);
        $stmt = $db->prepare("SELECT name, profile, contact, info, id  FROM business WHERE UPPER(name) like UPPER('%$search%') OR UPPER(profile) like UPPER('%$search%') OR UPPER(info) Like UPPER('%$search%') OR UPPER(contact) Like UPPER('%$search%')");
    } else {
        //Пагинация
        $stmt = $db -> prepare("SELECT COUNT(*) FROM business");
        $stmt -> execute();
        $stmt -> bind_result($numberAllBusiness);
        $stmt -> fetch();
        $stmt ->close();

        $currentPage = max(intval($_GET["page"]), 1);
        $numberBusinessOnPage = 15;
        $offset = ($currentPage - 1) * $numberBusinessOnPage;
        $numberPaginators = ceil($numberAllBusiness / $numberBusinessOnPage);

        $stmt = $db->prepare("SELECT name, profile, contact, info, id  FROM business LIMIT ? OFFSET ?");
        $stmt->bind_param("ii", $numberBusinessOnPage, $offset);

    }
    $stmt->execute();
    $stmt->bind_result($nameBlock, $profileBlock, $contactBlock, $infoBlock, $idBusiness);
                while($stmt->fetch()){
?>
                <tbody class="business__tbody business__tbody--past">
                <tr>
                    <td class="business__name-column business__name-cell">
                    <?php echo $nameBlock ?>
                    </td>
                    <td class="business__profile-column">

<?php
                        if(isLoggedIn()){
?>
                        <a class="business__edit-event-icon" href="/business/<?php echo $idBusiness?>/edit"></a>
                        <span class="business__delete-event-icon"></span>
<?
                        }
?>
                        <input type="hidden" class="business__idBusiness" value="<?echo $idBusiness?>">
                        <?php echo $profileBlock ?>
                    </td>
                    <td class="business__contact-column">
                    <?php echo $contactBlock ?>
                    </td>
                </tr>
                <tr class="business__info-row  business__info-row--collapsed">
                    <td class="events__info-cell" colspan="3">
                        <?php echo $infoBlock ?>
                    </td>
                </tr>
                </tbody>
<? } ?>
            </table>
            <div class="business__paginator">
<?php
            if($numberPaginators > 1){
                if ($currentPage > 1) {
?>
                    <a class="business__paginatorPrevious" href="<?= $currentPage - 1 > 1 ? "/business_num/".($currentPage - 1) : "/business" ?>" title="Назад"></a>
<?php
                }
                for( $page = 1 ; $page <= $numberPaginators ; $page++){
?>
                    <a class="business__paginatorNum <?= $page == $currentPage ? "business__paginatorNum--current" : ""?>" href="<?= $page > 1 ? "/business_num/".($page) : "/business" ?>"><?= $page ?></a>
<?php
                }
                if($currentPage < $numberPaginators){
?>
                    <a class='business__paginatorNext' href='business_num/<?= $currentPage + 1 ?>' title='Вперед'></a>
<?php
                }
            }
?>
            </div>
        </div>
    </div>

    <div class="template__right-column">
        <form class = "business__search" action = "<? echo $_SERVER["REQUEST_URI"]?>" enctype="application/x-www-form-urlencoded" method="POST">
            <label class = "business__searchLabel" for = "business__searchInput">Поиск по предприятиям</label>
            <span class = "business__searchIcon"></span>
            <input type="text" class = "business__searchInput" id="business__searchInput" name="search" value="<? echo $search ?>" placeholder="Введите ключевые слова поиска...">
        </form>
            <?php
            $idEditOrLoadBlock = 4;
            include_once('../../parts/html.php');
            ?>
    </div>
</div>

<?php
    if(isLoggedIn()){
?>
<div id="business__deleteDialog" title="Удаление события" style="display: none">
    <form id = "business__deleteDialogForm" action = "/business/delete" enctype="application/x-www-form-urlencoded" method="POST">
        <input type="hidden" id="business__deleteDialogIdEvent" name = "id" value="">
    </form>
    <p id="business__deleteDialogMessage">Вы уверены, что хотите удалить предприятие?</p>
</div>
<?
    }
?>
<?php include_once("../../parts/footer.php"); ?>