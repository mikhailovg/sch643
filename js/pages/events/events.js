
$( document ).ready(function(){

    $(function(){
        $('.events__event .events__name-column').on('click', function() {
            $(this).closest('.events__event').find('.events__info-row').toggleClass('events__info-row--collapsed');
        });
    });

    $(".editEvent__date").datepicker({
        showOn: "button",
        buttonImage: "/img/calendar.png",
        buttonImageOnly: true,
        dateFormat: 'yy-mm-dd',
        showButtonPanel: true
    });

    tinymce.init({
        selector: ".editEvent__infoInput",
        plugins: [ 'advlist autolink link lists charmap print preview hr code table contextmenu directionality  textcolor paste textcolor' ],
        toolbar1: 'undo redo | cut copy paste | removeformat code',
        toolbar2: 'alignleft aligncenter alignright alignjustify | bullist numlist | outdent indent blockquote subscript superscript | table hr charmap | link unlink',
        toolbar3: 'bold italic underline strikethrough | forecolor backcolor | formatselect fontselect fontsizeselect',
        menubar: false,
        toolbar_items_size: 'small',
        height: 450

    })

    $("#events__deleteDialogMessage").dialog({
        autoOpen: false,
        title: "Удаление события",
        resizable: false,
        buttons: [
            {
                text: "Удалить",
                click: function(){
                    $("#events__deleteDialogForm").submit();
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

    $(".events__delete-event-icon").on("click", function(){
        var idEventForDelete = $(this).siblings(".events__idEvent").val();
        $("#events__deleteDialogIdEvent").val(idEventForDelete);
        $("#events__deleteDialogMessage").dialog("open");
    })

    VK.Widgets.Comments('events__comments', {width: 640, limit: 10, autoPublish:0}, 'events');

})



