//script for required fields
function required(field){
  if (field.value.length>0) {
    return 1;
  } else {
    return 0;
  }
}

 // Event handler to update the border glow color for password
 function onSecondPassword() {

    let password1 = document.getElementById("password");
    let password2 = document.getElementById("passwordVerify");

    // Remove existing classes
    password2.classList.remove("matching", "notMatching");

    // Add the class corresponding to the strength
    if(password1.value === password2.value){
       password2.classList.add("matching");
    } else {
      password2.classList.add("notMatching");
    }
 }

 // Event handler to update the border glow color
 function onSecondEmail() {

    let email = document.getElementById("email");
    let emailV = document.getElementById("emailVerify");

    // Remove existing classes
    emailV.classList.remove("matching", "notMatching");

    // Add the class corresponding to the strength
    if(email.value === emailV.value){
       emailV.classList.add("matching");
    } else {
      emailV.classList.add("notMatching");
    }
 }

//ajax to change password
document.addEventListener('DOMContentLoaded', function() {
  // Select the form
  const form = document.forms['passwordForm'];
  const btnNext = document.getElementById('btnPassword');

  let uid = document.getElementById('uid');
  let pass1 = document.getElementById("password");
  let pass2 = document.getElementById("passwordVerify");

    form.addEventListener('submit', function(event) {

    if (!required(uid) || pass1.value != pass2.value || !required(pass1) || !required(pass2)) {
      console.log("Error: Invalid passwords");
    } else {
      // Prevent the default form submission behavior
      event.preventDefault();

      // Create a new XMLHttpRequest object
      const xhr = new XMLHttpRequest();

      // Get form data
      const formData = new FormData(form);

      // Set up the request
      xhr.open('POST', 'changePassword.php', true);

      // Optional: Handle the response
      xhr.onreadystatechange = function() {
        if (xhr.readyState === 4) { // 4: request finished and response is ready
          if (xhr.status === 200) { // 200: "OK"
            console.log('Server response:', xhr.responseText);
            // You can handle the response here, e.g., display a message or redirect

            // Parse the JSON response
            const response = JSON.parse(xhr.responseText);

            if (response.status === 'success') {

              document.getElementById("passwordMessage").innerText="Επιτυχία!";

              //empty fields
              pass1.value="";
              pass2.value="";
              // Remove password verify field glow
              pass2.classList.remove("matching", "notMatching");

            } else if (response.status === 'error' ) {
              document.getElementById("passwordMessage").innerText="Παρουσιάστηκε πρόβλημα!";
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
    }
  });
});

//ajax to change email
document.addEventListener('DOMContentLoaded', function() {
  // Select the form
  const form = document.forms['emailForm'];
  const btnNext = document.getElementById('btnEmail');

  let userMail = document.getElementById("userEmail");

  let uid = document.getElementById('uid');
  let email = document.getElementById("email");
  let emailV = document.getElementById("emailVerify");

    form.addEventListener('submit', function(event) {

    if (!required(uid) || email.value != emailV.value || !required(email) || !required(emailV)) {
      console.log("Error: Invalid emails");
    } else {
      // Prevent the default form submission behavior
      event.preventDefault();

      // Create a new XMLHttpRequest object
      const xhr = new XMLHttpRequest();

      // Get form data
      const formData = new FormData(form);

      // Set up the request
      xhr.open('POST', 'changeEmail.php', true);

      // Optional: Handle the response
      xhr.onreadystatechange = function() {
        if (xhr.readyState === 4) { // 4: request finished and response is ready
          if (xhr.status === 200) { // 200: "OK"
            console.log('Server response:', xhr.responseText);
            // You can handle the response here, e.g., display a message or redirect

            // Parse the JSON response
            const response = JSON.parse(xhr.responseText);

            if (response.status === 'success') {

              document.getElementById("emailMessage").innerText="Επιτυχία!";

              //empty fields
              email.value="";
              emailV.value="";
              // Remove email verify field glow
              emailV.classList.remove("matching", "notMatching");

              userMail.innerText=email.value;

            } else if (response.status === 'error' ) {
              document.getElementById("emailMessage").innerText="Παρουσιάστηκε πρόβλημα!";
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
    }
  });
});
