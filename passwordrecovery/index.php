<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../Styles/logBookMainStyleSheet.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>

    <title>Βιβλίο Ύλης Δ.Θ.Σ.Α.Ε.Κ. Αιγάλεω</title>

    <style>
       /* Initially, hide the span */
       .hidden {
           display: none;
       }
   </style>
</head>
<body>

<?php
  include_once '../Configs/Conn.php';

  //handling of unauthorized users
  $_PERMISSIONS = array('teacher' => 0, 'admin' => 0, 'guest' => 1, 'super' => 1);
  include_once '../common/checkAuthorization.php';
  
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

<h1>Ανάκτηση Λογαριασμού</h1>
<span id="nameForm">
  <form name="nameForm" method="post" action="#">

    <label for="username"> Εισάγετε το όνομα χήρστη σας: </label>
    <input type="text" name="username" id="txtUser" size="20" maxlength="20" />*  <br>
    <br><br>
    *Αν έχετε ξεχάσει τον κωδικό ενός διαχειριστή τότε επικοινωνήστε με τον διαχειριστή του συστήματός σας


    <button type="submit" id="btnNext"> Επόμενο Βήμα </button>
  </form>
</span>

<span id="finalForm" class="hidden">
  <form name="finalForm" method="post" action="#">

    Πατώντας το κουμπί "Υποβολή" θα σας σταλεί ένα e-mail
    για να αποκτήσετε ξανά πρόσβαση στον λογαριασμό σας.
    Εάν το e-mail που αντιστοιχεί στον λογαριασμό
    <span id="spanUsername"></span>
    είναι το
    <span id="spanEmail"></span>
    τότε πατήστε υποβολή.

    <input type="number" name="id" id="txtId" class="hidden" readonly>
    <input type="text" name="email" id="txtEmail" class="hidden" readonly>

    <button type="submit" id="btnSubmit">Υποβολή</button>
    <button type="button" id="btnBack">Επιστροφή</button>
  </form>
</span>

<span id="success" class="hidden">

Το email στάλθηκε επιτυχως. Ακολουθείστε τις οδηγίες που συμπεριλαμβάνονται σε αυτό.
Ο σύνδεσμος που θα λάβετε θα είναι ενεργός για μία ώρα.

</span>

<span id="error" class="hidden">

Υπήρξε κάποιο πρόβλημα με την διαδικασία, πρακαλώ δοκιμάστε ξανα αργότερα.
Αν το πρόβλημα εξακολουθεί να υπάρχει, επικοινωνήστε με κάποιον διαχειριστή συστήματός.

</span>

</body>
</html>

<script>

//js to hide a span
function hideSpan(spanID) {
    // Get the hidden span element by ID
    var mySpan = document.getElementById(spanID);
    mySpan.style.display = "none";  // Hide the span
}

//js to show a span
function showSpan(spanID) {
    // Get the hidden span element by ID
    var mySpan = document.getElementById(spanID);
    mySpan.style.display = "inline"; // Show the span
}

// If the length of the element's string is 0 return false
function required(inputtx) {
  if (inputtx.length == 0){
     return false;
  }
  return true;
}

//ajax to get user email and id and change form
document.addEventListener('DOMContentLoaded', function() {
  // Select the form
  const form = document.forms['nameForm'];
  const btnNext = document.getElementById('btnNext');

  form.addEventListener('submit', function(event) {
     // Prevent the default form submission behavior
     event.preventDefault();

     let username = document.getElementById("txtUser").value;
     if (required(username) == false){
       console.log("empty username");
       return 0;
     }

     // Create a new XMLHttpRequest object
     const xhr = new XMLHttpRequest();

     // Get form data
     const formData = new FormData(form);

     // Set up the request
     xhr.open('POST', 'getUserEmail.php', true);

     // Optional: Handle the response
     xhr.onreadystatechange = function() {
         if (xhr.readyState === 4) { // 4: request finished and response is ready
             if (xhr.status === 200) { // 200: "OK"
                 console.log('Server response:', xhr.responseText);
                 // You can handle the response here, e.g., display a message or redirect

                 // Parse the JSON response
                    const response = JSON.parse(xhr.responseText);

                    if (response.status === 'success') {

                        //fill in username from the form and email from the response
                        document.getElementById("spanUsername").innerText = username;
                        document.getElementById("spanEmail").innerText = response.email;

                        //fill in second form's hidden values
                        document.getElementById("txtId").value = response.id;
                        document.getElementById("txtEmail").value = response.email;

                        //hide first form and show second one
                        hideSpan("nameForm");
                        showSpan("finalForm");
                    } else if (response.status === 'error' ) {
                        showSpan("error");
                        // Handle error: Display the error message
                        console.error('Error:', response.message);
                    }
             } else {
                 console.error('Error:', xhr.statusText);
             }
         } else {
             console.error('Error:', xhr.statusText);
         }
     };

     // Send the form data
     xhr.send(formData);
  });
});

//ajax to run the sendTokenMail.php fie
document.addEventListener('DOMContentLoaded', function() {
  // Select the form
  const form = document.forms['finalForm'];
  const btnNext = document.getElementById('btnSubmit');

  form.addEventListener('submit', function(event) {
     // Prevent the default form submission behavior
     event.preventDefault();

     // Create a new XMLHttpRequest object
     const xhr = new XMLHttpRequest();

     // Get form data
     const formData = new FormData(form);

     // Set up the request
     xhr.open('POST', 'sendTokenMail.php', true);

     // Optional: Handle the response
     xhr.onreadystatechange = function() {
         if (xhr.readyState === 4) { // 4: request finished and response is ready
             if (xhr.status === 200) { // 200: "OK"
                 console.log('Server response:', xhr.responseText);
                 // You can handle the response here, e.g., display a message or redirect

                 // Parse the JSON response
                    const response = JSON.parse(xhr.responseText);

                    if (response.status === 'success') {

                        console.log('link:', response.link);

                        //hide final form and show success span
                        hideSpan("finalForm");
                        showSpan("success");
                    } else if (response.status === 'error' ) {
                        // Handle error: Display the error message
                        console.error('Error:', response.message);
                        //hide final form and show error span
                        hideSpan("finalForm");
                        showSpan("error");
                    }
             } else {
                 console.error('Error:', xhr.statusText);
             }
         } else {
             console.error('Error:', xhr.statusText);
         }
     };

     // Send the form data
     xhr.send(formData);
  });
});

//form back button
document.addEventListener('DOMContentLoaded', function() {
            // Get the button element by its ID
            const myButton = document.getElementById('btnBack');

            // Add a click event listener to the button
            myButton.addEventListener('click', function() {
                hideSpan("finalForm");
                showSpan("nameForm");
            });
        });
</script>
