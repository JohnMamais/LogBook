<?php

  define('__ROOT__', 'http://localhost/LogBook');

  session_start();

  $_SESSION['user']=$_SESSION['user_id']=$_SESSION['isAdmin']='';

  session_destroy();

  header('location: '.__ROOT__.'/index.php');

?>
