<?php
/*
-include this file to check for user authorization
-in order for it to work properly you first need to initialize
an array called '_PERMISSIONS' with 4 indexes
index 0 is for teacher -> 1 for authorized | 0 for not authorized
index 1 is for admin, same as above
index 2 is for guest
index 4 should always be 1 as it is for superadmin

example for a page that should be accessed only by teachers:
$_PERMISsIONS = array('teacher' => 1, 'admin' => 0, 'guest' => 0, 'super' => 1);

-include this after you have started a session

*/

include_once 'commonFunctions.php';

function mapUserToString($isAdmin){
  //maps isAdmin (from SESSION) to the user typpe as string
  switch ($isAdmin) {
    case '0':
      return 'teacher';
      break;
    case '1':
      return 'admin';
      break;
    case '2':
      return 'super';
      break;
    default:
      return 'guest';
      break;
  }

}

//checking for authorization

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$userType = mapUserToString($_SESSION['isAdmin'] ?? 'guest');

$flag=0;

foreach ($_PERMISSIONS as $user => $allowed) {
  if($allowed && $user==$userType){
    //raise a flag if the user type in the session is the same as
    //the user type that can access the specific page
    $flag=1;
    break;
  }
}


if(!$flag){
    //if the user is not allowed to view the page kick them out of the site
    $log="Unauthorized user attempted to access.";

    insertLog($conn, $log);

    // Close the connection if it is open
    if (isset($conn) && $conn instanceof mysqli) {
        $conn->close();
    }

    header("Location: ../logout.php");
    exit();
}
 ?>
