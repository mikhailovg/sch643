<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/jquery-ui.min.js"></script>
<link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/themes/smoothness/jquery-ui.css" />


<button id="button1"><span>Привет Post</span></button>
<script>
    $("#button1").click(function(){
        $.ajax({
            type:"POST",
            data: {
                number: 1,
                route: "admin/getPages"
            },
            url: "/admin/getPages",
            success: function(data){
                console.log(data);
            }
        });
    });

</script>