<?php
$user = 'root';
$password = '';
$db = 'MatrixMessagerDB';
function connect() {
  global $db, $user, $password;
  try {
    $connection = new PDO("mysql:host=localhost;dbname=".$db, $user, $password);
    return $connection;
  }catch (PDOException $e) {
    return array("ERROR" => $e->getMessage());
    exit;
  }
}

function sql_query($query) {
  //echo $query;
  try {
    $connection = connect();
    $sth = $connection->prepare($query);
    $sth->execute();
    return json_encode($sth->fetchAll(PDO::FETCH_ASSOC));
  }catch (PDOException $e) {
    return array("ERROR" => $e->getMessage());
    exit;
  }
}

function select_binds($table, $binds, $colums='*') {
  $query = 'SELECT ';
  if (is_array($colums)) {
    foreach($colums as $v) {
      $query = $query.$table.'.'.$v.', ';
    }
    $query = substr($query, 0, -2).' FROM '.$table;
  } else {
    $query = $query.$colums.' FROM '.$table;
  }
  
  $query = $query.' WHERE ';
  foreach($binds as $key => &$value) {
    $query = $query.$key.' = :'.$key.' AND ';
  }
  $query = substr($query, 0, -5);
 //echo $query;
  try {
    $connection = connect();
    $sth = $connection->prepare($query);
    foreach($binds as $key => &$value) {
      $sth->bindParam($key, $value);
    }
    $sth->execute();
    
    return json_encode($sth->fetchAll(PDO::FETCH_ASSOC));
  } catch(PDOException $e) {
    return array("ERROR" => $e->getMessage());
    exit;
  }
}
function insert_binds($table, $binds) {
  $query = 'INSERT INTO '.$table.' (';
  foreach($binds as $key => &$value) {
    $query = $query.$key.', ';
  }
  $query = substr($query, 0, -2).') VALUES (';
  foreach($binds as $key => &$value) {
    $query = $query.':'.$key.', ';  
  }
  $query = substr($query, 0, -2).');';
 //echo $query;
 
  try {
    $connection = connect();
    $sth = $connection->prepare($query);
    foreach($binds as $key => &$value) {
      $sth->bindParam($key, $value);
    }
    $sth->execute();
    
    return json_encode($sth->fetchAll(PDO::FETCH_ASSOC));
  } catch(PDOException $e) {
    return array("ERROR" => $e->getMessage());
    exit;
  }
}
?>