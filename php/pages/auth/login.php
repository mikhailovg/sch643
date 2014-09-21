<?include_once("../../parts/header.php");?>
                        <script src="/js/libs/jstree/jquery.jstree.js"></script>
                        <script src="/js/pages/admin.js"></script>
                        <script src="/js/libs/jquery-ui.min.js"></script>
                        <link href="/js/libs/jquery-ui.css" rel="stylesheet">
                        <link href="../../../css/pages/login.css" rel="stylesheet">
                        
                        <div class="container">
                            <div class="container_left">
                                <div class="login_title">Администрирование</div>
                                <div class="">Список разделов:</div>
                                <div align="right"><span title="Добавить раздел" class="jstree_add_icon"></span></div>
                                <div id="jstree"></div>
                            </div>
                            <div class="container_right">
                                    <div class="login_title_right">Редактирование подраздела</div>
                                    <div id="data">
										<input type="hidden" id="nodeId">
										<input type="hidden" id="sectionId">
                                        <? include_once("../../layouts/layout1.php"); ?>
                                    </div>
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
        <span>Вы уверены, что хотите удалить раздел </span>
        <span id="deleteNode_dialog_name"></span>
        <span>?</span>
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
        <span>Вы уверены, что хотите удалить подраздел </span>
        <span id="deleteSection_dialog_name"></span>
        <span>?</span>
    </div>
<?include_once("../../parts/footer.php");?>
