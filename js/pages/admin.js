$(function () {
    createJSTrees(getJSONData());
});

function getJSONData() {
    var test = [];
    $.ajax({
            url : "/admin/getPages",
            dataType : "json",

            success : function(json) {
                for (var i = 0; i< json.length; i++) {
                    test.push({
                        "id" : json[i].id,
                        "name" : json[i].name
                    });
                }
            },

            error : function(xhr, ajaxOptions, thrownError) {
                alert(ajaxOptions);
                alert(thrownError);
                test = "error";
            }
        });
    return test;
}

function createJSTrees(jsonData) {
    $("#jstree").jstree({
        "json_data" :jsonData,
        "plugins" : [ "themes", "json_data", "ui" ]
    });
}