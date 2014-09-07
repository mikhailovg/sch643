$(function () {
    $("#jstree").jstree({
        'core' : {
            'data' : {
                'url' : '/get/children/',
                'data' : function (node) {
                    return { 'id' : node.id };
                }
            }
        }
    });
});