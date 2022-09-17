<?php
require_once('../db/controller.php');

  header("Content-Type: application/json");
  // build a PHP variable from JSON sent using POST method
  $v = json_decode(stripslashes(file_get_contents("php://input")));
  if (isset($v->email, $v->conf_email, $v->password, $v->conf_password, $v->name)) {
    $v = (array) $v;
    unset($v["conf_email"]);
    unset($v["conf_password"]);
    $v["password"] = hash('sha256', $v["password"]);
    $result = json_decode(select_binds('USERS', ["email"=>$v["email"]]));
    if(count($result) < 1) {
      insert_binds('USERS', $v);
      $resp = array("register" => "success");
    } else {
      $resp = array("error"=>"user_exist");
    }
    
  } else {
    $resp = array("error"=>"no_data");
  }
  
  echo json_encode($resp);
?>