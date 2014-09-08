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