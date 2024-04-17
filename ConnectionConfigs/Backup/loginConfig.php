<?php
  //Server Info
  $serverName="iekaigal.att.sch.gr";
  $serverUsername="UWCC";
  $password="Cardiff2021@";
  $dbname="Log_Book";

  //connecting to database
  $GLOBALS['conn'] = mysqli_connect($serverName, $serverUsername, $password, $dbname);
  if(!$conn){
      die("Connection to database failed.". mysqli_connect_error());
  }
  ?>
