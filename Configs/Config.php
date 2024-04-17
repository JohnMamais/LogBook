<?php

  session_start();

  if(isset($_SESSION['isAdmin'])){
    $testVar=$_SESSION['isAdmin'];
    //navbars
    switch($testVar){
      case 0:{
        include_once 'teacherNavbar.php';
        break;
      }
      case 1:{
        include_once 'adminNavbar.php';
        break;
      }
      case 2:{
        include_once 'superadminNavbar.php';
        break;
      }
      default:
            // Handle unexpected values gracefully
            echo "Unexpected value for isAdmin.";
            break;
    }
  }

  //password hashing
  $algo= PASSWORD_ARGON2ID;
  $options = [
      'memory_cost' => 65536, // 64 MB
      'time_cost'   => 11,     // 11 iterations
      'threads'     => 4,     // 2 threads
  ];


 ?>
