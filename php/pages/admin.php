<?$page_title = "Школа № 643 - Администрирование";
  include_once("../parts/header.php");
  require_once('../shared/auth.php');?>

<script src="/js/libs/jstree/jquery.jstree.js"></script>
<script src="/js/pages/admin.js"></script>
<script src="/js/libs/jquery-ui.min.js"></script>
<link href="/js/libs/jquery-ui.css" rel="stylesheet">
<link href="../../css/pages/login.css" rel="stylesheet">

<? if (isLoggedIn()) { ?>
    <div class="container">
        <div class="container_left">
            <div class="login_title">Администрирование</div>
            <div class="">Список разделов:</div>
            <div align="right"><span title="Добавить раздел" class="jstree_add_icon"></span></div>
            <div id="jstree"></div>
        </div>
        <div class="container_right_admin">
            <div class="login_title_right">Редактирование подраздела</div>
            <div id="data">
                <input type="hidden" id="nodeId">
                <input type="hidden" id="sectionId">
                <? include_once("../layouts/layout1.php"); ?>
            </div>
        </div>
    </div>
<? } else { ?>
    <?include_once("403.php");?>
<? } ?>

<?include_once("../shared/adminDialogs.php");?>

<?include_once("../parts/footer.php");?>
