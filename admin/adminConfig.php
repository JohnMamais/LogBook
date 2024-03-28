<?php

  //defining root(log_book) for file referencing
  //define('__ROOT__', dirname(dirname(__FILE__)));

  //Server Info
  $servername="localhost";
  $username="bookAdmin";
  $password="Log_Book_2024_IEK_AIGALEO@adminuser";
  $db="log_book";

  //connect
  $conn=mysqli_connect($servername,$username,$password, $db);
  if(!$conn){
    die("Connection failed: ". mysqli_connection_error());
  }
?>
