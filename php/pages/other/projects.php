<?
$idEditOrLoadBlock = 2;
include_once("../../support/connectBD.php");
require_once("../../shared/auth.php");
$page_title = "Проекты Сето";
include_once( '../../parts/header.php');
?>
<div class="template__left-column">
    <?
    include ('../../parts/html.php');
    ?>
</div>

<div class="template__right-column">
    <?
    $idEditOrLoadBlock = 4;
    include ('../../parts/html.php');
    ?>
</div>
<?
include_once( '../../parts/footer.php');
?>