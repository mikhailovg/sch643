$(function () {
    $("#jstree").jstree({
        'core' : {
            'data' : {
                'url' : '/tree/get/',
                'data' : function (node) {
                    return { 'id' : node.id };
                }
            }
        }
    });
});