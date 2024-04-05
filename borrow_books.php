<!DOCTYPE html>
<html lang="en">
<title>Borrow Books</title>
<?php
require_once "zebra_session/session_start.php";
require_once "db_connect.php";

// Check if the borrow_books button is clicked
if(isset($_POST['borrow_books'])) {
    // Get user ID from session
    $user_id = $_SESSION['user_id'];

    // Get the current date
    $borrowed_date = date("Y-m-d");

    // Retrieve book IDs from the cart
    // Check if book_ids is an array or a single value
    $book_ids = is_array($_POST['book_ids']) ? $_POST['book_ids'] : array($_POST['book_ids']);

    // Check if book_ids is empty
    if(empty($book_ids)) {
        echo "Error: No books selected for borrowing.";
        exit(); // Exit the script
    }

    // Insert each book into borrowed_transactions table
    foreach($book_ids as $book_id) {
        // Prepare the SQL statement
        $stmt = $link->prepare("INSERT INTO borrowed_transactions (book_id,user_id,  borrowed_date) VALUES (?, ?, ?)");
        $stmt->bind_param("iis",$book_id,  $user_id, $borrowed_date);

        // Execute the SQL statement
        $stmt->execute();

        // Close the statement
        $stmt->close();
    }

    // Clear the cart after borrowing
    clearCart($user_id);

    // Redirect to a success page or display a success message
    header("Location: books_borrowed.php");
    exit();
} 
else {
    // Print error message for debugging
    echo "Error: Borrow button not clicked or book_ids not set.";
    // You can also print additional debugging information if needed
    print_r($_POST);

}

// Function to clear the cart for a user
function clearCart($user_id) {
    global $link;

    // Prepare the SQL statement to delete cart items for the user
    $stmt = $link->prepare("DELETE FROM cart WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);

    // Execute the SQL statement
    $stmt->execute();

    // Close the statement
    $stmt->close();
}
?>
</html>
