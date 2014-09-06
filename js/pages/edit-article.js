$(document).ready(function () {
    tinymce.init({
        selector: ".editArticle__text .editArticle__content",
        plugins: [ 'advlist autolink link lists charmap print preview hr pagebreak code table contextmenu directionality  textcolor paste textcolor image filemanager ' ],
        toolbar1: 'undo redo | cut copy paste | removeformat code',
        toolbar2: 'alignleft aligncenter alignright alignjustify | bullist numlist | outdent indent blockquote subscript superscript | table hr charmap |  image | link unlink | pagebreak',
        toolbar3: 'bold italic underline strikethrough | forecolor backcolor | formatselect fontselect fontsizeselect sizeselect ',
        menubar: false,
        toolbar_items_size: 'small',
        fontsize_formats: "8px 9px 10px 11px 12px 13px 14px 18px 26px",
        height: 450
    });

    $(".editArticle__imgButtons input").change(function() {
        console.log($(this).val());
        if ($(this).val() != null)
            $(".deleteImg").show();
        else
            $(".deleteImg").hide();
    });

    $(".uploadVideo").click(function(){
        if ($(".youtube_video_url_original").val() != "") {
            $(".editArticle__video input[name=youtube_video_url]").val($(".youtube_video_url_original").val());
            $(".editArticle__video .editArticle__video__forIframe").html('<iframe width="300" height="200" name="youtube_video_url" src="' + youtube_url($(".editArticle__video input[name=youtube_video_url]").val()) + '" frameborder="0" allowfullscreen></iframe>');
            $(".deleteVideo").show();
        }
    });

    $(".deleteVideo").click(function(){
        $(".editArticle__video .editArticle__video__forIframe").empty();
        $(".editArticle__video input").val('');
        $(".deleteVideo").hide();
    });

    $(".deleteImg").click(function(){
        $(".editArticle__imgButtons input").val('');
        $(".editArticle__img__forImg").empty();
        $(".editArticle__img input[name=img]").val('');
        $(".deleteImg").hide();
    });
});

function youtube_url(url) {
    return url.replace("http:", "").replace("watch?v=", "embed/");
}
