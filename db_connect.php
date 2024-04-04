<?php
// // Create database connection.
// $config = parse_ini_file('/var/www/private/db-config.ini');
// if (!$config) {
//     $errorMsg = "Failed to read database config file.";
//     $success = false;
// } else {
//     $link = mysqli_connect(
//         $config['servername'],
//         $config['username'],
//         $config['password'],
//         $config['dbname']
//     );

// }
// Include the database configuration
include_once "db-config.php";

// Create a connection to the database
$link = mysqli_connect(
    $config['servername'],
    $config['username'],
    $config['password'],
    $config['dbname']
);

// Check the connection
if (!$link) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
?>
