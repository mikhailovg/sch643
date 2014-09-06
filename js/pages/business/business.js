$( document ).ready(function(){

    $(function(){
        $('.business__name-cell').on('click', function() {
            $(this).closest('.business__tbody').find('.business__info-row').toggleClass('business__info-row--collapsed');
        });
    });

    tinymce.init({
        selector: ".editBusiness__contactInput",
        plugins: [ 'advlist autolink link lists charmap print preview hr code table contextmenu directionality  textcolor paste textcolor' ],
        toolbar1: 'undo redo | cut copy paste | removeformat code',
        toolbar2: 'alignleft aligncenter alignright alignjustify | bullist numlist | outdent indent blockquote subscript superscript | table hr charmap | link unlink',
        toolbar3: 'bold italic underline strikethrough | forecolor backcolor | formatselect fontselect fontsizeselect',
        menubar: false,
        toolbar_items_size: 'small',
        height: 450

    })

    tinymce.init({
        selector: ".editBusiness__infoInput",
        plugins: [ 'advlist autolink link lists charmap print preview hr code table contextmenu directionality  textcolor paste textcolor' ],
        toolbar1: 'undo redo | cut copy paste | removeformat code',
        toolbar2: 'alignleft aligncenter alignright alignjustify | bullist numlist | outdent indent blockquote subscript superscript | table hr charmap | link unlink',
        toolbar3: 'bold italic underline strikethrough | forecolor backcolor | formatselect fontselect fontsizeselect',
        menubar: false,
        toolbar_items_size: 'small',
        height: 450

    })

    $("#business__deleteDialogMessage").dialog({
        autoOpen: false,
        title: "Удаление предприятия",
        resizable: false,
        buttons: [
            {
                text: "Удалить",
                click: function(){
                    $("#business__deleteDialogForm").submit();
                    $(this).dialog("close");
                }
            },
            {
                text: "Отмена",
                click: function(){
                    $(this).dialog("close");
                }
            }
        ]
    })

    $(".business__delete-event-icon").on("click", function(){
        var idEventForDelete = $(this).siblings(".business__idBusiness").val();
        $("#business__deleteDialogIdEvent").val(idEventForDelete);
        $("#business__deleteDialogMessage").dialog("open");
    })

})