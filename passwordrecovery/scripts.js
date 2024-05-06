//test password strength
function checkPasswordStrength(password) {
    var score = 0; // Initialize a score variable

    // Score for length
    if (password.length >= 8) {
        score += 1; // Add a point if the password is at least 8 characters
    }

    // Score for including uppercase letters
    if (/[A-Z]/.test(password)) {
        score += 1; // Add a point if there's at least one uppercase letter
    }

    // Score for including lowercase letters
    if (/[a-z]/.test(password)) {
        score += 1; // Add a point if there's at least one lowercase letter
    }

    // Score for including numbers
    if (/\d/.test(password)) {
        score += 1; // Add a point if there's at least one number
    }

    // Score for including special characters
    if (/[\W_]/.test(password)) {
        score += 1; // Add a point if there's at least one special character (non-alphanumeric)
    }

    // Return password strength based on the score
    if (score >= 5) {
        return "Strong"; // A strong password has at least one of each character type and a good length
    } else if (score >= 3) {
        return "Moderate"; // A moderate password has a mix of different character types but may be lacking in some
    } else {
        return "Weak"; // A weak password is short or lacks diversity in character types
    }
}

 // Event handler to update the border glow color
 function onSecondPassword() {

    let password1 = document.getElementById("password1");
    let password2 = document.getElementById("password2");

    // Remove existing classes
    password2.classList.remove("matching", "notMatching");

    // Add the class corresponding to the strength
    if(password1.value === password2.value){
       password2.classList.add("matching");
    } else {
      password2.classList.add("notMatching");
    }
 }

 //js to hide a span
 function hideSpan(spanID) {
    // Get the hidden span element by ID
    let mySpan = document.getElementById(spanID);
    mySpan.style.display = "none";  // Hide the span
 }

 //js to show a span
 function showSpan(spanID) {
    // Get the hidden span element by ID
    let mySpan = document.getElementById(spanID);
    mySpan.style.display = "inline"; // Show the span
 }

// Event handler to check the password strength
function onPasswordInput() {
    let passwordInput = document.getElementById("password1");
    let passwordStrength = checkPasswordStrength(passwordInput.value);

    let strengthIndicator = document.getElementById("strength-indicator");
    strengthIndicator.innerText = "Password strength: " + passwordStrength;
}

//ajax to change password
document.addEventListener('DOMContentLoaded', function() {
  // Select the form
  const form = document.forms['passwordForm'];
  const btnNext = document.getElementById('btnSubmit');

  let pass1 = document.getElementById("password1");
  let pass2 = document.getElementById("password2");

    form.addEventListener('submit', function(event) {

    if (pass1.value != pass2.value || pass1.value.length == 0 || pass2.value.length == 0) {
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

              //hide first form and show second one
              hideSpan("passwordForm");
              showSpan("success");
            } else if (response.status === 'error' ) {
              hideSpan("passwordForm");
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
    }
  });
});
