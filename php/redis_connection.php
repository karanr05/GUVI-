<?php

// Include Predis library autoload file
require 'vendor/autoload.php';

// Use the Predis Client namespace
use Predis\Client;

try {
    // Create a new Predis Client instance to connect to Redis
    $redis = new Client([
        'scheme' => 'tcp',
        'host'   => 'redis-10818.c15.us-east-1-4.ec2.cloud.redislabs.com',
        'port'   => 10818,
        'password' => '6QDX07og1OMMlzoSpjsZp69vG79JagBl', // Redis server password
    ]);
} 
catch (Exception $e) {
    // Handle connection error
    echo 'Redis connection error: ' . $e->getMessage();
}

?>
