$(function () {
    $( "#addNode_dialog" ).dialog({
        autoOpen: false,
        buttons: {
            "Создать узел": function() {
                addNode($("#addNode_dialog_name").val(), $("#addNode_dialog_title").val());
                $( this ).dialog( "close" );
            },
            "Отмена": function() {
                $( this ).dialog( "close" );
            }
        },
        width: '40%'
    });

    createJSTrees();
    addEventHandlers();
});

function createJSTrees() {
    $("#jstree")
        .bind("select_node.jstree", function(){
            var node_id = $.jstree._focused().get_selected().attr('id');
            getSectionsOfNode(node_id);
            $(".container_right").show();
        })
        .jstree({
            json_data:{
                progressive_render:true,
                ajax:{
                    url: "/admin/getPages",
                    success: function (data) {
                        for (var i=0; i<data.length; i++) {
                            $(".layout1 .layout__nodes").append("<div class='text' node_id='" + data[i].id + "'>" + data[i].name + "</div>");
                        }
                        return $.map(data, function (page) {
                            var node = {};
                            node.attr = {
                                id: page.id,
                                name: page.name
                            };
                            node.metadata = {
                                id:page.id,
                                name:page.name
                            };
                            node.data = page.name;
                            return node;
                        })

                    }
                }
            },
        "plugins" : [ "themes", "json_data", "ui" ]
    });
}

function getSectionsOfNode(node_id) {

}

function addEventHandlers() {
    $(".jstree_add_icon").click(function() {
        $( "#addNode_dialog" ).dialog( "open" );
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
        success: function () {
            createJSTrees();
        }
    });
}