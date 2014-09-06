
$(document).ready(function () {
    if ($(".articles__pages a").length > 0) {
        $(".articles__pages a").show();
        $(".articles__pages span").show();
        $(".articles__pages a").addClass("articles__page");
        $(".articles__pages span").addClass("articles__page articles__page--current");

        for (var i =0; i<$(".articles__pages a").length; i++) {
            if ($(".articles__pages a").eq(i).text() == '<') {
                $(".articles__pages a").eq(i).addClass("articles__prev-page-icon");
                $(".articles__pages a").eq(i).text('');
            }
            else if ($(".articles__pages a").eq(i).text() == '>') {
                $(".articles__pages a").eq(i).addClass("articles__next-page-icon");
                $(".articles__pages a").eq(i).text('');
            }
        }
    }
    else
        $(".articles__pages span").hide();

    /*if (typeof(VK) != "undefined") {
        VK.Widgets.Group("vk-groups__iframe", {mode: 0, width: "300", height: "400"}, 5481857);
    }*/
    for (var i=0; i<ids.length; i++) {
        VK.Widgets.Like("article__like"+ids[i], {type: "mini"}, 'article' + ids[i]);
    }
});