<?php
require_once "zebra_session/session_start.php";
require_once "db_connect.php";

// Check if the return_book button is clicked
// Check if the return_book button is clicked
if(isset($_POST['return_book'])) {
    // Get user ID from session
    $user_id = $_SESSION['user_id'];
    
    // Debugging line: Print the user ID
    echo "User ID: " . $user_id . "<br>";

    // Get the current date as the returned date
    $returned_date = date("Y-m-d");
    
    // Debugging line: Print the returned date
    echo "Returned Date: " . $returned_date . "<br>";

    // Retrieve book ID from the form
    $book_id = $_POST['book_id'];
    
    // Debugging line: Print the book ID
    echo "Book ID: " . $book_id . "<br>";
    // Retrieve borrowed date from the form
    $borrowed_date = $_POST['borrowed_date'];

    // Debugging line: Print the borrowed date
    echo "Borrowed Date: " . $borrowed_date . "<br>";

    // Check if book_id is empty
    if(empty($book_id)) {
        echo "Error: Book ID not provided.";
        exit(); // Exit the script
    }

    // Insert the returned book into returned_transactions table
    $stmt = $link->prepare("INSERT INTO returned_transactions (book_id, user_id, returned_date,borrowed_date) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("iiss", $book_id, $user_id, $returned_date, $_POST['borrowed_date']);

    // Execute the SQL statement
    $stmt->execute();

    // Close the statement
    $stmt->close();

    // Delete the record from borrowed_transactions table
    $stmt = $link->prepare("DELETE FROM borrowed_transactions WHERE book_id = ? AND user_id = ?");
    $stmt->bind_param("ii", $book_id, $user_id);

    // Execute the SQL statement
    $stmt->execute();

    // Close the statement
    $stmt->close();

    // Debugging line: Print a success message
    echo "Book returned successfully.<br>";

    // Redirect to a success page or display a success message
    header("Location: books_borrowed.php");
    exit();
} else {
    // Print error message for debugging
    echo "Error: Return button not clicked or book_id not set.";    
}

?>
