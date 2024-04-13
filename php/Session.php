<?php
session_start();

if (isset($_COOKIE['sessionID'])) {

    require 'db_connection.php';
    require 'redis_connection.php'; 
    require 'mongodb_connection.php'; 

    $cookieValue = $_COOKIE['sessionID'];
    $cookieParts = explode(':', $cookieValue);
    $sessionID = $cookieParts[0];
    $username = $cookieParts[1];

    // Check if session ID exists in Redis
    $redisUsername = $redis->get($sessionID);

    if ($redisUsername === $username) {
        // Check if session ID exists in MongoDB
        $sessionData = $mongoCollection->findOne(['username' => $username]);

        if ($sessionData) {
            // Session and username are valid, restore the session
            $_SESSION['username'] = $username;
            echo 'Session validated';
        } else {
            // Username not found in MongoDB, redirect to login page
            echo 'Session invalid';
            //exit();
        }
    } else {
        // Session is not valid, redirect to login page
        echo 'Session invalid';
        //exit();
    }
} else {
    // Session ID not found in the cookie, redirect to login page
    echo 'Session invalid';
    //exit();
}
?>
