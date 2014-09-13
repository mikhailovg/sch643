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
        .bind("select_node.jstree", function(e,data){
           //console.log(data.rslt.obj);
            if (data.rslt.obj.attr("id")) {
                var node_id = data.rslt.obj.attr("id");
                getSectionsOfNode(node_id);
                $(".container_right").show();
                $(".layout1 .layout__content textarea").val(data.rslt.obj.attr("htmlContent"));
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
            //$(this).jstree('toggle_node',data.rslt.obj)
        })
        .jstree({
            contextmenu:{
                items:{
                    "create":{
                        separator_before: true,
                        separator_after: false,
                        label: "Добавить",
                        action: function(obj){
                            alert('privet')

                        }
                    }
                }
            },
            json_data:{
                progressive_render:true,
                ajax:{
                    url: "/admin/getPagesByParent",
                    data: function(n) {
                        console.log($(n).attr);
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
                                name: page.name
                            };
                            node.metadata = {
                                id:page.id,
                                name:page.name
                            };
                            node.data = page.name;
                            !page.parentId ? node.state='closed' : node.state='opened';
                            return node;
                        })

                    }
                }
            },
        "plugins" : [ "themes", "json_data", "ui",'crrm','contextmenu' ]
    }).bind('select_node.jstree', function (e, data) {
            $("#jstree").jstree("toggle_node", data.rslt.obj);

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