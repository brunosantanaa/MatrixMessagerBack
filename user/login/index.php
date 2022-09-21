<?php
require_once('../../db/controller.php');
  require_once('../../valide.php');
  // Handling data in JSON format on the server-side using PHP
  //
  header("Content-Type: application/json");
  // build a PHP variable from JSON sent using POST method
  $v = json_decode(stripslashes(file_get_contents("php://input")));
  // encode the PHP variable to JSON and send it back on client-side
  if(isSetAndNOTEmpty([$v->email, $v->password])) {
    $v->password = hash('sha256', $v->password);
    $result = json_decode(select_binds('USERS', (array)$v, 'UserID'));
    
    if(count($result) > 0){
      $t = time();
      $date = date('Y-m-d H:i:s', $t);
      $token = hash('sha256', $v->password.$result[0]->UserID.$t);
      $userID = $result[0]->UserID;
      $rep = array(
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
      $rep = array("error" => "Vérifiez votre nom d'utilisateur ou votre mot de passe.");
    }
  }else{
    $rep = array("error" => "No Params");
  };
  echo json_encode($rep);
?>