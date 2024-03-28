<?php
  //Server Info
  $servername="localhost";
  $username="login";
  $password="Log_Book_2024_IEK_AIGALEO@login";
  $db="log_book";

  //connect
  $conn=mysqli_connect($servername,$username,$password, $db);
  if(!$conn){
    die("Connection failed: ". mysqli_connection_error());
  }
?>
