<?
include_once ('../../support/connectBD.php');
require_once("../../shared/auth.php");

if (!isLoggedIn()) {
    header("Location: /403");
    die();
}
$idEditBlock = $_GET["html_id"];

if($_SERVER['REQUEST_METHOD']==='POST'){
    //Админ отправил форму
    $newTitle = $_POST['contentFromEdit'];
    $stmt = $db->prepare("UPDATE html SET title = ? WHERE id = ?");
    $stmt-> bind_param('si', $newTitle, $idEditBlock);
    $stmt-> execute();
    $stmt -> fetch();

    $editedPage = "";

    switch($idEditBlock){
        case 1:
            $editedPage = "about";
            break;
        case 2:
            $editedPage = "projects";
            break;
        case 3:
            $editedPage = "contacts";
    }

    header("Location: /$editedPage");
} else {
    //это видит админ, если ему захотелось поредактировать
    $stmt = $db->prepare("SELECT title FROM html WHERE id = ?");
    $stmt->bind_param('i', $idEditBlock);
    $stmt->execute();
    $stmt -> bind_result($titleBlock);
    $stmt -> fetch();
    $currentUrl = $_SERVER["REQUEST_URI"];
    ?>

<?
    include_once( '../../parts/header.php');
?>

<link rel="stylesheet" href="/css/parts/html.css">
<script src="/js/parts/html.js"></script>

    <div class="partsHtml">
<form method="POST" action = '<? echo $currentUrl ?>'  id="contentFromEdit" enctype="application/x-www-form-urlencoded">
    <textarea class="partsHtml__Edit"  name="contentFromEdit" >
        <? echo $titleBlock; ?>
    </textarea>
    <input type="submit" id="partsHtml__submit" value="Отправить">
</form>
    </div>
<?
}
include_once('../../parts/footer.php');
?>


