<?php
require('../db/controller.php');
  // Handling data in JSON format on the server-side using PHP
  //
  header("Content-Type: application/json");
  // build a PHP variable from JSON sent using POST method
  $v = json_decode(stripslashes(file_get_contents("php://input")));
  // encode the PHP variable to JSON and send it back on client-side
  if(isset($v->email, $v->password)) {

    $result = json_decode(select_binds('USERS', (array)$v, 'UserID'));
    
    if(count($result) > 0){
      $t = time();
      $date = date('Y-m-d H:i:s', $t);
      $token = hash('sha256', $result[0]->UserID.$t);
      $userID = $result[0]->UserID;
      $rep = array(
        "user" => $userID,
        "token" => $token,
        "date" => $date
      );
      $result = json_decode(select_binds('ACCESS', array("User"=>$userID)));
      if(count($result) > 0){
        sql_query('UPDATE ACCESS SET Token = "'.$token.'", Date = "'.$date.'" WHERE User = '.$userID);
      } else {
        sql_query('INSERT INTO ACCESS VALUES ('.$userID.',"'.$token.'","'.$date.'")');
      }
    } else {
      $rep = array("error" => "no_user");
    }
  }else{
    $rep = array("error" => "bad_params");
  };
  echo json_encode($rep);
?>