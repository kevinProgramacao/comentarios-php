<?php

$connect = new PDO('mysql:host=localhost;dbname=exercicio', 'root', '');

$query = "
SELECT *,DATE_FORMAT(date,'%d/%m/%Y') AS date FROM tbl_comment 
WHERE parent_comment_id = '0' 
ORDER BY comment_id DESC
";

$statement = $connect->prepare($query);

$statement->execute();

$result = $statement->fetchAll();
$output = '';

foreach($result as $row){

  $output .= '
    <div class="panel panel-default">
      <div class="panel-heading">Por <b>'.$row["comment_sender_name"].'</b> em <i>'.$row["date"].'</i></div>
      <div class="panel-body">'.$row["comment"].'</div>
      <div class="panel-footer'.$row["comment_id"].'" align="right">
        <button type="button" class="btn btn-default reply" id="'.$row["comment_id"].'">Responder</button>
        <div id="toggle'.$row["comment_id"].'" style="display:none;">
          <form method="POST" id="comment_form2" style="margin-top: 10px;">
          <input type="text" name="comment_name" id="comment_name" class="form-control" placeholder="Nome" style="margin-bottom: 6px;"/>
          <textarea name="comment_content" id="comment_content" class="form-control" placeholder="Comentário" rows="1"></textarea>
          <input type="hidden" name="comment_id" id="comment_id'.$row['comment_id'].'" value="'.$row['comment_id'].'" />
          <input type="submit" name="submit" id="submit" class="btn btn-info" value="Enviar" style="margin-top: 5px;"/> </form>
        </div>
      </div>
    </div>
  ';
  $output .= get_reply_comment($connect, $row["comment_id"]);
}

echo $output;

function get_reply_comment($connect, $parent_id = 0, $marginleft = 0){

    $query = "SELECT *,DATE_FORMAT(date,'%d/%m/%Y') AS date FROM tbl_comment WHERE parent_comment_id = '".$parent_id."'";
    $output = '';
    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    $count = $statement->rowCount();

    if($parent_id == 0){

      $marginleft = 0;
    
    }else{

      $marginleft = $marginleft + 48;

    }if($count > 0){

      foreach($result as $row){

        $output .= '
        <div class="panel panel-default" style="margin-left:'.$marginleft.'px">
          <div class="panel-heading">Por <b>'.$row["comment_sender_name"].'</b> em <i>'.$row["date"].'</i></div>
          <div class="panel-body">'.$row["comment"].'</div>
          <div class="panel-footer'.$row["comment_id"].'" align="right"></div>
        </div>
        ';
        $output .= get_reply_comment($connect, $row["comment_id"], $marginleft);
      }
    }
    return $output;
}

?>