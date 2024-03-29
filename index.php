<html>
<head>
  <META http-equiv="content-type" content="text/html; charset=utf-8">
  <title> Log In </title>

  <link rel="stylesheet" href="Styles/mainStyleSheet.css">
  <link rel="stylesheet" href="Styles/loginStyleSheet.css">

</head>
<body>

<?php
  //function to verify POST data
  function test_input($data) {
      $data = trim($data);
      $data = stripslashes($data);
      $data = htmlspecialchars($data);
      return $data;
  }

  //session configurations
  ini_set('session.cookie_secure', true);

  //start session
  session_start();

  //initializing vars
  $usernameError=$passwordError=$loginError=$username=$password=$log="";

  //checking for form submited with post method
  if ($_SERVER["REQUEST_METHOD"] == "POST"){

    require_once "ConnectionConfigs/loginConfig.php";

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
    // Querying the server for the username and fetching id and password
    $sql = "SELECT id, username, password, isAdmin FROM user WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    // Verify password
    if ($user && password_verify($password, $user["password"])) {

      // Set session variables
      //static $SESSION;
      $_SESSION['user_id'] = $user["id"];
      $_SESSION['user'] = $user["username"];
      $_SESSION['isAdmin']=$user["isAdmin"];

      // Redirect to a secured page
      if($user["isAdmin"]){
        header("Location: admin/index.php");
        exit();
      } else if (!$user["isAdmin"]){
        header("Location: user/index.php");
        exit();
      }
      $log=$log." Successful Login| User: ".$username;
    } else {
        // Invalid credentials
        $loginError = "Invalid username or password";
        $log=$log." Login Failed| Username attempted: ".$username;
    }

    // Close statement
    $stmt->close();

    //log interaction
    $sql="INSERT INTO serverLog(logDesc) VALUES(?);";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $log,);
    $stmt->execute();
    $stmt->close();

    //close conn
    $conn->close();

  }

?>
<h1>Log In</h1>
  <form name="Login" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">

    username:
    <input type="text" name="username" size="20" maxlength="20" /> <p id="usernameErr"> </p> <?php if(isset($usernameError)){echo "$usernameError";} ?> <br>
    <br>
    password:
    <input type="password" name="password" size="20" maxlength="20" /> <?php if(isset($passwordError)){echo "$passwordError";} ?> <br>
    <br>
    <button type="submit"> Log in </button> <?php if(isset($loginError)){echo "$loginError";} ?>

  </form>

</body>
</html>
