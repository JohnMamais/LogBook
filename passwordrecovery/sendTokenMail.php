<?php

//handling of unauthorized users
$_PERMISSIONS = array('teacher' => 0, 'admin' => 0, 'guest' => 1, 'super' => 1);
include_once '../common/checkAuthorization.php';

//PHP mailer library
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once '../vendor/autoload.php'; // Include composer

/*
This php script generates a unique token to recover the users password
it is then added to the database which handles the insertion date and expiration date

*/
function mailToken($email, $link, $published){
/*
  if(!$published){
    return array('status' => 'success', 'link' => $link);
  }
*/
  try {
      // Create a new PHPMailer instance
      $mail = new PHPMailer(true);
      // SMTP configuration
      $mail->isSMTP(); // Use SMTP
      $mail->Host = 'live.smtp.mailtrap.io'; // Your SMTP server (e.g., smtp.gmail.com)
      $mail->SMTPAuth = true; // Enable SMTP authentication
      $mail->Port = 587; // SMTP port (TLS usually uses 587)
      $mail->Username = 'api'; // Your SMTP username
      $mail->Password = 'c9db225a5ad649e88231a9d085f4c0b4'; // Your SMTP password
      //$mail->SMTPSecure = 'tls'; // Enable TLS encryption

      // Set the character set to UTF-8
      $mail->CharSet = 'UTF-8';

      // Set sender and recipient
      $mail->setFrom('mailme@demomailtrap.com', 'From Name');
      $mail->addAddress($email); // Recipient's email and name

      // Email content
      $headers['Content-type'] = 'text/html; charset=iso-8859-1';
      $mail->isHTML(false); // Set email format to HTML
      $mail->Subject = 'Ανάκτηση Λογαριασμού - Δ.Θ.Σ.Α.Ε.Κ. Αιγάλεω'; // Email subject
      $mail->Body = "
      <body>

        <h1>Αίτημα Επαναφοράς Κωδικού</h1>

        <p>Γεια σας,</p>
        <p>Λάβαμε ένα αίτημα για επαναφορά του κωδικού για τον λογαριασμό σας. Για να συνεχίσετε με την επαναφορά του κωδικού σας, παρακαλούμε κάντε κλικ στον παρακάτω σύνδεσμο:</p>
        <p><a href=".'"'.$link.'"'.">Επαναφορά Κωδικού</a></p>
        <p>Εάν δεν ζητήσατε εσείς την επαναφορά του κωδικού, παρακαλούμε αγνοήστε αυτό το email ή επικοινωνήστε με την υποστήριξη αν έχετε οποιεσδήποτε απορίες.</p>
        <p>Για λόγους ασφαλείας, ο παραπάνω σύνδεσμος θα λήξει σε 1 ώρα.</p>

      </body>
      "; // HTML body */
      $mail->AltBody = "
      Λάβαμε ένα αίτημα για επαναφορά του κωδικού για τον λογαριασμό σας. Για να συνεχίσετε με την επαναφορά του κωδικού σας, παρακαλούμε κάντε κλικ στον παρακάτω σύνδεσμο:\n
      $link \n
      Εάν δεν ζητήσατε εσείς την επαναφορά του κωδικού, παρακαλούμε αγνοήστε αυτό το email ή επικοινωνήστε με την υποστήριξη αν έχετε οποιεσδήποτε απορίες.\n
      Για λόγους ασφαλείας, ο παραπάνω σύνδεσμος θα λήξει σε 1 ώρα. \n
      "; // Plain text body (for non-HTML clients)

      // Send the email
      $mail->send();// Attempt to send the email

      return array('status' => 'success', 'message' => 'Email sent');

  } catch (Exception $e) {
      return array('status' => 'error', 'message' => 'Email could not be sent. PHPMailer Error: ' . $mail->ErrorInfo);
  }

}
function generateUniqueToken($conn) {

    require_once '../vendor/autoload.php'; // Include the Faker library
    $faker = Faker\Factory::create();
    $token = $faker->sha256(); // Generate a random SHA-256 hash (64 characters)
    $tokenLength = $faker->numberBetween($min = 30, $max = 40);

    // Trim to desired length
    $token = substr($token, 0, $tokenLength);



    // Query to check if the token already exists in the database
    $stmt = $conn->prepare("SELECT COUNT(*) FROM passwordrecovery WHERE token = ? and isActive = 1;");
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
    INSERT INTO passwordrecovery(uid, token)
    VALUES (?, ?);";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("is", $uid, $token);

    if($stmt->execute()){

      $stmt->close();

      //create a link to the recovery directory with the token and the userID passed as arguements
      $recoveryLink= __ROOT__."/passwordrecovery/recover.php?token=".$token."&p=".$uid;

      $response = mailToken($email, $recoveryLink, $published);

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
