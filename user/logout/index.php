<?php
  require_once('../../db/controller.php');
  // Handling data in JSON format on the server-side using PHP
  //
  header("Content-Type: application/json");
  // build a PHP variable from JSON sent using POST method
  $v = json_decode(stripslashes(file_get_contents("php://input")));
  // encode the PHP variable to JSON and send it back on client-side
  if (isset($v->token)){
    $result = json_decode(select_binds('ACCESS', (array) $v));
    if(count($result) > 0){
      sql_query('DELETE FROM ACCESS WHERE Token = "'.$v->token.'"');
      $resp = array("logout" => "ok");
    } else {
      $resp = array("error" => "Not is a Token");
    }
  } else {
    $resp = array("error" => "No Data");
  }
  echo json_encode($resp);
?>