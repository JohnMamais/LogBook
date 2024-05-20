<?php


  if (session_status() === PHP_SESSION_NONE) {
      session_start();
  }

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
      case 'guest' : {

        break;
      }
      default:
            // Handle unexpected values gracefully
            echo "Unexpected value for isAdmin.";
            break;
    }
  } else {
    $_SESSION['user_id'] = $_SESSION['user'] = $_SESSION['isAdmin']= "guest";
  }

 ?>
