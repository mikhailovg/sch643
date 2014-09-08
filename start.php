<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/jquery-ui.min.js"></script>
<link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/themes/smoothness/jquery-ui.css" />

<div id="content"></div>
<button id="button1"><span>Get Pages</span></button>
<button id="button2"><span>Get Layouts</span></button>
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
                data=$.parseJSON(data);
                $('#content').append(data[1].htmlContent);
                console.log(data[1]);
            }
        });
    });

    $("#button2").click(function(){
        $.ajax({
            type:"GET",
            url: "/admin/getLayouts",
            success: function(data){
                data=$.parseJSON(data);
                $('#content').append(data[0].htmlContent);
                console.log(data[1]);
            }
        });
    });

</script>