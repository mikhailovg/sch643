$("#document__deleteDialogMessage").dialog({
    autoOpen: false,
    title: "Удаление предприятия",
    resizable: false,
    buttons: [
        {
            text: "Удалить",
            click: function(){
                $("#document__deleteDialogForm").submit();
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

$(".documents__delete-document-icon").on("click", function(){
    var idDocumentForDelete = $(this).siblings(".document__idBusiness").val();
    $("#document__deleteDialogIdEvent").val(idDocumentForDelete);
    $("#document__deleteDialogMessage").dialog("open");
})