<html>
<head>
  <META http-equiv="content-type" content="text/html; charset=utf-8">
  <title> Log In </title>

  <link rel="stylesheet" href="Styles/mainStyleSheet.css">
  <link rel="stylesheet" href="Styles/loginStyleSheet.css">

</head>
<body>

<?php
  error_reporting(E_ALL);
  ini_set('display_errors', 1);

  //function to verify POST data
  function test_input($data) {
      $data = trim($data);
      $data = stripslashes($data);
      $data = htmlspecialchars($data);
      return $data;
  }
  function putLog($conn, $log){
    //log interaction
    $sql="INSERT INTO serverlog(logDesc) VALUES(?);";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $log,);
    $stmt->execute();
    $stmt->close();
  }

  //session configurations
  ini_set('session.cookie_secure', true);

  //initializing vars
  $usernameError=$passwordError=$loginError=$username=$password=$log="";

  //checking for form submited with post method
  if ($_SERVER["REQUEST_METHOD"] == "POST"){

    include_once 'Configs/Conn.php';
    include_once 'Configs/Config.php';

    //checking for empty vars then putting the tested inputs in a variable
    if(empty($_POST["username"])){
      $usernameError="* Απαραίτητο Πεδίο";
      $log=$log." Empty username.";
    } else {
      $username = test_input($_POST["username"]);
    }
    if(empty($_POST["password"])){
      $passwordError="* Απαραίτητο Πεδίο";
      $log=$log." Empty password.";
    } else {
      $password = test_input($_POST["password"]);
    }


    // Check user credentials in the database
    // Querying the database for the username and fetching id and password
    $sql = "SELECT id, username, password, isAdmin FROM user WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    // Close statement
    $stmt->close();

    // Verify password
    if ($user && password_verify($password, $user["password"])) {

      // Set session variables
      //static $SESSION;
      $_SESSION['user_id'] = $user["id"];
      $_SESSION['user'] = $user["username"];
      $_SESSION['isAdmin']=$user["isAdmin"];

      $log= $log."Succ. Login user:".$user["username"]."admin: ".$user["isAdmin"];

      // Redirect to a secured page
      if($user["isAdmin"]){
        header("Location: admin/index.php");
        putlog($conn, $log);
        exit();
      } else if (!$user["isAdmin"]){
        header("Location: user/index.php");
        putlog($conn, $log);
        exit();
      }
      $log=$log." Successful Login| User: ".$username;
    } else {
        // Invalid credentials
        $loginError = "Invalid username or password";
        $log=$log." Login Failed| Username attempted: ".$username;
    }

    putlog($conn, $log);
    //close conn
    $conn->close();

  }

?>
<div class="flex-container">
  <div id="appInfo">
      <img src="SAEK_logo.png" alt="Θ.Σ.Α.Ε.Κ. Αιγάλεω" width="30%" id="logo">
    <p id="infoParagraph">Η παρούσα εφαρμογή αναπτύχθηκε για τη Θ.Σ.Α.Ε.Κ. Αιγάλεω κατά το ακαδημαϊκό έτος 2023-2024.
      Σκοπός είναι η αντικατάσταση του παραδοσιακού τρόπου συμπλήρωσης των βιβλίων ύλης με ένα σύγχρονο και εύχρηστο σύστημα που θα
      επιτρέπει μεγαλύτερη ευελιξία και αμεσότητα. Πέρα από το περιβάλλον των διδασκόντων, περιλαμβάνεται και περιβάλλον για διαχειριστές
      μέσα από το οποίο οι ίδιοι θα μπορούν να διαχειριστούν τα εξάμηνα της σχολής, τα μαθήματα, τους χρήστες αλλά και να λάβουν συγκεντρωτικά
      τις εγγραφές από τα βιβλία ύλης με μερικά κλικ.<br><br>•••<br><br>Η ανάπτυξη του συστήματος ανατέθηκε από τη διεύθυνση του Θ.Σ.Α.Ε.Κ. Αιγάλεω σε καταρτιζόμενους
      της σχολής εθελοντικά με σκοπό την βελτίωση των ικανοτήτων τους μέσω της παραγωγής πρωτότυπου υλικού.<br><br>
      Ανάπτυξη: Ιωάννης Μαμάης - Ηλίας Μοτσενίγος.
    </p>
  </div>
  <div id="formBox">
    <h1>Βιβλίο Ύλης</h1>
    <form name="Login" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
      <label for="username"> • Username • </label>
      <input type="text" name="username" size="20" maxlength="20" /> <?php if(isset($usernameError)){echo "$usernameError";} ?> <br>
      <br>
      <label for="password"> • Password • </label>
      <input type="password" name="password" size="20" maxlength="20" /> <?php if(isset($passwordError)){echo "$passwordError";} ?> <br>
      <br>
      <a href="admin/newUser.php?p=6">Εγγραφή</a>
      <br>
      <a href="passwordrecovery/index.php">Ξέχασα τον κωδικό μου</a>
      <br>
      <button type="submit"> Log In </button> <?php if(isset($loginError)){echo "$loginError";} ?>
    </form>
  </div>
</div>
</body>
</html>
