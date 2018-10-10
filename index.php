<!DOCTYPE html>
<html>
    <head>
        <title>Sistema de Comentarios - PHP e Ajax</title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    </head>
    <body>
        <br />
        <h2 align="center"><a href="#">Sistema de Comentarios - PHP e Ajax</a></h2>
        <br />
        <div class="container">
            <form method="POST" id="comment_form">
                <div class="form-group">
                    <input type="text" name="comment_name" id="comment_name" class="form-control" placeholder="Nome" />
                </div>
                <div class="form-group">
                    <textarea name="comment_content" id="comment_content" class="form-control" placeholder="Comentário" rows="5"></textarea>
                </div>
                <div class="form-group">
                    <input type="hidden" name="comment_id" id="comment_id" value="0" />
                    <input type="submit" name="submit" id="submit" class="btn btn-info" value="Enviar" />
                </div>
            </form>
            <span id="comment_message"></span>
            <br />
            <div id="display_comment"></div>
        </div>
    </body>
</html>

<script type="text/javascript">
$(document).ready(function(){
 
    $('#comment_form').on('submit', function(event){
        event.preventDefault();
        var form_data = $(this).serialize();
        $.ajax({
            url:"add_comment.php",
            method:"POST",
            data:form_data,
            dataType:"JSON",
            success:function(data){
                    if(data.error != ''){
                        $('#comment_form')[0].reset();
                        $('#comment_message').html(data.error);
                        $('#comment_id').val('0');
                        load_comment();
                    }
            }
        })
    });

    $('#comment_form2').on('submit', function(event){
        event.preventDefault();
        var form_data = $(this).serialize();
        $.ajax({
            url:"add_comment.php",
            method:"POST",
            data:form_data,
            dataType:"JSON",
            success:function(data){
                    if(data.error != ''){
                        $('#comment_form2')[0].reset();
                        $('#comment_message').html(data.error);
                        load_comment();
                    }
            }
        })
    });

 load_comment();

    function load_comment(){
        $.ajax({
            url:"fetch_comment.php",
            method:"POST",
            success:function(data){
                $('#display_comment').html(data);
            }
        })
    }
    var contador = 0;
    $(document).on('click', '.reply', function(){

        var comment_id = $(this).attr("id");
        $('#comment_id'+comment_id).val(comment_id);
        

        var x = document.getElementById("toggle"+comment_id);
        
        if (x.style.display === "none") {
        
            x.style.display = "block";
        
        } else {
        
            x.style.display = "none";
        
        }
        
        /*$('.panel-footer'+ comment_id).append("<form method='POST' id='comment_form2' action='cadastra.php'>"+
        "<input type='text' name='comment_name' id='comment_name' class='form-control' placeholder='Enter Name' />"+
        "<textarea name='comment_content' id='comment_content' class='form-control' placeholder='Enter Comment' rows='1'></textarea>"+
        "<input type='hidden' name='comment_id' id='comment_id"+comment_id+"' value='"+comment_id+"' />"+
        "<input type='submit' name='submit' id='submit' class='btn btn-info' value='Submit' /> </form>"   
        );*/
        
        
        //$('button').remove("#"+comment_id);
        //$('#comment_name').focus();
    });
 
});

</script>