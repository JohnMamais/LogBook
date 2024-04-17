<?php

include_once 'Configs/Conn.php';
  include_once 'Configs/Config.php';

  session_start();

  $_SESSION['user']=$_SESSION['user_id']=$_SESSION['isAdmin']='';

  session_destroy();

  header('location: '.__ROOT__.'/index.php');

?>
