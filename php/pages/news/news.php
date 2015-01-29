<script src="/js/pages/news.js"></script>
<link href="/css/pages/news/articles.css" rel="stylesheet">


<div class="articles__search" enctype="application/x-www-form-urlencoded" method="POST">
    <label class="search__label" for="search__input">Поиск по новостям</label>
    <span title="Найти" class="search__icon" ></span>
    <input class="search__input" name="search__input" placeholder="Введите тему для поиска...">
</div>
<div class="news__container"></div>
<div class="news__paging"></div>



<div class="saveArticle__dialog" style="display: none;">
    <div class="template__columns">
        <div class="template__left-column">
            <div class='editArticle__id' style="display: none">
                <h3 for="id" class='editArticle__title'>Id</h3>
                <input type='hidden' class='editArticle__content' name="id">
            </div>
            <div class='editArticle__titleString'>
                <h3 for="title" class='editArticle__title'>Заголовок новости</h3>
                <input type='text' class='editArticle__content' name="title">
            </div>
            <div class='editArticle__text'>
                <h3 for="text" class='editArticle__title'>Текст новости</h3>
                <textarea class='editArticle__content' id='editArticle__content' name="text" rows="10" cols="30"></textarea>
            </div>
            <br/>
        </div>

        <div class='template__right-column'>

            <div class='editArticle__img'>
                <h3 for="img" class='editArticle__title'>Изображение</h3>
                <input type="hidden" name="img">
                    <div class="editArticle__img__forImg">
                        <img width="300px" height="220px" class='editArticle__imgContent' src=''>
                    </div>
                    <div class='editArticle__imgButtons'>
                        <button type="button" class="seto__button deleteImg">Удалить</button>
                        <input type="file" name="image" id="uploaded_image_src">
                    </div>
            </div>
            <div class='editArticle__video'>
                <h3 for="youtube_video_url" class='editArticle__title'>Видео</h3>
                <input type='text' class="youtube_video_url_original" placeholder="Ссылка на видео">

                <input type="hidden" name="youtube_video_url">

                    <div class="editArticle__video__forIframe">
                        <iframe width="300" height="200" src="" frameborder="0" allowfullscreen></iframe>
                    </div>
                    <div class='editArticle__videoButtons'>
                        <button type="button" class="seto__button uploadVideo" onclick=' $(".uploadVideo__dialog").dialog("open"); '>Загрузить</button>
                        <button type="button" class="seto__button deleteVideo">Удалить</button>
                    </div>

            </div>
        </div>
    </div>
    <div class="uploadImage__dialog" title="Загрузка изображения" style="display:none;"></div>
</div>