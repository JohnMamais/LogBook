<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>Δ.Θ.Σ.Α.Ε.Κ. Αιγάλεω: Διαχείρηση</title>

  <link rel="stylesheet" href="../Styles/logBookMainStyleSheet.css">
  <link rel="stylesheet" href="../Styles/loginStyleSheet.css">

</head>
<body>
  <?php

  // Function to sanitize and validate input data
  function test_input($data) {
      $data = trim($data);
      $data = stripslashes($data);
      $data = htmlspecialchars($data);
      return $data;
  }

  function alert($message){
    echo "<script>alert('$message');</script>";
  }

  include_once '../Configs/Conn.php';
  include_once '../Configs/Config.php';

  //handling of intruders
  //performing log out routine, redirect to login and logging to the DB
  if(!isset($_SESSION['user']) && $_SESSION['isAdmin']){

      $log="Unauthorized user attempted to acces user creator.";
      if(isset($_SESSION['user'])){
        $uname=$_SESSION['user'];
        $log.="Username: $uname";
      }
      $sql="INSERT INTO serverLog(logDesc) VALUES(?);";
      $stmt = $conn->prepare($sql);
      //binding parameters
      $stmt->bind_param("s",$log);
      if($stmt->execute()){
        //meow
        //log inserted
      }
      //closing statment
      $stmt->close();
      $conn->close();
      header("Location: ../logout.php");
      exit();
  }

  // Initialize error variables
  $fNameError = '';
  $lNameError = '';
  $uNameError = '';
  $passError = '';
  $pass2Error = '';
  $usernameError = '';

  // Initialize POST variables with empty strings
  $fname = "";
  $lname = "";
  $username = "";
  $password = "";
  $passwordCheck = "";

  //initialize DB log
  $log="";


  if ($_SERVER["REQUEST_METHOD"] == "POST"){
    //get values
    $fname=test_input($_POST['fname']);
    $lname=test_input($_POST['lname']);
    $username=test_input($_POST['username']);
    $password=test_input($_POST['password']);
    $passwordCheck=test_input($_POST["pass_confirm"]);//used for double checking
    $admin=$_POST['isAdmin'];

    //pre-SQL checks
    // Initialize a flag to track whether to proceed or not
    $proceed = 1;

    //logging error Messages
    $log=$log."Err.: ";

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

    // Check if the two passwords match
    if ($password !== $passwordCheck) {
        $passError = 'Οι κωδικοί δεν ταιριάζουν';
        $pass2Error = 'Οι κωδικοί δεν ταιριάζουν';
        $proceed = 0;
        $log=$log. "passAuth|";
    }



    //preparing query to check for duplicate username
    $sql = "SELECT username FROM user WHERE username= ?";
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



    //proceed to SQL
    if($proceed){
      //initialize rtrn used as flag to check the procedure
      //-1 means it didn't run, 0 is failure, 1 is success
      $rtrn=-1;

      //algo and options are defined in Config.php
      $hash=password_hash($password, $algo, $options);

      //new user stored procedure
      //query preperation
      $sql = "INSERT INTO user(username, password, fname, lname, isAdmin) VALUES (?,?,?,?,?)";
      $stmt = $conn->prepare($sql);
      //passing arguements (s=string, i=integer)
      $stmt->bind_param("ssssi", $username, $hash, $fname, $lname, $admin);

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
    //preparing query to insert log data into DB
    $sql="INSERT INTO serverLog(logDesc) VALUES(?);";
    $stmt = $conn->prepare($sql);
    //binding parameters
    $stmt->bind_param("s",$log);
    if($stmt->execute()){
      //meow
      //log inserted
    }
    //closing statment
    $stmt->close();
  }

  //closing connection
  $conn->close();

  ?>
  <h1>Εισαγωγη Νέου Χρήστη</h1>
  <form name="newUser" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">

    Όνομα <?php echo "$fNameError";?> <br>
    <input type="text" name="fname" size="20" maxlength="40" />
    <br>

    Επώνυμο <?php echo "$lNameError";?> <br>
    <input type="text" name="lname" size="20" maxlength="20" /> <br>

    Username <?php echo "$uNameError";?> <br>
    <input type="text" name="username" size="20" maxlength="20" /> <br>

    Κωδικός <?php echo "$passError";?> <br>
    <input type="password" name="password" size="20" maxlength="20" /> <br>
    Επαλήθευση Κωδικού <?php echo "$pass2Error";?> <br>
    <input type="password" name="pass_confirm" size="20" maxlength="20" /> <br>

    <br>
    Admin <br>
    <input type="radio" name="isAdmin" value="0" checked="checked" /> Διδάσκων/ουσα
    <input type="radio" name="isAdmin" value="1" /> Διαχειριστής
    <br><br>

    <button type="submit">Καταχώρηση Χρήστη</button>
    &emsp;
    <button type="reset">Επαναφορά Φόρμας</button>
    <?php echo "$usernameError";?>
  </form>
</body>
</html>
