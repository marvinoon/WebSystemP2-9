<?php
// Function to retrieve book data including the text of a specific page
function retrieveBookData($book_id, $page_number)
{
    $config = parse_ini_file('/var/www/private/db-config.ini');
    if (!$config) {
        echo "Failed to read database config file.";
        return null;
    }

    $conn = new mysqli(
        $config['servername'],
        $config['username'],
        $config['password'],
        $config['dbname']
    );

    if ($conn->connect_error) {
        echo "Connection failed: " . $conn->connect_error;
        return null;
    }

    // Prepare the SQL query to fetch the text of the specific page
    $stmt = $conn->prepare("SELECT text_ofPage FROM book_pages WHERE book_id = ? AND page_number = ?");
    $stmt->bind_param("ii", $book_id, $page_number);

    if (!$stmt->execute()) {
        echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
        $stmt->close();
        $conn->close();
        return null;
    }

    // Bind the result
    $stmt->bind_result($text_ofPage);

    // Fetch the result
    $stmt->fetch();

    // Close the statement
    $stmt->close();

    // Close the connection
    $conn->close();

    // Return the text of the specific page
    return $text_ofPage;
}

// Function to get the maximum page number for a book
function getMaxPageNumber($book_id)
{
    $config = parse_ini_file('/var/www/private/db-config.ini');
    if (!$config) {
        echo "Failed to read database config file.";
        return null;
    }

    $conn = new mysqli(
        $config['servername'],
        $config['username'],
        $config['password'],
        $config['dbname']
    );

    if ($conn->connect_error) {
        echo "Connection failed: " . $conn->connect_error;
        return null;
    }

    // Prepare the SQL query to fetch the maximum page number
    $stmt = $conn->prepare("SELECT MAX(page_number) AS max_page_number FROM book_pages WHERE book_id = ?");
    $stmt->bind_param("i", $book_id);

    if (!$stmt->execute()) {
        echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
        $stmt->close();
        $conn->close();
        return null;
    }

    // Bind the result
    $stmt->bind_result($max_page_number);

    // Fetch the result
    $stmt->fetch();

    // Close the statement
    $stmt->close();

    // Close the connection
    $conn->close();

    // Return the maximum page number
    return $max_page_number;
}
?>