<?
include_once("../../support/connectBD.php");
require_once("../../shared/auth.php");

$page_title = "Администрирование – Сето";
if($_SERVER['REQUEST_METHOD']==='POST'){

    $login=$_POST['login'];
    $password=$_POST['password'];

    $stmt = $db->prepare("select login from admin where login=? and password=?");
    $stmt->bind_param('ss', $login, $password);
    $stmt->execute();
    $stmt -> bind_result($res);
    $stmt -> fetch();

    if ($res != null) {
        session_start();
        $_SESSION['cn']=$login;
        $_SESSION['isAdmin']=true;
        $_SESSION['correctPassword']=true;
        header('Location: /news');
    }
    else {
        $_SESSION['correctPassword']=false;
        header('Location: /administrator');
    }
}
else if ($_SERVER['REQUEST_METHOD'] == 'GET') {

    include_once("../../parts/header.php"); ?>
    <link rel="stylesheet" href="/css/pages/login.css">

    <form id="loginForm" class="loginForm" action="administrator" method="POST">
        <div class="login_title">Администрирование</div>
        <?
            if (isset($_SESSION['correctPassword'])) {
                if ($_SESSION['correctPassword'] == true) { ?>
                    <div class="login_row">Вы уже авторизованы.</div>
        <?
                }
                else { ?>
                    <div class="login_row"><label for="login" >Логин</label><input name="login" type="text" class="login_field"></div>
                    <div class="login_row"><label for="password" >Пароль</label><input name="password" type="password" class="login_field"></div>
                    <input type="submit" value="Войти" class="login_submit">
                    <div class="login_error">Пользователя с такими данными не существует</div>
        <?
                }
            }
            else { ?>
                <div class="login_row"><label for="login" >Логин</label><input name="login" type="text" class="login_field"></div>
                <div class="login_row"><label for="password" >Пароль</label><input name="password" type="password" class="login_field"></div>
                <input type="submit" value="Войти" class="login_submit">
        <?
            } ?>
    </form>

<?
    }
    include_once("../../parts/footer.php"); ?>

