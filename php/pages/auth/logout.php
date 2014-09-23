<?
    session_start();
    $_SESSION = array();
    session_destroy();
    header('Location: /php/pages/auth/login.php');
?>