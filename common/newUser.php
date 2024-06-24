<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>Δ.Θ.Σ.Α.Ε.Κ. Αιγάλεω: Διαχείρηση</title>

  <link rel="stylesheet" href="../Styles/logBookMainStyleSheet.css">

</head>
<body>
  <?php

  $_PERMISSIONS = array('teacher' => 0, 'admin' => 1, 'guest' => 1, 'super' => 1);
  include_once 'checkAuthorization.php';

  // Function to sanitize and validate input data
  function test_input($data) {
      $data = trim($data);
      $data = stripslashes($data);
      $data = htmlspecialchars($data);
      return $data;
  }

  include_once '../Configs/Conn.php';
  include_once '../Configs/Config.php';
  require_once '../common/vars.php';
  require_once '../common/commonFunctions.php';

  //the page is accessed via the login menu with a p arguement
  //if it is set, some fields are hidden

  if (isset($_GET['p'])){
    $adminPriv = 1;
    //set admin to 0 by default if the user entered through the login menu
    $admin = 0;
  } else {
    $adminPriv = 0;
  }

  // Initialize error variables
  $fNameError = $lNameError = $uNameError = $passError = $pass2Error = $usernameError = $tokenError = $emailError ='';

  // Initialize POST variables with empty strings
  $fname = $lname = $username = $password = $passwordCheck = $token = $email = "";

  //initialize DB log
  $log="";

  if ($_SERVER["REQUEST_METHOD"] == "POST"){
    //get values
    $fname=test_input($_POST['fname']);
    $lname=test_input($_POST['lname']);
    $username=test_input($_POST['username']);
    $password=test_input($_POST['password']);
    $passwordCheck=test_input($_POST["pass_confirm"]);//used for double checking
    if(isset($_SESSION["isAdmin"]) && ($_SESSION["isAdmin"]==1 || $_SESSION["isAdmin"]==2)){
      $admin=$_POST['isAdmin'];
    }
    $email=test_input($_POST['email']);
    $token=test_input($_POST["token"]);

    // Initialize a flag to track whether to proceed or not
    $proceed = 1;

    // Check if any variable from the form is empty
    if (!isset($fname) || empty($fname)) {
        $fNameError = "Απαραίτητο πεδίο";
        $proceed = 0;
        //logging error Messages
        $log=$log. "fn|";
    }

    if (!isset($lname) || empty($lname)) {
        $lNameError = 'Απαραίτητο πεδίο';
        $proceed = 0;
        $log=$log. "ln|";
    }

    if (!isset($username) || empty($username)) {
        $uNameError = 'Απαραίτητο πεδίο';
        $proceed = 0;
        $log=$log. "un|";
    }

    if (!isset($password) || empty($password)) {
        $passError = 'Απαραίτητο πεδίο';
        $proceed = 0;
        $log=$log. "pass|";
    }

    if (!isset($passwordCheck) || empty($passwordCheck)) {
        $pass2Error = 'Απαραίτητο πεδίο';
        $proceed = 0;
        $log=$log. "pass2|";
    }

    if (!isset($token) || empty($token)) {
        $tokenError = "Απαραίτητο πεδίο";
        $proceed = 0;
        //logging error Messages
        $log=$log. "tkn|";
    }

    //check email
    if (!isset($email) || empty($email)) {
        $emailError = "Απαραίτητο πεδίο";
        $proceed = 0;
        //logging error Messages
        $log=$log. "email|";
    } else {
      //filter email
      if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
          $proceed=0;
          $log=$log. "mailFiltr|";
      }
      if (!preg_match("/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\\.[a-zA-Z]{2,}$/", $email)) {
        $proceed=0;
        $log=$log. "mailRegEx|";
      }
    }

    // Check if the two passwords match
    if ($password !== $passwordCheck) {
        $passError = 'Οι κωδικοί δεν ταιριάζουν';
        $pass2Error = 'Οι κωδικοί δεν ταιριάζουν';
        $proceed = 0;
        $log=$log. "passAuth|";
    }

    //preparing query to check for duplicate username
    if($proceed){
      $sql = "SELECT username as usr FROM user WHERE username= ?";
      $stmt = $conn->prepare($sql);
      //passing arguements
      $stmt->bind_param("s",$username);

      if ($stmt->execute()){

        //get results
        $rtrn = $stmt->get_result();
        $checkUser = $rtrn->fetch_assoc();

        //check
        if($checkUser){
          $proceed=0;
          $usernameError="Υπάρχει ήδη χρήστης με αυτό το username";
          $log=$log. "DuplUname|";
        }
      }
    }

    //check for valid token
    if($proceed){
      $sql = "SELECT id as tokenID, endDate as endDate, isActive as isActive FROM registrationtokens WHERE token= ?";
      $stmt = $conn->prepare($sql);
      //passing arguements
      $stmt->bind_param("s",$token);

      if ($stmt->execute()){

        //get results
        $rtrn = $stmt->get_result();
        $checkToken = $rtrn->fetch_assoc();

        //check if results were returned
        if((!$checkToken)){
          $proceed=0;
          $usernameError="Μη έγκυρο token";
          $log=$log. "invldTkn|";

        } else if((!$checkToken['isActive']==1) || ($checkToken['endDate']<date("Y-m-d"))){
          $proceed=0;
          $usernameError="Το token δεν ισχύει";
          $log=$log. "exprdTkn|";
        }
      }
    }

    //proceed to SQL
    if($proceed){

      //use token's id instead of actual token
      $token=$checkToken['tokenID'];

      //algo and options are defined in Config.php
      $hash=password_hash($password, $algo, $options);

      //new user stored procedure
      //query preperation
      $sql = "INSERT INTO user(username, password, tokenUsed, email, fname, lname, isAdmin) VALUES (?,?,?,?,?,?,?)";
      $stmt = $conn->prepare($sql);
      //passing arguements (s=string, i=integer)
      $stmt->bind_param("ssssssi", $username, $hash, $token, $email, $fname, $lname, $admin);

      //executing
      if ($stmt->execute()) {

        //logging new user success
        alert("Ο χρήστης $username καταχωρήθηκε επιτυχώς.");
        $log=$log. "| New User: $username | Admin Status: $admin | Cr. By: ".$_SESSION['user'];

      } else {
        //error executing sql statement
        //αν εμφανιστει αυτο σκαει η βαση πριν το stored procedure
        //logging new user failure
        alert("Δυστυχώς ο χρήστης δεν μπόρεσε να καταχωρηθεί στο σύστημα. Προσπαθήστε ξανά αλλιώς επικοινωήστε με τον υπεύθυνο του συστήματος.");
        $pass=isset($hash);
        $log=$log. "|info passed: fn:$fname,ln: $lname,un: $username,pass(isset): $pass,iA $admin";
        $log = $log. "Error executing sql statement: " . $stmt->error;
      }

      //closing statment
      $stmt->close();

    } else {
      $log="FAILED - ". $log;
    }

    //Logging to database
    insertLog($conn, $log);

    //closing connection
    $conn->close();

    //got to login page if the user is not an admin
    if($_SESSION['isAdmin']=='guest'){
        header('Location: ../');
        exit;
    }

  }

  ?>
  <h1>Εγγραφή</h1>
  <form name="newUser" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">

    Όνομα <?php echo "$fNameError";?> <br>
    <input type="text" name="fname" size="20" maxlength="40" />
    <br>

    Επώνυμο <?php echo "$lNameError";?> <br>
    <input type="text" name="lname" size="20" maxlength="20" /> <br>

    Username <?php echo "$uNameError";?> <br>
    <input type="text" name="username" size="20" maxlength="20" /> <br>

    E-mail <?php echo "$emailError";?> <br>
    <input type="text" name="email" size="20" maxlength="20" /> <br>

    Κωδικός <?php echo "$passError";?> <br>
    <input type="password" name="password" size="20" maxlength="20" /> <br>
    Επαλήθευση Κωδικού <?php echo "$pass2Error";?> <br>
    <input type="password" name="pass_confirm" size="20" maxlength="20" /> <br>

    Token <?php echo "$tokenError";?> <br>
    <input type="text" name="token" size="20" maxlength="20" /> <br>

    <?php if (isset($_SESSION["isAdmin"]) && ($_SESSION["isAdmin"]==1 || $_SESSION["isAdmin"]==2)): ?>
    <br>
    Admin <br>
    <input type="radio" name="isAdmin" value="0" checked="checked" /> Διδάσκων/ουσα
    <input type="radio" name="isAdmin" value="1" /> Διαχειριστής
    <br><br>
    <?php endif; ?>

    <button type="submit">Καταχώρηση Χρήστη</button>
    &emsp;
    <button type="reset">Επαναφορά Φόρμας</button>
    <?php echo "$usernameError";?>

    <?php if ($_SESSION['isAdmin']=='guest'){
      echo '<a href="../">πίσω</a>';
    }
    ?>
  </form>
</body>
</html>
