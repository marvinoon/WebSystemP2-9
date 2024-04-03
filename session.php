<?php

 // Create database connection (assuming db connection setup elsewhere in your code)
 $config = parse_ini_file('/var/www/private/db-config.ini');
 if (!$config) {
     return false; // Return false if unable to read config file
 }

 $conn = new mysqli(
     $config['servername'],
     $config['username'],
     $config['password'],
     $config['dbname']
 );
 
 if ($conn->connect_error) {
     return false; // Return false if unable to connect to database
 }

// instantiate the class
// this also calls session_start()
$security_code = bin2hex(random_bytes(16)); // Generates a 32-character hexadecimal string
$session = new Zebra_Session($conn, $security_code);

?>
