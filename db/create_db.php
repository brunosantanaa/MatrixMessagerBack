<?php
  require('controller.php');

  function createTables(){
    return '
    CREATE TABLE IF NOT EXISTS USERS(
      UserID INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
      name VARCHAR(45),
      email VARCHAR(60),
      password VARCHAR(50) );
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
    ';
  }
  function dropTables($name) {
    return 'DROP TABLE '.$name;
  }
  var_dump(sql_query(createTables()));
?>
