$(document).ready(function () {
    var NUMBER_OF_PAGES, LIMIT=10;
    var newsUi=$(".news__container");
    var pagingUi=$(".news__paging");
    var IS_ADMIN=false;

    function getNews(numberOfPage, limit, search, callback1, callback2) {
        $.ajax({
            url: "/php/actions/shared/getArticles.php",
            data: {
                pageNumber: numberOfPage,
                limit: limit,
                search: search
            },
            type: 'GET',
            success: function(res){
                if(callback1 && res)
                    callback1(res);
                if(callback2 && res)
                    callback2(res);
            }
        });

    }
    function renderNews(pagingResponse, callback) {
        newsUi.html('');
        IS_ADMIN=pagingResponse.isAdmin;

        newsUi.append('<div class="articles__label">Последние новости</div>');
        for (var i=0;i<pagingResponse.articles.length;i++) {
            newsUi.append(createArticleUi(pagingResponse.articles[i]));
        }
        //renderPaging(pagingResponse)
    }

    function createArticleUi(article){
        var articleUi=$('<div class="articles__article"></div>');

        if (IS_ADMIN) {
            articleUi.append('<a class="articles__edit-article-icon"></a>');
            articleUi.find('.articles__edit-article-icon').on("click",{article: article},function(e){
                var article = e.data.article;
                $('#saveArticle__dialog').data('article',article).dialog('open');
            });
            articleUi.append('<a class="articles__delete-article-icon"></a>');
        }
        var photoUi = $('<div class="articles__article-photo-wrapper"></div>');
        if (article.medium_image_thumbnail_path)
            photoUi.append('<a href=""><img class="articles__article-photo" src="'+article.medium_image_thumbnail_path+'"></a>');

        var textUi=$('<div class="articles__article-text-wrapper"></div>');
        textUi.append('<a class="articles__article-title">'+article.title+'</a>');
        textUi.append('<h5 class="articles__article-date">'+article.date+'</h5>');
        textUi.append('<div class="articles__article-announcement"><p>'+article.announcement+'</p></div>');
        //textUi.append('<a class="articles__article-read" href="article.php?article_id='+article.id+'">Читать дальше</a>');

        articleUi.append(photoUi);
        articleUi.append(textUi);

        return articleUi;
    }

    function renderPaging(pagingResponse) {
        pagingUi.html('');
        if (!NUMBER_OF_PAGES) {
            NUMBER_OF_PAGES = pagingResponse.numberOfPages;
            for (var i=0;i<NUMBER_OF_PAGES && NUMBER_OF_PAGES>1;i++) {
                var pageNumberUi = $('<span class = "page__number" val = "'+i+'">'+(i+1)+'</span>');
                pageNumberUi.click(function(){
                    //$(this).attr("current","true");
                    getNews($(this).attr("val"),LIMIT,renderNews);
                });
                pagingUi.append(pageNumberUi);
            }

        }

    }


    $('#saveArticle__dialog').dialog({
        width: '90%',
        open: function(){
            var article = $(this).data('article');
            $(this).find('.editArticle__titleString .editArticle__content').val(article.title);
            $(this).find('.editArticle__text .editArticle__content').val(article.text);
            $(this).find('.editArticle__img__forImg .img').attr('src',article.medium_image_thumbnail_path);
        },
        buttons: {
            "Сохранить": function() {

                $( this ).dialog( "close" );
            },
            "Отмена": function() {
                $( this ).dialog( "close" );
            }
        }
    });

    $('.search__input').click(function(){
        getNews(0,LIMIT,$(this).val(),renderNews, renderPaging);
    });

    getNews(0,LIMIT,undefined,renderNews, renderPaging);
});