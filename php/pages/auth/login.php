﻿<?$page_title = "Школа № 643 - Вход в администрирование";
  include_once("../../parts/header.php");
  include_once("../../support/connectBD.php");
  require_once('../../shared/auth.php');

  if (isLoggedIn()) {
      header('Location: ../../pages/admin.php');
  } else {
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
              header('Location: ../../pages/admin.php');
          }
      }
  } ?>

<link href="../../../css/pages/login.css" rel="stylesheet">
<script src="/js/utils/clearForm.js"></script>
<div class="container">
    <div class="container_center">
        <div class="login_title">Вход в администрирование</div>
        <form id="loginForm" class="login-fields"  method="POST">
            <div class="login-row">
                <label for="login" >Логин: </label><input id="login" name="login" type="text" class="login-field">
            </div>
            <div class="login-row">
                <label for="password" >Пароль: </label><input id="password" name="password" type="password" class="login-field">
            </div>
            <input class="bttn" type="submit" value="Войти">
        </form>
    </div>
</div>

<?include_once("../../parts/footer.php");?>
