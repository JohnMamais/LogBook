<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../Styles/logBookMainStyleSheet.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>

    <title>Βιβλίο Ύλης Δ.Θ.Σ.Α.Ε.Κ. Αιγάλεω</title>

    <script src="scripts.js"></script>

    <style>
       /* Initially, hide the span */
       .hidden {
           display: none;
       }

      /* Define styles for different border glow colors */
      .notMatching {
          border: 2px solid red;
          box-shadow: 0 0 10px red;
      }

      .matching {
          border: 2px solid green;
          box-shadow: 0 0 10px green;
      }
   </style>

<?php
  include_once '../Configs/Conn.php';

  //js interface to hide a span
  function hideSpan($spanID) {
      //call the js function
      echo '
      <script>
        hideSpan("'.$spanID.'");
      </script>
      ';
  }

  //js interface to show a span
  function showSpan($spanID) {
    //call the js function
    echo '
    <script>
      showSpan("'.$spanID.'");
    </script>
    ';
  }
?>

</head>
<body>
  <span id="error" class="hidden">
    Δυστυχώς δεν βρηκαμε κάποιο αίτημα επαναφοράς κωδικού με τα στοιχεία που δώσατε ή η διαδικασία απέτυχε.
  </span>

  <span id="success" class="hidden">
    Η αλλαγή του κωδικού σας ήταν επιτυχής. Μπορείτε να συνδεθείτε πατώντας<a href="<?php echo __ROOT__; ?>"> εδω</a>.
  </span>

  <div id="passwordForm" class="hidden">
    Εισάγετε τον κωδικό που επιθυμείτε να χρησιμοποιείτε στα παρακάτω πεδία<br>
    <form name="passwordForm" action="#" method="post">
      Κωδικός:<br>
      <input type="password" id="password1" name="password1" value="" oninput="onPasswordInput()"><br>
      Επαλήθευση Κωδικού:<br>
      <input type="password" id="password2" name="password2" value="" oninput="onSecondPassword()"><br>
      <span id="strength-indicator"></span>
      <br>
      <input type="number" name="uid" id="uid" class='hidden' readonly>
      <button type="submit" id="btnSubmit">Υποβολή</button>
    </form>
  </div>


<?php

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

   //set uid field with javascript
   echo "
   <script>
    document.getElementById('uid').value = $uid;
   </script>
   ";

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
       showSpan("passwordForm");
     } else {
       showSpan('error');
     }
   }
   $stmt->close();
 } else {
   showSpan('error');
 }

?>

</body>
</html>
