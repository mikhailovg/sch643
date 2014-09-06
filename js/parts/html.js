 tinymce.init({
    selector: "textarea.partsHtml__Edit",
     plugins: [ 'advlist autolink link lists charmap print preview hr code table contextmenu directionality  textcolor paste textcolor image filemanager' ],
     toolbar1: 'undo redo | cut copy paste | removeformat code',
     toolbar2: 'alignleft aligncenter alignright alignjustify | bullist numlist | outdent indent blockquote subscript superscript | table hr charmap |  image | link unlink',
     toolbar3: 'bold italic underline strikethrough | forecolor backcolor | formatselect fontselect fontsizeselect sizeselect ',
     menubar: false,
     toolbar_items_size: 'small',
     fontsize_formats: "8px 9px 10px 11px 12px 13px 14px 18px 26px",
     height: 450
 })

