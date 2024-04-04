<!DOCTYPE html>
<html lang="en">
<head>
    <?php 
    include "inc/head.inc.php"; 
    require_once "zebra_session/session_start.php";
    require_once "db_connect.php";
    
    // Function to fetch cart items for a user from the database
    function fetchCartItems($user_id, $link) {
        // Prepare the SQL statement to select cart items for the user
        $stmt = $link->prepare("SELECT books.book_title, books.author, books.book_id FROM cart JOIN books ON cart.book_id = books.book_id WHERE cart.user_id = ?");
        $stmt->bind_param("i", $user_id);

        // Execute the SQL statement
        $stmt->execute();

        // Get the result set
        $result = $stmt->get_result();

        // Initialize an empty array to store cart items
        $cart_items = array();

        // Fetch cart items as associative arrays and store in $cart_items array
        while ($row = $result->fetch_assoc()) {
            $cart_items[] = $row;
        }

        // Close the statement
        $stmt->close();

        // Return the cart items array
        return $cart_items;
    }
    ?>
    <link rel="stylesheet" href="css/nav.css">
    <link rel="stylesheet" href="css/footer.css">
</head>
<body>
    <?php include "inc/nav.inc.php"; ?>
    <div class="container">
        <h2>Cart</h2>
        <div class="cart-items">
            <?php
            $user_id = $_SESSION['user_id']; // Assuming the user is logged in
            $cart_items = fetchCartItems($user_id, $link);
            
            // Check if cart has items
            if ($cart_items) {
                // Loop through each cart item
                foreach ($cart_items as $item) {
                    ?>
                    <div class="cart-item">
                        <h3><?php echo $item['book_title']; ?></h3>
                        <p>Author: <?php echo $item['author']; ?></p>
                        <!-- You can include more details here if needed -->
                    </div>
                <?php
                }
                ?>
                <!-- Borrow button -->
                <form action="borrow_books.php" method="post">
                    <?php foreach ($cart_items as $item) { ?>
                        <input type="hidden" name="book_ids[]" value="<?php echo $item['book_id']; ?>">
                    <?php } ?>
                    <button type="submit" name="borrow_books" class="btn btn-primary">Borrow book(s)</button>
                </form>
            <?php
            } else {
                // Display message if cart is empty
                echo "<p>Your cart is empty.</p>";
            }
            ?>
        </div>
    </div>
</body>
</html>
