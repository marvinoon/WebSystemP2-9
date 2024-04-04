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
        $book_ids = $_POST['book_ids'];

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
        header("Location: borrow_books.php");
        exit();
    } else {
        // Redirect to an error page or display an error message
        header("Location: borrow_error.php");
        exit();
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
