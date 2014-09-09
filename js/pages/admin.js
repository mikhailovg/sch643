$(function () {
    createJSTrees();
});

function createJSTrees() {
    $("#jstree").jstree({
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