<html>
<head>
<META http-equiv="content-type" content="text/html; charset=utf-8">
<title> Εισαγωγή Νέου Χρήστη </title>

<link rel="stylesheet" href="../Styles/logBookMainStyleSheet.css">

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

  require_once("adminConfig.php");

  // Initialize error variables
  $fNameError = '';
  $lNameError = '';
  $uNameError = '';
  $passError = '';
  $pass2Error = '';

  // Initialize POST variables with empty strings
  $fname = "";
  $lname = "";
  $user = "";
  $password = "";
  $passwordCheck = "";

  //add -> && isset($_SESSION["user_id"] && $_SESSION["isAdmin"])
  if ($_SERVER["REQUEST_METHOD"] == "POST"){
    //get values
    $fname=test_input($_POST['fname']);
    $lname=test_input($_POST['lname']);
    $user=test_input($_POST['username']);
    $password=test_input($_POST['password']);
    $passwordCheck=test_input($_POST["pass_confirm"]);//used for double checking
    $admin=$_POST['isAdmin'];

    //pre-SQL checks
    // Initialize a flag to track whether to proceed or not
    $proceed = 1;

    // Check if any variable from the form is empty
    if (!isset($fname) || empty($fname)) {
        $fNameError = "Απαραίτητο πεδίο";
        $proceed = 0;
    }

    if (!isset($lname) || empty($lname)) {
        $lNameError = 'Απαραίτητο πεδίο';
        $proceed = 0;
    }

    if (!isset($user) || empty($user)) {
        $uNameError = 'Απαραίτητο πεδίο';
        $proceed = 0;
    }

    if (!isset($password) || empty($password)) {
        $passError = 'Απαραίτητο πεδίο';
        $proceed = 0;
    }

    if (!isset($passwordCheck) || empty($passwordCheck)) {
        $pass2Error = 'Απαραίτητο πεδίο';
        $proceed = 0;
    }

    // Check if the two passwords match
    if ($password !== $passwordCheck) {
        $passError = 'Οι κωδικοί δεν ταιριάζουν';
        $pass2Error = 'Οι κωδικοί δεν ταιριάζουν';
        $proceed = 0;
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
        $usernameErr="Υπάρχει ήδη χρήστης με αυτό το username";
      }
    }

    //proceed to SQL
    if($proceed){
      //initialize rtrn used as flag to check the procedure
      //-1 means it didn't run, 0 is failure, 1 is success
      $rtrn=-1;

      $algo= PASSWORD_ARGON2ID;
      $options = [
          'memory_cost' => 65536, // 64 MB
          'time_cost'   => 10,     // 4 iterations
          'threads'     => 2,     // 3 threads
      ];
      $hash=password_hash($password, $algo, $options);

      //query preperation
      $sql = "CALL newUser(?, ?, ?, ?, ?, ?)";
      $stmt = $conn->prepare($sql);
      //passing arguements (s=string, i=integer)
      $stmt->bind_param("ssssii", $fname, $lname, $user, $hash, $admin, $rtrn);

      //executing
      if ($stmt->execute()) {
          echo "Stored procedure newUser executed successfully.<br>";

          //getting results (msg:bool 1=success, 0=fail)
          $rtrn = $stmt->get_result();
          $rtrn = $rtrn->fetch_assoc();

          //printing results
          echo "Procedure returned $rtrn[msg]";

      } else {
        //error
          echo "Error executing stored procedure: " . $stmt->error;
      }

      //closing statment
      $stmt->close();

    } else {

    }
  }

  //closing connection
  $conn->close();

  ?>

  <fieldset> <legend>Εισαγωγη Νέου Χρήστη</legend>
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

    Admin <br>
    <input type="radio" name="isAdmin" value="0" checked="checked" /> Διδάσκων/ουσα
    <input type="radio" name="isAdmin" value="1" /> Διαχειριστής
    <br><br>

    <button type="submit">Καταχώρηση Χρήστη</button>
    &emsp;
    <button type="reset">Επαναφορά Φόρμας</button>
    <?php echo "$uNameError";?>
  </form>
</fieldset>
</body>
</html>
