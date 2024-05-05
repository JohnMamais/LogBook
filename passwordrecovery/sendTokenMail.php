<?php
/*
This php script generates a unique token to recover the users password
it is then added to the database which handles the insertion date and expiration date

*/
function mailToken(){

}
function generateUniqueToken($conn) {

    require_once '../vendor/autoload.php'; // Include the Faker library
    $faker = Faker\Factory::create();
    $token = $faker->sha256(); // Generate a random SHA-256 hash (64 characters)
    $tokenLength = $faker->numberBetween($min = 30, $max = 40);

    // Trim to desired length
    $token = substr($token, 0, $tokenLength);



    // Query to check if the token already exists in the database
    $stmt = $conn->prepare("SELECT COUNT(*) FROM passwordRecovery WHERE token = ? and isActive = 1;");
    $stmt->bind_param("s", $token);

    // Loop until a unique token is found
    while (true) {
        $stmt->execute();
        $stmt->bind_result($count);
        $stmt->fetch();

        if ($count == 0) {
            // Unique token found
            break;
        } else {
            // Generate a new token if a collision occurred
            $token = substr($faker->sha256(), 0, $tokenLength);
        }
    }

    $stmt->close();

    return $token;
}

header('Content-Type: application/json'); // Set the content type to JSON

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Retrieve the username from the POST request
  $email = isset($_POST['email']) ? $_POST['email'] : null;
  $uid = isset($_POST['id']) ? $_POST['id'] : null;

  // execute mysqli to get the email of the user's account
  if ($email != null && $uid != null) {

    //include database connection
    include_once '../Configs/Conn.php';

    $token=generateUniqueToken($conn);

    $sql="
    INSERT INTO passwordRecovery(uid, token)
    VALUES (?, ?);";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("is", $uid, $token);

    if($stmt->execute()){

      $stmt->close();

      //create a link to the recovery directory with the token and the userID passed as arguements
      $recoveryLink= __ROOT__."/passwordrecovery/recover.php?token=".$token."&p=".$uid;

      mailToken($email, $token);

      if($published=true){
        $response = array('status' => 'success', 'link' => $recoveryLink);
      } else {
        $response = array('status' => 'success', 'link' => 'sent');
      }
    } else {
      $response = array('status' => 'error', 'message' => 'mysqli error');
    }

    $conn->close();

    echo json_encode($response); // Send the response back as JSON
  } else {
      echo json_encode(array('status' => 'error', 'message' => 'Empty post'));
  }
} else {
  // Handle invalid request method
  echo json_encode(array('status' => 'error', 'message' => 'Invalid request method'));
}


?>
