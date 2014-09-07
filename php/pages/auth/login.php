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
        header('Location: /administrator');
    }
    else {
        $_SESSION['correctPassword']=false;
        header('Location: /administrator');
    }
}
else if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $css_files = array("/css/pages/login.css", "/css/libs/jstree.css", "/css/parts/template.css");
     ?>

<div class="background">
    <div class="main">
        <? include_once("../../parts/header.php"); ?>


            <div class="login_title">Администрирование</div>
            <?
                if (isset($_SESSION['correctPassword'])) {
                    if ($_SESSION['correctPassword'] == true) { ?>

                        <script src="/js/libs/jstree.min.js"></script>
                        <script src="/js/pages/admin.js"></script>

                        <div class="template__columns">
                            <div class="template__left-column__admin">
                                <div id="jstree"></div>
                            </div>

                            <div class="template__right-column">
                                2
                            </div>
                        </div>











        <?
                }
                else { ?>
        <form id="loginForm" class="loginForm" action="administrator" method="POST">
                    <div class="login_row"><label for="login" >Логин</label><input name="login" type="text" class="login_field"></div>
                    <div class="login_row"><label for="password" >Пароль</label><input name="password" type="password" class="login_field"></div>
                    <input type="submit" value="Войти" class="login_submit">
                    <div class="login_error">Пользователя с такими данными не существует</div>
        </form>
        <?
                }
            }
            else { ?>
        <form id="loginForm" class="loginForm" action="administrator" method="POST">
                <div class="login_row"><label for="login" >Логин</label><input name="login" type="text" class="login_field"></div>
                <div class="login_row"><label for="password" >Пароль</label><input name="password" type="password" class="login_field"></div>
                <input type="submit" value="Войти" class="login_submit">
        </form>
        <?
            } ?>

        <?
        }
        include_once("../../parts/footer.php"); ?>
    </div>
</div>


