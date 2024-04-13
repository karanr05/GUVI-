<?php
require 'db_connection.php';
require 'mongodb_connection.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $phone = $_POST['phone'];
    $dob = $_POST['dob'];
    $age = $_POST['age'];
    $address = $_POST['address'];

    // Retrieve the username from the session
    $username = $_SESSION['username'];

    // Validate input data
    if (empty($phone) || empty($dob) || empty($age) || empty($address)) {
        echo 'Please fill all fields';
        exit;
    } else {
        // Check if 'age' column exists in the 'users' table
        $result = $conn->query("SHOW COLUMNS FROM users LIKE 'age'");
        if ($result->num_rows === 0) {
            echo "MySQL error: The column 'age' does not exist in the 'users' table. Please add the column.\n";
            exit;
        }

        // Prepare the SQL statement
        echo "Preparing MySQL update query: 'UPDATE users SET phone = ?, dob = ?, age = ?, address = ? WHERE username = ?'\n";
        echo "Values: phone = $phone, dob = $dob, age = $age, address = $address, username = $username\n";

        $stmt = $conn->prepare('UPDATE users SET phone = ?, dob = ?, age = ?, address = ? WHERE username = ?');
        if ($stmt === false) {
            echo "Failed to prepare the SQL statement. Please check your query and field names.\n";
            echo "MySQL error: " . $conn->error . "\n";
            exit;
        }

        // Bind parameters
        $stmt->bind_param('ssiss', $phone, $dob, $age, $address, $username);

        // Execute the statement
        $mysqlUpdateSuccess = $stmt->execute();
        echo "MySQL update result: " . ($mysqlUpdateSuccess ? "Success" : "Failure") . "\n";

        // MongoDB update
        $filter = ['username' => $username];
        $update = ['$set' => ['phone' => $phone, 'dob' => $dob, 'age' => $age, 'address' => $address]];
        $updateResult = $mongoCollection->updateOne($filter, $update);

        echo "MongoDB modified count: " . $updateResult->getModifiedCount() . "\n";

        // Check if both updates were successful
        if ($mysqlUpdateSuccess && $updateResult->getModifiedCount() > 0) {
            echo 'Update successful';
        } else {
            echo 'Update failed';
        }

        // Close resources
        $stmt->close();
        $conn->close();
    }
}
?>
