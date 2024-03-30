<?php
  //Server Info
  $serverName="localhost";
  $serverUsername="teacher";
  $password="Log_Book_2024_IEK_AIGALEO@teacheruser";
  $dbname="log_book";

  //connecting to database
  $GLOBALS['conn'] = mysqli_connect($serverName, $serverUsername, $password, $dbname);
  if(!$conn){
      die("Connection to database failed.". mysqli_connect_error());
  }
?>
