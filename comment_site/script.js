$(document).ready(function(){

    $('#addCommentForm').submit(function(e){
        e.preventDefault();

        $('#submit').val('Working..');
        $('span.error').remove();

        console.log("Incerc sa adaug comentariul");

        $.post('insert_comment.php',$(this).serialize(),function(msg){
            $('#submit').val('Submit');

            if(msg.status){
                $(msg.html).hide().insertBefore('#mesListHere').slideDown();

                $('#body').val('');
            }
            else {

                $.each(msg.errors,function(k,v){
                    $('label[for='+k+']').append('<span class="error">'+v+'</span>');
                });
            }
        },'json');
    });

    function load() {
        var param1 = $("#artid").val();
        console.log(param1);

        $.ajax({
            type: "GET",
            contentType: "application/json; charset=utf-8",
            url: "get_comments_from_db.php",
            data: {"id":param1},
            success: function (response) {
                var obj = $.parseJSON(response);
                $("#mesList").html('');
                $("#mesList").append(obj.html);
                setTimeout(load, 3000);
            }
        });
    }

    load();

});