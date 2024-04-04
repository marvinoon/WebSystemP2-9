<!DOCTYPE html>
<html lang="en">
<head>
<link rel="stylesheet" href="css/nav.css">
<link rel="stylesheet" href="css/footer.css">
    <?php 
        include "inc/head.inc.php";
        require_once "zebra_session/session_start.php";
    ?>
</head>
<body>
    <?php
        include "inc/nav.inc.php";
    ?>
    <?php

    include_once "db_connect.php";
// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect the user to the login page or display a message
    header("Location: loginregister.php");
    exit; // Stop further execution
}

// Check if book_id is provided in the URL
if (isset($_GET['book_id'])) {
    
    // Retrieve book details from the database based on the book_id
    $book_id = intval($_GET['book_id']);
    echo $book_id;
    $book = retrieveData($book_id,$link); // Assuming you have a function to retrieve book details

    if ($book) {
        // Add book details to the cart table in the database
        if (addToCart($_SESSION['user_id'], $book_id, $link)) { // Assuming you have a function to add to the cart
            // Redirect the user to the cart page or display a success message
            header("Location: cart.php");
            exit; // Stop further execution
        } else {
            echo "Failed to add the book to the cart. Please try again later.";
        }
    } else {
        echo "Book not found.";
    }
} else {
    echo "No book ID provided.";
}

// Function to add book details to the cart table in the database
function addToCart($user_id, $book_id, $link) {
    // Prepare the SQL statement to insert into the cart table
    $stmt = $link->prepare("INSERT INTO cart (user_id, book_id) VALUES (?, ?)");
    $stmt->bind_param("ii", $user_id, $book_id);

    // Execute the SQL statement
    $result = $stmt->execute();

    // Close the statement
    $stmt->close();

    // Return true on success, false on failure
    return $result;
}

// Function to retrieve book details from the database based on the book_id
function retrieveData($book_id, $link) {
    // Prepare the SQL statement to select book details
    $stmt = $link->prepare("SELECT * FROM books WHERE book_id = ?");
    $stmt->bind_param("i", $book_id);

    // Execute the SQL statement
    $stmt->execute();

    // Get the result set
    $result = $stmt->get_result();

    // Fetch book details as an associative array
    $book = $result->fetch_assoc();

    // Close the statement
    $stmt->close();

    // Return the book details or null if not found
    return $book;
}
?>
</body>
</html>