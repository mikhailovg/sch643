﻿﻿<?
include_once("../../support/connectBD.php");
require_once("../../shared/auth.php");

$page_title = "Администрирование";
/*if($_SERVER['REQUEST_METHOD']==='POST'){

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
        header('Location: /php/pages/auth/login.php');
    }
    else {
        $_SESSION['correctPassword']=false;
        header('Location: /php/pages/auth/login.php');
    }
}
else if ($_SERVER['REQUEST_METHOD'] == 'GET') {*/
    $css_files = array("/css/pages/login.css", "/js/libs/jstree/themes/classic/style.css", "/css/parts/template.css", "/js/libs/jquery-ui.css", );
     ?>

<script src="/js/libs/jquery.min.js"></script>
<script src="/js/libs/jstree/jquery-ui.min.js"></script>


<div class="background">
    <div class="main">
        <? include_once("../../parts/header.php"); ?>



           <!-- --><!--?/*
                if (isset($_SESSION['correctPassword'])) {
                    if ($_SESSION['correctPassword'] == true) { */?-->

                        <script src="/js/libs/jstree/jquery.jstree.js"></script>
                        <script src="/js/pages/admin.js"></script>

                        <div class="container">
                            <div class="container_left">
                                <div class="login_title">Администрирование</div>
                                <div class="">Список разделов:</div>
                                <div title="Добавить раздел" class="jstree_add_icon"></div>
                                <div id="jstree"></div>
                            </div>
                            <div class="container_right">
                                    <div class="login_title_right">Редактирование подраздела</div>
                                    <div id="data">
                                        <? include_once("../../layouts/layout1.php"); ?>
                                    </div>
                            </div>











       <!-- <!--?/*
                }
                else { */?>
        <form id="loginForm" class="loginForm" action="administrator" method="POST">
                    <div class="login_row"><label for="login" >Логин</label><input name="login" type="text" class="login_field"></div>
                    <div class="login_row"><label for="password" >Пароль</label><input name="password" type="password" class="login_field"></div>
                    <input type="submit" value="Войти" class="login_submit">
                    <div class="login_error">Пользователя с такими данными не существует</div>
        </form>
        --><!--?/*
                }
            }*/
            else { ?>
        <form id="loginForm" class="loginForm" action="administrator" method="POST">
                <div class="login_row"><label for="login" >Логин</label><input name="login" type="text" class="login_field"></div>
                <div class="login_row"><label for="password" >Пароль</label><input name="password" type="password" class="login_field"></div>
                <input type="submit" value="Войти" class="login_submit">
        </form>
        <!--?
            } ?-->

        <?
        //}
        include_once("../../parts/footer.php"); ?>
    </div>
</div>


    <div id="addNode_dialog" class="adminDialog" title="Добавление раздела" style="display: none;">
        <label>Имя раздела:</label>
        <input type="text" id="addNode_dialog_name" class="text ui-widget-content ui-corner-all">
        <label>Заголовок раздела:</label>
        <input type="text" id="addNode_dialog_title" class="text ui-widget-content ui-corner-all">
    </div>
    <div id="renameNode_dialog" class="adminDialog" title="Переименование раздела" style="display: none;">
        <input type="hidden" id="renameNode_dialog_parentId">
        <label>Имя раздела:</label>
        <input type="text" id="renameNode_dialog_name" class="text ui-widget-content ui-corner-all">
    </div>
    <div id="deleteNode_dialog" class="adminDialog" title="Удаление раздела" style="display: none;">
        <input type="hidden" id="deleteNode_dialog_parentId">
        <label>Вы уверены, что хотите удалить раздел </label>
    </div>


    <div id="addSection_dialog" class="adminDialog" title="Добавление подраздела" style="display: none;">
        <input type="hidden" id="addSection_dialog_parentId">
        <label>Имя подраздела:</label>
        <input type="text" id="addSection_dialog_name" class="text ui-widget-content ui-corner-all">
        <label>Заголовок подраздела:</label>
        <input type="text" id="addSection_dialog_title" class="text ui-widget-content ui-corner-all">
    </div>
    <div id="renameSection_dialog" class="adminDialog" title="Переименование подраздела" style="display: none;">
        <input type="hidden" id="renameSection_dialog_parentId">
        <label>Имя подраздела:</label>
        <input type="text" id="renameSection_dialog_name" class="text ui-widget-content ui-corner-all">
    </div>
    <div id="deleteSection_dialog" class="adminDialog" title="Удаление подраздела" style="display: none;">
        <input type="hidden" id="deleteSection_dialog_parentId">
        <label>Вы уверены, что хотите удалить подраздел </label>
    </div>

