<html>
<head>
  <META http-equiv="content-type" content="text/html; charset=utf-8">
  <title> Superadmin </title>

  <link rel="stylesheet" href="Styles/mainStyleSheet.css">
  <link rel="stylesheet" href="Styles/loginStyleSheet.css">

</head>
<body>
<?php
  include_once '../Configs/Conn.php';
  include_once '../Configs/Config.php';

  //handling of intruders
  //performing log out routine, redirect to login and logging to the DB
  if(!isset($_SESSION['user']) || $_SESSION['isAdmin']!=2){

      $log="Unauthorized user attempted to acces admin index.";
      if(isset($_SESSION['user'])){
        $uname=$_SESSION['user'];
        $log.="Username: $uname";
      }
      $sql="INSERT INTO serverlog(logDesc) VALUES(?);";
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

?>

</body>
</html>
