function openInNewTab(url )
{
    var win=window.open(url, '_blank');
    win.focus();
}

$(document).ready(function () {

    var hash = window.location.hash.substr(1);
    if (hash) {
        article_id = parseInt(hash);
    }
    display_comments(article_id);
    display_like(article_id);
    $(".article__img").click(function() {
        openInNewTab($(this).attr('originalImagePath'));
    })

    $(".article__delete-article-icon").click(function() {
        $(".article__delete-article-icon").hide();
        $(".article__edit-article-icon").hide();
        $(".deleteArticleButton").show();
    })
});

function display_comments(article_id) {
    $('#article__comments').empty();
    VK.Widgets.Comments('article__comments', {width: 640, limit: 10, autoPublish:0}, 'article' + article_id);
}
function display_like(article_id) {
    $('#article__like').empty();
    VK.Widgets.Like("article__like", {type: "mini"}, 'article' + article_id);
}
