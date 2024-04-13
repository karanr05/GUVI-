<?php

require 'db_connection.php';
require 'mongodb_connection.php';

echo 'Request method: ' . $_SERVER['REQUEST_METHOD'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];

    // validate input data
    if (empty($username) || empty($password) || empty($email)) {
        echo 'Please fill all fields';
    } else {
        try {
            // Start a transaction
            $conn->begin_transaction();

            // Prepare MySQL insert statement
            $stmt = $conn->prepare('INSERT INTO users (username, password, email) VALUES (?, ?, ?)');
            $stmt->bind_param('sss', $username, $password, $email);

            // Execute MySQL insert
            $mysqlInsert = $stmt->execute();

            // Check MySQL insert result
            if (!$mysqlInsert) {
                throw new Exception('MySQL insert failed');
            }

            // Prepare MongoDB insert data
            $user_data = ['username' => $username, 'email' => $email];

            // Execute MongoDB insert
            $mongoInsert = $mongoCollection->insertOne($user_data);

            // Check MongoDB insert result
            if ($mongoInsert->getInsertedCount() <= 0) {
                throw new Exception('MongoDB insert failed');
            }

            // Commit the transaction if both inserts were successful
            $conn->commit();

            echo 'Signup successful';
        } catch (Exception $e) {
            // Rollback the transaction if any exception occurs
            $conn->rollback();
            echo "Error: " . $sql . "<br>" . $conn->error;
        } finally {
            // Close statements and connections
            $stmt->close();
            $conn->close();
        }
    }
}

?>
