<?php
// Retrieve data from the database
function retrieveBooks() {
    $books = array(); // Initialize an empty array to store books

    // Create database connection
    $config = parse_ini_file('/var/www/private/db-config.ini');
    if (!$config) {
        return false; // Return false if failed to read database config file
    }

    $conn = new mysqli(
        $config['servername'],
        $config['username'],
        $config['password'],
        $config['dbname']
    );

    // Check connection
    if ($conn->connect_error) {
        return false; // Return false if connection failed
    }

    // Prepare and execute the SQL statement to select all books
    $stmt = $conn->prepare("SELECT * FROM books");
    $stmt->execute();
    $result = $stmt->get_result();

    // Fetch books and store them in the array
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $books[] = $row;
        }
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();

    return $books; // Return the array of books
}
?>
