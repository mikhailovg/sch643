$(function() {


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
