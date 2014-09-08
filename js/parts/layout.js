$(function() {
    tinymce.init({
        selector: "textarea",
        plugins: [
            "advlist autolink lists link image charmap print preview anchor",
            "searchreplace visualblocks code fullscreen",
            "insertdatetime media table contextmenu paste moxiemanager"
        ],
        toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
    });

    $.ajax({
        async: false,
        type: "GET",
        url: "/admin/getPages",
        success: function (data) {
            data = JSON.parse(data);
            for (var i=0; i<data.length; i++) {
                $(".layout1 .layout__nodes").append("<div class='text' node_id='" + data[i].id + "'>" + data[i].name + "</div>");
            }

        }
    });

    $(".layout__nodes .text").click(function() {
        var node_id = $(this).attr('node_id');
        $.ajax({
            async: false,
            type: "GET",
            url: "/admin/getLayouts",
            success: function (data) {
                data = JSON.parse(data);
                /*for (var i=0; i<data.length; i++) {
                    $(".layout1 .layout__nodes").append("<div class='text' node_id='" + data[i].id + "'>" + data[i].name + "</div>");
                }*/

            }
        });
    })
})


$(function() {

})