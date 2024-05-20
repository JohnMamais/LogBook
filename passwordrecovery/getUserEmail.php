<?php
header('Content-Type: application/json'); // Set the content type to JSON

//handling of unauthorized users
$_PERMISSIONS = array('teacher' => 0, 'admin' => 0, 'guest' => 1, 'super' => 1);
include_once '../common/checkAuthorization.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the username from the POST request
    $username = isset($_POST['username']) ? $_POST['username'] : null;

    // execute mysqli to get the email of the user's account
    if ($username != null) {

      //include database connection
      include_once '../Configs/Conn.php';

      $sql="
      SELECT id, isActive, email, isAdmin
      FROM user
      WHERE username=?;
      ";

      $stmt = $conn->prepare($sql);
      //binding parameters
      $stmt->bind_param("s",$username);
      if($stmt->execute()){
        $stmt = $stmt->get_result();
        $user = $stmt->fetch_assoc();
        if($user){
          if ($user['isAdmin']==0){
            if ($user['isActive'] == 1){
              $response = array('status' => 'success', 'email' => $user['email'], 'id' => $user['id']);
            } else {
              $response = array('status' => 'error', 'message' => 'inactive user');
            }
          } else {
            $response = array('status' => 'error', 'message' => 'User is administrator');
          }
        } else {
          $response = array('status' => 'error', 'message' => 'invalid user');
        }
      } else {
        $response = array('status' => 'error', 'message' => 'mysqli error');
      }
      //closing statment
      $stmt->close();
    } else {
        // Otherwise, return an error message
        $response = array('status' => 'error', 'message' => 'Username not set');
    }

    $conn->close();

    echo json_encode($response); // Send the response back as JSON
} else {
    // Handle invalid request method
    echo json_encode(array('status' => 'error', 'message' => 'Invalid request method'));
}


?>
