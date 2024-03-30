<?php
  //Server Info
  $serverName="localhost";
  $serverUsername="login";
  $password="Log_Book_2024_IEK_AIGALEO@login";
  $dbname="log_book";

  //connecting to database
  $GLOBALS['conn'] = mysqli_connect($serverName, $serverUsername, $password, $dbname);
  if(!$conn){
      die("Connection to database failed.". mysqli_connect_error());
  }
  ?>
