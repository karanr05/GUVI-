<?php
require 'mongodb_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $username = $_GET['username'];

    // Find user data in MongoDB collection
    $userData = $mongoCollection->findOne(['username' => $username]);

    if ($userData) {
        echo json_encode($userData);
    } else {
        echo 'User data not found';
    }
} else {
    echo 'Invalid request method';
}
?>
