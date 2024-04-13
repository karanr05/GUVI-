$(document).ready(function() {
    // Get the username from the cookie
    var sessionID = getCookie('sessionID');
    var username;
    
    if (sessionID) {
        // Check if sessionID is not null
        username = sessionID.split(':')[1];
        $('#profile-heading').text('Welcome ' + username);
    } else {
        // Handle the case where sessionID is null (e.g., redirect to login page)
        alert('Session expired. Please log in again.');
        window.location.href = 'login.html';
        return;
    }

    // Retrieve user data and display it
    $.ajax({
        url: 'php/profile.php',
        type: 'GET',
        data: { username: username },
        success: function(response) {
            var userData = JSON.parse(response);
            if (userData) {
                displayUserData(userData);
            } else {
                alert('User not found');
            }
        },
        error: function(xhr, status, error) {
            console.log(error);
            alert('AJAX request failed GET: ' + error);
        }
    });
  
    // Update user data
    $('#update-btn').click(function() {
        var phone = $('#phone').val();
        var dob = $('#dob').val();
        var age = calculateAge(dob);
        var address = $('#address').val();
  
        // Modify the data object to include the username
        var postData = {
            phone: phone,
            dob: dob,
            age: age,
            address: address,
            username: username
        };
  
        $.ajax({
            url: 'php/profile_update.php',
            type: 'POST',
            data: postData,
            success: function(response) {
                if (response == 'Update successful') {
                    alert('Updated successfully');
                    // Retrieve the updated user data and display it
                    $.ajax({
                        url: 'php/profile.php',
                        type: 'GET',
                        data: { username: username },
                        success: function(response) {
                            var userData = JSON.parse(response);
                            if (userData) {
                                displayUserData(userData);
                            }
                        },
                        error: function(xhr, status, error) {
                            console.log(error);
                        }
                    });
                } else {
                    alert(' updated successfully');
                }
            },
            error: function(xhr, status, error) {
                console.log(error);
                alert('POST AJAX request failed: ' + error);
            }
        });
    });
  
    $('#logout-link').click(function(e) {
      e.preventDefault();
      logoutUser();
    });
  });
  
  function displayUserData(userData) {
    $('#phone').val(userData.phone || '');
    $('#dob').val(userData.dob || '');
    $('#age-details').text('Age: ' + (userData.dob ? calculateAge(userData.dob) : ''));
    $('#address').val(userData.address || '');
    $('#phone-details').text('Phone: ' + (userData.phone || '-'));
    $('#dob-details').text('DOB: ' + (userData.dob || '-'));
    $('#address-details').text('Address: ' + (userData.address || '-'));
  
    if (userData.dob) {
      $('#age-details').text('Age: ' + calculateAge(userData.dob));
    } else {
      $('#age-details').text('Age: -');
    }
  }
  
  
  function calculateAge(dateString) {
    var today = new Date();
    var birthDate = new Date(dateString);
    var age = today.getFullYear() - birthDate.getFullYear();
    var monthDiff = today.getMonth() - birthDate.getMonth();
    if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDate.getDate())) {
        age--;
    }
    return age;
  }
  
  function getCookie(name) {
    var cookieArr = document.cookie.split(';');
    for (var i = 0; i < cookieArr.length; i++) {
        var cookiePair = cookieArr[i].split('=');
        if (name == cookiePair[0].trim()) {
            return decodeURIComponent(cookiePair[1]);
        }
    }
    return null;
  }
  
  function logoutUser() {
    // Destroy the session (clear the session cookie)
    document.cookie = 'sessionID=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;';
    // Redirect to the login page
    window.location.href = 'login.html';
  }