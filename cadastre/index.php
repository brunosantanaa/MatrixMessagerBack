<?php
require('../db/controller.php');
/*
req.email = document.getElementById('inscription_courriel').value;
  req.conf_email = document.getElementById('inscription_conf_courriel').value;
  req.password = document.getElementById('inscription_password').value;
  req.conf_password = document.getElementById('inscription_conf_password').value;
  req.nom = document.getElementById('inscription_nom').value;
  var result = await request('POST', '/cadastre', req); 
  */
  
  header("Content-Type: application/json");
  // build a PHP variable from JSON sent using POST method
  $v = json_decode(stripslashes(file_get_contents("php://input")));
  
  echo json_encode($v);
?>