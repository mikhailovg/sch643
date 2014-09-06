$(function() {
    tinymce.init({
        selector: '#edit-document__description-textarea',
        plugins: [ 'advlist autolink link lists charmap print preview hr code table contextmenu directionality  textcolor paste textcolor' ],
        toolbar1: 'undo redo | cut copy paste | removeformat code',
        toolbar2: 'alignleft aligncenter alignright alignjustify | bullist numlist | outdent indent blockquote subscript superscript | table hr charmap | link unlink',
        toolbar3: 'bold italic underline strikethrough | forecolor backcolor | formatselect fontselect fontsizeselect',
        menubar: false,
        toolbar_items_size: 'small',
        height: 450

    });
});