<?php
//should be true if this is online
$published=false;
#$published=true;

if($published){
  //Root directory
  define('__ROOT__', 'https://iekaigal.att.sch.gr/logbook');

  //Server Info
  $serverName="localhost";
  $serverUsername="UWCC";
  $password="Cardiff2021@";
  $dbname="log_book";

} else {
  //Root directory
  define('__ROOT__', 'http://localhost/logbook');

  //Server Info
  $serverName="localhost";
  $serverUsername="user";
  $password="";
  $dbname="Log_Book";

}

//connecting to database
$GLOBALS['conn'] = mysqli_connect($serverName, $serverUsername, $password, $dbname);
if(!$conn){
    die("Connection to database failed.". mysqli_connect_error());
}
 ?>
