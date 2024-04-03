<?php
// Create database connection.
$config = parse_ini_file('/var/www/private/db-config.ini');
if (!$config) {
    $errorMsg = "Failed to read database config file.";
    $success = false;
} else {
    $link = mysqli_connect(
        $config['servername'],
        $config['username'],
        $config['password'],
        $config['dbname']
    );

}
?>
