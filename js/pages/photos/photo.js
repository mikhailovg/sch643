$(function(){
    var hash = window.location.hash.substr(1);
    if (hash) {
        photo_id = parseInt(hash);
        display_photo(photo_id);
    }
    display_comments(photo_id);
    display_like(photo_id);

    $(document).on('click', '.photo__next-photo-thumbnail, .photo__next-page-icon, .photo__prev-page-icon, .photo__image', function(event){
        event.preventDefault();
        var href = $(this).attr('href');
        photo_id = parseInt(href.split('/photo/')[1]);

        // В случае старых браузеров работаем с хешом.
        if (!(window.history && history.pushState)) {
            if (location.pathname !== href) {
                window.location.hash = photo_id;
            } else {
                window.location.hash = '';
            }
        } else {
            window.history.pushState('', document.title, '/photo/' + photo_id);
        }
        display_photo(photo_id);
        display_comments(photo_id);
        display_like(photo_id);
    });

    function display_photo(photo_id) {
        photo = $.grep(album_photos, function(album_photo) {
            return  album_photo.photo_id === photo_id;
        })[0],
            photo_index = $.inArray(photo, album_photos),
            next_photo = album_photos[photo_index + 1],
            prev_photo = album_photos[photo_index - 1];

        $('#photo__image').attr('href', '/photo/' + (next_photo ? next_photo.photo_id : photo.photo_id)).find('img').attr('src', photo.big_image_path);
        $('#photo__original-size-image').toggle(photo.original_image_path !== photo.big_image_path).find('a').attr('href', photo.original_image_path);
        $('#photo__description').html(photo.description);
        $('#photo__delete-icon').attr('href', '/photo/' + photo_id + '/delete');
        $('#photo__edit-icon').attr('href', '/photo/' + photo_id + '/edit');


        var month_names = ['января', 'февраля', 'марта', 'арпеля', 'мая', 'июня', 'июля', 'августа', 'сентября', 'октября', 'ноября', 'декабря'],
            date_uploaded = photo.date_uploaded;
        $('.photo__date-uploaded').text(date_uploaded.getDate() + ' ' + month_names[date_uploaded.getMonth()] + ' ' + date_uploaded.getFullYear());

        var html = '';
        if (prev_photo) {
            html += '<a class="photo__prev-page-icon" href="/photo/' + prev_photo.photo_id + '" title="Предыдущее фото"> </a>'
        }
        $.each(album_photos, function(ap, album_photo) {
            if (ap >= photo_index - 2 && ap <= photo_index + 2 || (photo_index < 2 && ap < 5) || (photo_index > album_photos.length - 3 && ap > album_photos.length - 6)) {
                html += '<a class="photo__next-photo-thumbnail ' + (album_photo.photo_id === photo.photo_id ? "photo__next-photo-thumbnail--current" : "") + '" href="/photo/' + album_photo.photo_id + '">'
                    +  '<img src="' + album_photo.micro_image_path + '">'
                    +  '</a>';
            }
        });
        if (next_photo) {
            html += '<a class="photo__next-page-icon" href="/photo/' + next_photo.photo_id + '" title="Следующее фото"> </a>'
        }
        $('.photo__next-photos-thumbnails').html(html);
    }

    function display_comments(photo_id) {
        $('#photo__comments').empty();
        VK.Widgets.Comments('photo__comments', {width: 640, limit: 10, autoPublish:0}, 'photo' + photo_id);
    }
    function display_like(photo_id) {
        $('#photo__like').empty();
        VK.Widgets.Like("photo__like", {type: "mini"}, 'photo' + photo_id);
    }
});

