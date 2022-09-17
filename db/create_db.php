<?php
  require_once('controller.php');

  function createTables(){
    return '
    CREATE TABLE IF NOT EXISTS USERS(
      UserID INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
      name VARCHAR(45),
      email VARCHAR(60),
      password VARCHAR(64) );
    CREATE TABLE IF NOT EXISTS CONVERSATIONS(
      ConversationID INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
      title VARCHAR(50));
    CREATE TABLE IF NOT EXISTS MESSAGES(
      MessageID INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
      Content VARCHAR(150),
      Date DATETIME,
      User INT REFERENCES USERS(UserID),
      Conversation INT REFERENCES CONVERSATIONS(ConversationID));
    CREATE TABLE IF NOT EXISTS UsersConversations(
      User INT REFERENCES USERS(UserID),
      Conversation INT REFERENCES CONVERSATIONS(ConversationID));
    CREATE TABLE IF NOT EXISTS ACCESS(
      User INT NOT NULL REFERENCES USERS(UserID),
      Token VARCHAR(64) NOT NULL,
      Date datetime NOT NULL);
    --INSERT INTO CONVERSATIONS (title) VALUES ("General");
    ';
  }
  function dropTables($name) {
    return 'DROP TABLE '.$name;
  }
  if(isset($_GET["action"])) {
    if($_GET["action"] == "create") {
      sql_query(createTables());
      echo "CREATED";
    } else if($_GET["action"] == "drop"){
      if(isset($_GET["table"])) {
        sql_query(dropTables($_GET["table"]));
        echo 'DROP THIS TABLE: '.$_GET["table"];
      }
    }
  }
?>
