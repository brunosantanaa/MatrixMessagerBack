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
  
  function isSetAndNOTEmpty($keys, $method=false) {
    $resp = true;
    $length = count($keys);
    $i = 0;
    while($resp && ($i < $length)){
      if (!$method) {
        $resp = isset($keys[$i]) && !empty($keys[$i]);
      }else {
        $resp = isset($GLOBALS["_".$method][$keys[$i]]) && !empty($GLOBALS["_".$method][$keys[$i]]);
      }
      $i++;
    }
    return $resp;
  }
?>