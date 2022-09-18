<?php
  require_once('db/controller.php');
  function is_valid($request) {
    if(isset($request->token)){
      $resp = json_decode(sql_query('SELECT * FROM ACCESS WHERE Token="'.$request->token.'"'));
      if(count($resp) > 0) {
        $resp = (array) $resp[0];
        $resp += ["access" => true];
        return json_encode($resp);
      } else {
        return json_encode(["access" => false]);
      }
    } else {
      return json_encode(["access" => false]);
    }
  }
?>