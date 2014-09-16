$(function () {
    addDialogs();
    createJSTrees();
    addEventHandlers();
});

function createJSTrees() {
    $("#jstree")
        .jstree({
            contextmenu:{
                items: customMenu
            },
            json_data:{
                progressive_render:true,
                ajax:{
                    url: "/admin/getPagesByParent",
                    data: function(n) {
                        return {
                            parentId: (n.attr ? n.attr('id') : 0 )
                        };
                    },
                    success: function (data) {
                        return $.map(data, function (page) {
                            var node = {};
                            node.attr = {
                                id: page.id,
                                htmlContent: page.htmlContent,
                                name: page.name,
                                parentId: page.parentId,
                                status: status
                            };
                            node.metadata = {
                                id:page.id,
                                htmlContent: page.htmlContent,
                                name:page.name,
                                parentId: page.parentId,
                                status: status
                            };
                            node.data = page.name;
                            !page.parentId ? node.state='closed' : node.state='opened';
                            return node;
                        });
                    }
                }
            },
        "plugins" : [ "themes", "json_data", "ui",'crrm','contextmenu' ]
        })

        .bind("select_node.jstree", function(e,data){
            if (data.rslt.obj.hasClass("jstree-opened")) {
                tinymce.remove();
                $("#data #nodeId").val(data.rslt.obj.attr("parentId"));
                $("#data #sectionId").val(data.rslt.obj.attr("id"));
                $(".container_right").show();
                $(".layout__container textarea").val(data.rslt.obj.attr("htmlContent"));
                tinyInit();
            }
            else {
                $(".container_right").hide();
            }
        }
    ).bind('select_node.jstree', function (e, data) {
            $("#jstree").jstree("toggle_node", data.rslt.obj);
        });
    }

function addEventHandlers() {
    $(".jstree_add_icon").click(function() {
        $( "#addNode_dialog" ).dialog( "open" );
    })
    $(".layout__save").click(function() {
        updateSection($("#data #nodeId").val(), $("#data #sectionId").val());
    })
}

function addNode(name, title) {
    $.ajax({
        async: false,
        type: "GET",
        data: {
            name: name,
            title: title
        },
        url: "/admin/addNode",
        complete: function () {
            createJSTrees();
        }
    });
}
function renameNode(id, name) {
    $.ajax({
        async: false,
        type: "GET",
        data: {
			id: id,
            name: name
        },
        url: "/admin/renameNode",
        complete: function () {
            createJSTrees();
        }
    });
}
function deleteNode(id) {
    $.ajax({
        async: false,
        type: "GET",
        data: {
			id: id	
        },
        url: "/admin/deleteNode",
        complete: function () {
            createJSTrees();
        }
    });
}


function addSection(parentId, name, title) {
    $.ajax({
        async: false,
        type: "GET",
        data: {
            parentId: parentId,
            name: name,
            title: title
        },
        url: "/admin/addSection",
        complete: function () {
            createJSTrees();
        }
    });
}
function renameSection(id, name) {
    $.ajax({
        async: false,
        type: "GET",
        data: {
			id: id,
            name: name
        },
        url: "/admin/renameSection",
        complete: function () {
            createJSTrees();
        }
    });
}
function deleteSection(id) {
    $.ajax({
        async: false,
        type: "GET",
        data: {
			id: id	
        },
        url: "/admin/deleteSection",
        complete: function () {
            createJSTrees();
        }
    });
}

function updateSection(nodeId, sectionId) {
	$.ajax({
        async: false,
        type: "GET",
        data: {
			nodeId: nodeId,
			sectionId: sectionId,
			filePath: tinymce.get(0).getContent()
        },
        url: "/admin/updateSection",
        complete: function () {
            createJSTrees();
        }
    });
}

function tinyInit() {
    tinymce.init({
        selector: "textarea",
        plugins: [
            "advlist autolink lists link image charmap print preview anchor",
            "searchreplace visualblocks code fullscreen",
            "insertdatetime media table contextmenu paste moxiemanager"
        ],
        toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
    });
}



