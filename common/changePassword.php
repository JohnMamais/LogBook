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
  $password = isset($_POST['password']) ? $_POST['password'] : null;
  $passwordCheck = isset($_POST['passwordVerify']) ? $_POST['passwordVerify'] : null;

  if ($uid!=null && $password!=null && $passwordCheck!=null) {

    $uid=test_input($uid);
    $password=test_input($password);
    $passwordCheck=test_input($passwordCheck);

    if (!empty($password) && !empty($uid)) {
      if($password == $passwordCheck){

        $hash=password_hash($password, $algo, $options);

          if(changePassword($conn, $hash, $uid)){
              $response = array('status' => 'success' , 'message' => 'Password changed successfully');
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
  $conn->close();

} else {
  echo json_encode(array('status' => 'error', 'message' => 'Invalid request method'));
  $conn->close();
}
 ?>
