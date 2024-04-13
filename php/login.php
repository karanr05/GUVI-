<?php
session_start();
require 'db_connection.php';
require 'redis_connection.php'; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Code for handling POST request and login functionality
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Validate input data
    if (empty($username) || empty($password)) {
        echo 'Please fill all fields';
    } else {
        // Prepare SQL statement
        $stmt = $conn->prepare('SELECT COUNT(*) FROM users WHERE BINARY username = ? AND BINARY password = ?');
        $stmt->bind_param('ss', $username, $password);

        // Execute SQL statement
        $stmt->execute();

        $stmt->bind_result($count);
        $stmt->fetch();
        
        if ($count == 1) {
            // Login successful, store the username in the session
            $_SESSION['username'] = $username;

            // Set session ID as a cookie along with the username
            $sessionId = session_id();
            $cookieValue = $sessionId . ':' . $username;
            setcookie('sessionID', $cookieValue, time() + 300, '/');

            // Set session in Redis
            $redis->setex($sessionId, 300, $username);

            $response = [
              'status' => 'success',
              'message' => 'Login successful',
              'sessionID' => $sessionId
            ];

            echo json_encode($response);
        } else {
            $response = [
                'status' => 'fail',
                'message' => 'Couldn\'t Login'
              ];
              echo json_encode($response);
           // echo 'Invalid username or password';
        }

        $stmt->close();
        $conn->close();
    }
}
?>
