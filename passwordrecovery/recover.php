<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../Styles/usernavbar.css">
    <link rel="stylesheet" href="../Styles/TeacherStyleSheet.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>

    <title>Βιβλίο Ύλης Δ.Θ.Σ.Α.Ε.Κ. Αιγάλεω</title>
</head>
<body>

<?php
  include_once '../Configs/Conn.php';

  /*
  A page containing a simple form to change the user's password
  containing 2 password fields to verify

  checks if the link contains the reference and GETs it
  fetches user id and isActive for provided token

  if the token is valid and the passwords match
  --update the user's passwords
  --invalidate the token
  --show success message and redirect to the login page

  */

 if(isset($_GET['token']) && isset($_GET['p'])){
   $uid=$_GET['p'];
   $token=$_GET['token'];

   $sql="
   SELECT COUNT(isActive) as isActive
   FROM passwordrecovery
   WHERE isActive=1 AND token=? AND uid=?;
   ";

   $stmt = $conn->prepare($sql);
   $stmt->bind_param("si", $token, $uid);

   if($stmt->execute()){
     $stmt->bind_result($isActive);
     $stmt->fetch();
     if($isActive){
       echo "the provided token is active";
     } else {
       echo "the provided token is not active";
     }
   }
   $stmt->close();
 }

?>

</body>
</html>
