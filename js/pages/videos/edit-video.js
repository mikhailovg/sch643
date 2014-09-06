$(function() {
    tinymce.init({
        selector: '#edit-video__description-textarea',
        plugins: [ 'advlist autolink link lists charmap print preview hr code table contextmenu directionality  textcolor paste textcolor' ],
        toolbar1: 'undo redo | cut copy paste | removeformat code',
        toolbar2: 'alignleft aligncenter alignright alignjustify | bullist numlist | outdent indent blockquote subscript superscript | table hr charmap | link unlink',
        toolbar3: 'bold italic underline strikethrough | forecolor backcolor | formatselect fontselect fontsizeselect',
        menubar: false,
        toolbar_items_size: 'small',
        height: 450

    });

    $('.edit-video__url-input').on('change paste',function(){
        var input = $(this);
        setTimeout(function() {
            var url = input .val(),
                youtube_id = youtube_id_from_url(url);
            if (youtube_id) {
                $('#edit-video__video-id-input').val(youtube_id);
                var src = '//www.youtube.com/embed/' + youtube_id;
                if ($('#video__preview-iframe').attr('src') !== src) {
                    $('#video__preview-iframe').attr('src', src)
                }
                $('#edit-video__preview').show();
                $.get('http://gdata.youtube.com/feeds/api/videos/' + youtube_id + '?v=2&alt=json',function(data) {
                    var title=data.entry.title.$t,
                        description = data.entry.media$group.media$description.$t,
                        title_input = $('#edit-video__title-input'),
                        description_input = $('#edit-video__description-input');
                    if (!title_input.val()) {
                        title_input.val(title);
                    }
                    if (!description_input.val()) {
                        tinymce.editors[0].setContent(description);
                    }
                });
            } else {
                $('#edit-video__preview').hide();
            }
        });
    });

});


function youtube_id_from_url(url){
    var regExp = /^.*((youtu.be\/)|(v\/)|(\/u\/\w\/)|(embed\/)|(watch\?))\??v?=?([^#\&\?]*).*/;
    var match = url.match(regExp);
    if (match&&match[7].length==11){
        return match[7];
    } else{
        return null;
    }
}