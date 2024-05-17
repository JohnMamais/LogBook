<?php

require_once '../Configs/Conn.php';
require_once '../Configs/vars.php';

// Function to sanitize and validate input data
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

//function to hash the password and insert it in the DB
function changePassword($conn, $newPass, $uid){

  $sql="
  UPDATE user
  SET password=?
  WHERE id=?
  ";

  $stmt = $conn->prepare($sql);
  $stmt->bind_param('si',$newPass, $uid);
  try {
      $stmt->execute();
      return 1;
  } catch (\Exception $e) {
    return 0;
  }
}

$password = $passwordCheck = $uid = '';

if ($_SERVER['REQUEST_METHOD']=='POST') {

  //get POST data
  $uid = isset($_POST['uid']) ? $_POST['uid'] : null;
  $password = isset($_POST['password1']) ? $_POST['password1'] : null;
  $passwordCheck = isset($_POST['password2']) ? $_POST['password2'] : null;

  if ($uid!=null && $password!=null && $passwordCheck!=null) {

    $uid=test_input($uid);
    $password=test_input($password);
    $passwordCheck=test_input($passwordCheck);

    if (!empty($password) && !empty($uid)) {
      if($password == $passwordCheck){

        $hash=password_hash($password, $algo, $options);

        $conn->begin_transaction();

          if(changePassword($conn, $hash, $uid)){

            //disable token
            $sql="
            UPDATE passwordRecovery
            SET isActive=0
            WHERE uid=? AND isActive=1;
            ";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('i', $uid);
            if($stmt->execute()){
              $conn->commit();
              $response = array('status' => 'success' , 'message' => 'Password changed successfully');
            } else {
              $conn->rollback();
              $response = array('status' => 'error' , 'message' => 'ABORT: could not disable token');
            }
          } else {
            $response = array('status' => 'error' , 'message' => 'could not update password');
          }

      } else {
        $response = array('status' => 'error' , 'message' => 'Passwords not matching');
      }
    } else {
      $response = array('status' => 'error' , 'message' => 'Empty POST values');
    }
  } else {
    $response = array('status' => 'error' , 'message' => 'Null values');
  }

  echo json_encode($response); // Send the response back as JSON

} else {
  $conn->close();
  echo json_encode(array('status' => 'error', 'message' => 'Invalid request method'));
}
 ?>
