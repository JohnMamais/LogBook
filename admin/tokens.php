<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Δ.Θ.Σ.Α.Ε.Κ. Αιγάλεω: Διαχείρηση</title>

    <link rel="stylesheet" href="../Styles/adminStyleSheet.css">
    <link rel="stylesheet" href="../Styles/mainStyleSheet.css">

    <style>
       /* Initially, hide the span */
       #hidden {
           display: none;
       }
   </style>

</head>
<body>

<?php
  include_once '../Configs/Conn.php';
  include_once '../Configs/Config.php';

  require_once '../vendor/autoload.php'; // Include the Faker autoloader
  $faker = Faker\Factory::create(); //init faker

  // Function to sanitize and validate input data
  function test_input($data) {
      $data = trim($data);
      $data = stripslashes($data);
      $data = htmlspecialchars($data);
      return $data;
  }

  /*
  check authorization
  */

  /*

  main new token logic
  database uses DATE for dates
  */
  //initialize log string
  $log="";

  //initialize check flag
  $proceed=1;

  //initialize error variables
  $startErr="";
  $endErr="";
  $userErr="";

  //initialize POST variables
  $startDate="";
  $endDate="";
  $checkStartDate="";
  $maxUsers="";

  if ($_SERVER["REQUEST_METHOD"] == "POST"){

    //Get and sanitize POST data
    $startDate=test_input($_POST['startDate']);
    $endDate=test_input($_POST['endDate']);
    $checkStartDate=test_input($_POST['checkStartDate']);
    $maxUsers=test_input($_POST['teacherCount']);


    //Check for empty variables

    if ((!isset($startDate) || empty($startDate))  && !isset($checkStartDate)) {//output error only if the field is visible in the form
        $startErr = "Απαραίτητο πεδίο";
        $proceed = 0;
        //logging error Messages
        $log=$log. "strtDt|";
    } else if (isset($checkStartDate)) {
        $startDate=date("Y-m-d");
    }

    if (!isset($endDate) || empty($endDate)) {
        $endErr = "Απαραίτητο πεδίο";
        $proceed = 0;
        //logging error Messages
        $log=$log. "endDt|";
    }

    if (!isset($maxUsers) || empty($maxUsers)) {
        $userErr = "Απαραίτητο πεδίο";
        $proceed = 0;
        //logging error Messages
        $log=$log. "MaxUsr|";
    }

    //create random string for token
    $token= $faker->bothify('AIGAL-??#?##');

    if($proceed){
      //format SQL query for the

      $sql="INSERT INTO registrationTokens(startDate, endDate, token, maxUses) VALUES (?,?,?,?);";

      //preparing query to insert token into DB
      $stmt = $conn->prepare($sql);
      //binding parameters
      $stmt->bind_param("sssi",$startDate, $endDate, $token, $maxUsers);

      //execute INSERT
      if(!$stmt->execute()){
        $log.="RegToken Creation failed";
      }
      //success close statement
      $stmt->close();
    }

      //restart the event to automatically check if the tokens are active
      $sql="CALL startTokenEvent();";
      $stmt = $conn->prepare($sql);
      $stmt->execute();

      //Log interaction
      //preparing query to insert log data into DB
      $log="User ".$_SESSION['user']." created token: ".$token.".";
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

    }

?>

  <form name="newUser" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
      Ισχύει
      <span id="hidden">  <!-- This span is initially hidden -->
          από:
          <input type="date" name="startDate" size="20" maxlength="20" />
      </span>
      έως:
      <input type="date" name="endDate" size="20" maxlength="20" />.
      <br>
      Έναρξη σήμερα.
      <input type="checkbox" name="checkStartDate" onclick="toggleHiddenSpan(this)" checked="checked"/>
      <br><br>
      Ισχύει για
      <input type="number" name="teacherCount" size="5" />
      καθηγητές.
      <br><br>
      <button type="submit" id="refreshToken">Δημιουργία Token</button>
  </form>

  <table border="3">
    <tr>
      <td rowspan="2">Τρέχων Token:</td>
      <th>Token</th>
      <th>Expire Date</th>
    </tr>
    <tr>
      <td id="token"></td>
      <td id="expiration"></td>
    </tr>
  </table>

</body>
</html>

<script>
  //js to toggle a checkbox
  function toggleHiddenSpan(checkbox) {
      // Get the hidden span element by ID
      var hiddenSpan = document.getElementById("hidden");
      // Toggle its display property based on the checkbox state
      if (checkbox.checked) {
          hiddenSpan.style.display = "none";  // Hide the span
      } else {
          hiddenSpan.style.display = "inline"; // Show the span
      }
  }

  //function for ajax callback getting the current token
  function getActiveToken() {
  fetch('getLatestToken.php') // Path to your PHP script
      .then(response => response.json())
      .then(result => {
          // Use the data to update the page
          document.getElementById('token').innerText = result[0].token;
          document.getElementById('expiration').innerText = result[0].expire;
      })
      .catch(err => {
          console.error("Error occurred:", err);
      });
    }

  //ajax to get current token on page load
  document.addEventListener('DOMContentLoaded', getActiveToken);

  //ajax to get the latest token after new token insertion
  //document.getElementById('refreshToken').addEventListener('click', getActiveToken);

</script>
