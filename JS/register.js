$(document).ready(function() {
    $('#signup-btn').click(function(event) {
      event.preventDefault(); // Prevent the default form submission
  
      var username = $('#username').val();
      var password = $('#password').val();
      var email = $('#email').val();
  
      // Check if any of the input fields are empty
      if (username.trim() === '' || password.trim() === '' || email.trim() === '') {
        alert('Please enter all details');
        return; // Exit the function
      }
  
      // Make sure to handle AJAX errors
      $.ajax({
        url: 'php/register.php',
        type: 'POST',
        data: {username: username, password: password, email: email},
        success: function(response) {
          if (response.includes('Signup successful')) {
            alert('Signup successful');
            window.location.href = 'login.html';
          } else {
            alert('Signup failed');
          }
        },
        error: function(xhr, status, error) {
          // Handle AJAX errors
          console.log(error);
          alert('AJAX request failed: ' + error);
        }
      });
    });
  });