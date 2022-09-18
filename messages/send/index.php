<?php
require_once('../../db/controller.php');
require_once('../../valide.php');

  header("Content-Type: application/json");
  // build a PHP variable from JSON sent using POST method
  $v = json_decode(stripslashes(file_get_contents("php://input")));
  if (isset($v->token)) {
    $result = json_decode(is_valid($v));
    if($result->access) {
      if(isset($v->message) && strlen($v->message) <= 150) {
        $t = time();
        $date = date('Y-m-d H:i:s', $t);
        $sub_query = 'SELECT User FROM ACCESS WHERE Token="'.$v->token.'" ORDER BY User LIMIT 1';
        sql_query('INSERT INTO MESSAGES (Content, Date, User, Conversation) VALUES ("'.$v->message.'", "'.$date.'", ('.$sub_query.'), '.$v->ConversationID.')');
        $resp = array("send" => "OK");
      }else{
        $resp = array("error" => "Message manquant ou trop volumineux.");
      }
      echo json_encode($resp);
    } else {
      echo json_encode($result);
    }
  }
?>