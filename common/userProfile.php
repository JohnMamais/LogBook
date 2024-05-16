<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Δ.Θ.Σ.Α.Ε.Κ. Αιγάλεω: Διαχείρηση</title>

    <link rel="stylesheet" href="../Styles/logBookMainStyleSheet.css">

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

</head>
<body>

<?php
  include_once '../Configs/Conn.php';
  include_once '../Configs/Config.php';

  $username = $email = $signupDate = $fullname ="";

  $uid = $_SESSION['user_id'];

  //Get username, fullname, email and sign up date for user
  $sql="
  SELECT *
  FROM fullUserView
  WHERE id=?;
  ";

  $stmt = $conn->prepare($sql);
  //binding parameters
  $stmt->bind_param("i",$uid);
  if($stmt->execute()){
    $stmt = $stmt->get_result();
    $user = $stmt->fetch_assoc();
    if($user){
      $username = $user['username'];
      $email = $user['email'];
      $signupDate = $user['signupDate'];
      $fullname = $user['fullName'];
    }
  }
?>

<input type="text" name="uid" id="jsUid" value="<?php echo $_SESSION['user_id'];?>" class="hidden" readonly>

<table border="1">
  <tr>
    <td>Όνομα χρήστη</td>
    <td id="username"><?php if(!empty($username)){echo $username;} ?></td>
  </tr>
  <tr>
    <td>Ονοματεπώνυμο</td>
    <td id="fullname"><?php if(!empty($fullname)){echo $fullname;} ?></td>
  </tr>
  <tr>
    <td>Κωδικός</td>
    <td>Αλλαγή κωδικού <br>
      <form name="passwordForm" action="#" method="post">
        <input type="number" name="uid" id="uid" value="<?php if(isset($uid)){echo $uid;} ?>" class="hidden" readonly>
        Νέος κωδικός:
        <input type="password" name="password" id="password"><br>
        Επιβεβαίωση κωδικού:
        <input type="password" name="passwordVerify" id="passwordVerify" oninput="onSecondPassword()"><br>

        <button type="submit" name="btnPassword" id="btnPassword">Αλλαγή</button>

        <span id="passwordMessage"></span>
      </form>
    </td>
  </tr>
  <tr>
    <td rowspan="2">Email</td>

    <td id="email"><?php if(!empty($email)){echo $email;} ?></td>
  </tr>
  <tr>
    <td>
      Αλλαγή email <br>
      <form name="emailForm" action="#" method="post">
        <input type="number" name="uid" value="<?php if(isset($uid)){echo $uid;} ?>" class="hidden" readonly>
        Νέο email:
        <input type="text" name="email" id="email"><br>
        Επιβεβαίωση email:
        <input type="text" name="emailVerify" id="emailVerify" oninput="onSecondEmail()"><br>

        <button type="submit" name="btnEmail">Αλλαγή</button>
        <span id="emailMessage"></span>
      </form>
    </td>

  </tr>
  <tr>
    <td>Ημερομηνία Εγγραφής</td>
    <td id="registrationDate"><?php if(!empty($signupDate)){echo $signupDate;} ?></td>
  </tr>
</table>

</body>
</html>
