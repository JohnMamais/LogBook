<?php

//handling of unauthorized users
$_PERMISSIONS = array('teacher' => 1, 'admin' => 1, 'guest' => 0, 'super' => 1);
include_once '../common/checkAuthorization.php';

require_once '../Configs/Conn.php';

// Function to sanitize and validate input data
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

//to be implemented later
//function to test if the user provided a correct password to verify the change
function verifyUser($conn, $uid, $pass){

  return 1;
}
//function to hash the password and insert it in the DB
function changeEmail($conn, $newMail, $uid){

  $sql="
  UPDATE user
  SET email=?
  WHERE id=?
  ";

  $stmt = $conn->prepare($sql);
  $stmt->bind_param('si',$newMail, $uid);
  try {
      $stmt->execute();
      return 1;
  } catch (\Exception $e) {
    return 0;
  }
}


$email = $emailV = $uid = '';

if ($_SERVER['REQUEST_METHOD']=='POST') {

  //get POST data
  $uid = isset($_POST['uid']) ? $_POST['uid'] : null;
  $email = isset($_POST['email']) ? $_POST['email'] : null;
  $emailV = isset($_POST['emailVerify']) ? $_POST['emailVerify'] : null;

  //echo "$uid , $email , $emailV";

  if ($uid!=null && $email!=null && $emailV!=null) {

    $uid=test_input($uid);
    $email=test_input($email);
    $emailV=test_input($emailV);

    if (!empty($email) && !empty($uid)) {
      if($email == $emailV && filter_var($email, FILTER_VALIDATE_EMAIL)){

          if(changeEmail($conn, $email, $uid)){
              $response = array('status' => 'success' , 'message' => 'Email changed successfully');
          } else {
            $response = array('status' => 'error' , 'message' => 'could not update email');
          }
      } else {
        $response = array('status' => 'error' , 'message' => 'Emails not valid');
      }
    } else {
      $response = array('status' => 'error' , 'message' => 'Empty POST values');
    }
  } else {
    $response = array('status' => 'error' , 'message' => 'Null values');
  }

  echo json_encode($response); // Send the response back as JSON
  $conn->close();

} else {
  echo json_encode(array('status' => 'error', 'message' => 'Invalid request method'));
  $conn->close();
}
 ?>
