<!DOCTYPE html> 
<html lang="en"> 
    <head> 
        
        <link rel="stylesheet" href="css/nav.css"> 
        <link rel="stylesheet" href="css/footer.css"> 
        <link rel="stylesheet" href="css/productpage.css">  
    <?php include "inc/head.inc.php";
            require_once "zebra_session/session_start.php";
        ?>
    </head>
    
    <body>
    <?php
        include "inc/nav.inc.php";
    ?>
        <main class="container">
 
        <div class="back-arrow">
            <a href="javascript:history.back()" aria-label="Go back">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                
            </a>
        </div>
        <?php
        error_reporting(E_ALL);
        ini_set('display_errors', 1);
include_once "db_connect.php"; // Include the database connection

function getUserMembershipStatus($user_id, $link) {
    // Prepare SQL query to fetch user membership status
    $stmt = $link->prepare("SELECT membershipType FROM user WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);

    if (!$stmt->execute()) {
        echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
        $stmt->close();
        return null;
    }

    // Bind the result
    $stmt->bind_result($membership_status);

    // Fetch the result
    $stmt->fetch();

    // Close the statement
    $stmt->close();

    // Return the membership status
    return $membership_status;
}
// Function to retrieve data of a book based on its ID
function retrieveData($book_id, $link) {
    // Prepare SQL query to fetch book data
    $stmt = $link->prepare("SELECT * FROM books WHERE book_id = ?");
    $stmt->bind_param("i", $book_id);

    if (!$stmt->execute()) {
        echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
        $stmt->close();
        return null;
    }

    // Get the result set
    $result = $stmt->get_result();

    // Fetch the book data as an associative array
    $book = $result->fetch_assoc();

    // Close the statement
    $stmt->close();

    // Return the book data
    return $book;
}
// Check if 'book_id' is set in the URL
if (isset($_GET['book_id'])) {
    $book_id = intval($_GET['book_id']);
    $book = retrieveData($book_id, $link); // Assuming retrieveData function is defined
    if (!$book) {
        echo "No book found.";
        // Handle the case where no book is found
    }
} else {
    echo "No book ID provided.";
    // Handle the case where no book_id is provided   
}

// Check if user is logged in
if (isset($_SESSION['user_id'])) {
    // Retrieve user ID from session
    $user_id = $_SESSION['user_id'];
    
    // Get the membership status
    $membership_status = getUserMembershipStatus($user_id, $link);

}
?>

            <!-- MAIN CONTENT-->
            <div class="row mb-5">
                <div class="col-5 image-container">
                    <div class="image">
                        <!-- Display the book cover image -->
                        <img class="img-fluid" src="images/<?php echo htmlspecialchars($book['book_cover']); ?>" width="100%"/>
                    </div>
                </div>
                <div class="col-6">
                    <div class="item-details-container">
                        <!-- Display the book title -->
                        <h1><?php echo htmlspecialchars($book['book_title']); ?></h1>
                        <div class="product-details">
                            <h2>Description</h2>
                            <!-- Display the book description -->
                            <p><?php echo htmlspecialchars($book['sample_text']); ?></p>
                            <!-- Book Details Section -->
                            <div class="book-details">
                                <!-- Display the book information -->
                                <h3>Book Information</h3>
                                <p><strong>Author:</strong> <?php echo htmlspecialchars($book['author']); ?></p>
                                <p><strong>Year Published:</strong> <?php echo htmlspecialchars($book['year_published']); ?></p>
                                <p><strong>Language:</strong> <?php echo htmlspecialchars($book['book_language']); ?></p>
                                <p><strong>Category:</strong> <?php echo htmlspecialchars($book['book_category']); ?></p>
                                <p><strong>Number of Pages:</strong> <?php echo htmlspecialchars($book['book_pages']); ?></p>
                                <p><strong>Quantity Remaining:</strong> <?php echo htmlspecialchars($book['quantity']); ?></p>
                            </div>
                            <!-- Add to Account Button -->
                            <div class="button-add-to-account">
                                <?php
                                error_reporting(E_ALL);
                                ini_set('display_errors', 1);
                                
// Check if user is logged in
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $membership_status = getUserMembershipStatus($user_id, $link);

    // Add to Account Button
    if ($membership_status === "Regular" || $membership_status === "Premium") {
        echo '<a href="add_to_cart.php?book_id=' . $book['book_id'] . '" class="btn-add-to-account">Add to Account</a>';
    } else {
        echo '<a href="upgrade_membership.php" class="btn-add-to-account">Upgrade Membership to borrow the book</a>';
    }
} else {
    echo '<a href="loginregister.php" class="btn-add-to-account">Login to borrow the book</a>';
}
                                ?>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </main>
        <?php
        include "inc/footer.inc.php";
        ?>
    </body> 
</html>