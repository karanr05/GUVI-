<?php
require 'vendor/autoload.php';


try {
    // Create MongoDB client
    $mongoClient = new MongoDB\Client("mongodb+srv://karanramalingam5:oe9FcTt2SJWQwHzR@cluster5.it9sffz.mongodb.net/?retryWrites=true&w=majority&appName=Cluster5");
    $mongoDatabaseName = 'mydb';
    $collection = 'users';
    // Select the database and collection
    $mongoDatabase = $mongoClient->selectDatabase($mongoDatabaseName);
    $mongoCollection = $mongoDatabase->selectCollection($collection);

} 
 catch (Exception $e) {
    echo "An error occurred. Error: " . $e->getMessage();
}
?>
