<?php
require_once('../db/controller.php');
require_once('../valide.php');

  header("Content-Type: application/json");
  // build a PHP variable from JSON sent using POST method
  $v = json_decode(stripslashes(file_get_contents("php://input")));
  if (isset($v->token)) {
    $result = json_decode(is_valid($v));
    if($result->access) {
      $conversations = json_decode(sql_query('SELECT ConversationID, title FROM CONVERSATIONS INNER JOIN UsersConversations ON `ConversationID`=`Conversation` WHERE User='.$result->User));
      $resp = [];
      foreach ($conversations as $key => &$value) {
        $value = (array) $value;
        $msgs = json_decode(
          sql_query('SELECT MessageID, Content, Date, User, name FROM MESSAGES INNER JOIN USERS ON User=UserID WHERE Conversation='.$value["ConversationID"].' ORDER BY Date;'));
        $value += array("messages" => $msgs);
        $resp += array($key => $value);
      }
      echo json_encode($resp);
    } else {
      echo json_encode($result);
    }
  }
?>