function customMenu(node) {
    var items = {
        create: {
            separator_before: true,
            separator_after: false,
            label: "Добавить подраздел",
            action: function() {
                $("#addSection_dialog_parentId").val(node.attr("id"));
                $("#addSection_dialog" ).dialog( "open" );
            }
        },
        renameNode: {
            separator_before: true,
            separator_after: false,
            label: "Переименовать раздел",
            action: function() {
                $("#renameNode_dialog_parentId").val(node.attr("id"));
                $("#renameNode_dialog_name").val(node.attr("name"));
                $("#renameNode_dialog" ).dialog( "open" );
            }
        },
        deleteNode: {
            separator_before: true,
            separator_after: false,
            label: "Удалить раздел",
            action: function() {
                $("#deleteNode_dialog_parentId").val(node.attr("id"));
                $("#deleteNode_dialog label").append("<b>" + node.attr("name") + "</b>?");
                $("#deleteNode_dialog").dialog( "open" );
            }
        },


        renameSection: {
            separator_before: true,
            separator_after: false,
            label: "Переименовать подраздел",
            action: function() {
                $("#renameSection_dialog_parentId").val(node.attr("id"));
                $("#renameSection_dialog_name").val(node.attr("name"));
                $("#renameSection_dialog" ).dialog( "open" );
            }
        },
        deleteSection: {
            separator_before: true,
            separator_after: false,
            label: "Удалить подраздел",
            action: function() {
                $("#deleteSection_dialog_parentId").val(node.attr("id"));
                $("#deleteSection_dialog label").append("<b>" + node.attr("name") + "</b>?");
                $("#deleteSection_dialog" ).dialog( "open" );
            }
        }
    };
    if ($(node).hasClass("jstree-opened")) {
        delete items.create;
        delete items.renameNode;
        delete items.deleteNode;
    } else {
        delete items.renameSection;
        delete items.deleteSection;
    }

    return items;
}

function addDialogs() {
    $( "#addNode_dialog" ).dialog({
        autoOpen: false,
        buttons: {
            "Создать раздел": function() {
                addNode($("#addNode_dialog_name").val(), $("#addNode_dialog_title").val());
                $( this ).dialog( "close" );
            },
            "Отмена": function() {
                $( this ).dialog( "close" );
            }
        },
        width: '40%'
    });
    $( "#renameNode_dialog" ).dialog({
        autoOpen: false,
        buttons: {
            "Переименовать раздел": function() {
                renameNode($("#renameNode_dialog_parentId").val(),$("#renameNode_dialog_name").val());
                $( this ).dialog( "close" );
            },
            "Отмена": function() {
                $( this ).dialog( "close" );
            }
        },
        width: '40%'
    });
    $( "#deleteNode_dialog" ).dialog({
        autoOpen: false,
        buttons: {
            "Удалить раздел": function() {
                deleteNode($("#deleteNode_dialog_parentId").val());
                $( this ).dialog( "close" );
            },
            "Отмена": function() {
                $( this ).dialog( "close" );
            }
        },
        width: '40%'
    });



    $( "#addSection_dialog" ).dialog({
        autoOpen: false,
        buttons: {
            "Создать подраздел": function() {
                addSection($("#addSection_dialog_parentId").val(), $("#addSection_dialog_name").val(), $("#addSection_dialog_title").val());
                $( this ).dialog( "close" );
            },
            "Отмена": function() {
                $( this ).dialog( "close" );
            }
        },
        width: '40%'
    });
    $( "#renameSection_dialog" ).dialog({
        autoOpen: false,
        buttons: {
            "Переименовать подраздел": function() {
                renameSection($("#renameSection_dialog_parentId").val(),$("#renameSection_dialog_name").val());
                $( this ).dialog( "close" );
            },
            "Отмена": function() {
                $( this ).dialog( "close" );
            }
        },
        width: '40%'
    });
    $( "#deleteSection_dialog" ).dialog({
        autoOpen: false,
        buttons: {
            "Удалить подраздел": function() {
                deleteSection($("#deleteSection_dialog_parentId").val());
                $( this ).dialog( "close" );
            },
            "Отмена": function() {
                $( this ).dialog( "close" );
            }
        },
        width: '40%'
    });





}
