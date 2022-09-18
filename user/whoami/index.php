<?php
require_once('../../db/controller.php');
require_once('../../valide.php');

  header("Content-Type: application/json");
  // build a PHP variable from JSON sent using POST method
  $v = json_decode(stripslashes(file_get_contents("php://input")));
  if (isset($v->token)) {
    $result = json_decode(is_valid($v));
    if($result->access) {
      $resp = sql_query('SELECT UserID, name, email FROM USERS INNER JOIN ACCESS ON UserID=User WHERE Token="'.$v->token.'"');
      echo $resp;
    } else {
      echo json_encode($result);
    }
  }
?>