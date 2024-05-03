<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../Styles/logBookMainStyleSheet.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>

    <title>Βιβλίο Ύλης Δ.Θ.Σ.Α.Ε.Κ. Αιγάλεω</title>
</head>
<body>

<?php
  include_once '../Configs/Conn.php';

  /*
  Create a form with a username field
  After the user presses submit, the user's email will be fetched from the DB
  the user then will be asked to confirm wether that is the email that should
  be used for the recovery process.

  A random alphanumeric string  is created and stored in the database
  passwordRecovery table with the user's ID.
  A link is then created to logbook/passwordrecovery/recovery.php with the
  string passed as an arguement.

  The whole link is then mailed to the user's email and they are redirected
  to a page that has a form to change the user's password
  */
?>

<div id="formBox">
  <h1>Βιβλίο Ύλης</h1>
  <form name="Login" method="post" action="getUserEmail.php">

    <label for="username"> • Όνομα Χρήστη • </label>
    <input type="text" name="username" size="20" maxlength="20" />  <br>



    <button type="submit" > Επόμενο Βήμα </button>
  </form>


</body>
</html>
