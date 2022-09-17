<?php
  require_once('./db/controller.php');
  function is_valid($request) {
    if(isset($request->token)){
      $resp = json_decode(sql_query('SELECT * FROM ACCESS WHERE Token="'.$request->token.'"'));
      return (count($resp) > 0);
    } else {
      return false;
    }
  }
?>