<?php
$i = 0;
$host = 'localhost';
$port = '1245';

while($i<1) {
  $msg="Teste\n";
  $socket = socket_create(AF_INET, SOCK_STREAM, 0) or die('Error create socket');
  $result = socket_connect($socket, $host, $port) or die('Error connect');
  //socket_write($socket, $msg, strlen($msg)) or die('Error write msg');

  $result = socket_read($socket, 1024) or die('Could not read server response');
  echo $result."\n";
  socket_close($socket);
  //$i++;
}
?>