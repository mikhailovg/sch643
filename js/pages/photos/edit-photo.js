$(function() {
    tinymce.init({
        selector: '#edit-photo__description textarea',
        plugins: [ 'advlist autolink link lists charmap print preview hr code table contextmenu directionality  textcolor paste textcolor' ],
        toolbar1: 'undo redo | cut copy paste | removeformat code',
        toolbar2: 'alignleft aligncenter alignright alignjustify | bullist numlist | outdent indent blockquote subscript superscript | table hr charmap | link unlink',
        toolbar3: 'bold italic underline strikethrough | forecolor backcolor | formatselect fontselect fontsizeselect',
        menubar: false,
        toolbar_items_size: 'small',
        height: 450

    });

    $(document).on('change',':file', function() {
        if ($(this).val()) {
            $('.edit-photo__file').append('<input class="edit-photo__file" type="file" name="files[]" multiple="true">');
        }
    })
});
