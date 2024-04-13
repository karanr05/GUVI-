$(document).ready(function() {
    // Check if the session is already validated
    validateSession();
  
    $('#login-btn').click(function() {
      var username = $('#username').val();
      var password = $('#password').val();
  
      if (username.trim() === '' || password.trim() === '') {
        alert('Please enter all details');
        return;
      }
      
      // Perform login AJAX request
      login(username, password);
    });
  });
  
  function validateSession() {
    // Perform AJAX request to validate session
    $.ajax({
      url: 'php/Session.php', // Update the URL to point to validateSession.php
      type: 'GET',
      success: function(response) {
        if (response === 'Session validated') {
          setTimeout(function() {
            window.location.href = 'profile.html';
          }, 100);
        } else if (response === 'Session invalid') {
          // Do nothing or show an appropriate message
          // console.log('session invalid');
        }
      },
      error: function(xhr, status, error) {
        // Handle AJAX errors
        console.log(error);
        alert('AJAX request failed: ' + error);
      }
    });
  }
  
  function login(username, password) {
    $.ajax({
      url: 'php/login.php', // Update the URL to point to login.php
      type: 'POST',
      data: { username: username, password: password },
      success: function(response) {
        response = JSON.parse(response);
        if (response.status === 'success') {
          // Store the session ID in a cookie
            // Set the session ID cookie
            var sessionId = response.sessionID;
            var cookieValue = sessionId + ':' + username;
            var cookieExpiry = new Date();
            cookieExpiry.setTime(cookieExpiry.getTime() + (3 * 60 * 1000)); // Set the expiry time to 3 minutes
  
            
            document.cookie = 'sessionID=' + cookieValue + '; expires=' + cookieExpiry.toUTCString() + '; path=/';
          /*
          document.cookie = 'sessionID=' + response.sessionID + '; path=/';
          */
          alert(response.message);
          
          // Delayed redirect to the profile page with cache control workaround
          setTimeout(function() {
            window.location.href = 'profile.html?' + new Date().getTime();
          }, 100);
        } else if (response.status === 'fail') {
          // alert(response);
          alert(response.message);
        }
      },
      error: function(xhr, status, error) {
        // Handle AJAX errors
        console.log(error);
        alert('AJAX request failed: ' + error);
      }
    });
  }