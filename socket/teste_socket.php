<?php
$i = 0;
$host = 'localhost';
$port = '1245';
$socket = socket_create(AF_INET, SOCK_STREAM, getprotobyname('tcp'));
socket_bind($socket, $host, $port) or die('Error');
echo socket_strerror(socket_last_error());
socket_listen($socket);
while(true) {
  $client[++$i] = socket_accept($socket);
  $msg = socket_read($client[$i], 1024);
  echo $msg;
  $msg = 'Hello  -> '.$msg."\n";
  socket_write($client[$i], $msg."\n\r", 1024);
  socket_close($client[$i]);

}
socket_close($socket);
?>