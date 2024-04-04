<!DOCTYPE html>
<html lang="en">
<head>
    <?php include "inc/head.inc.php"; ?>
    <link rel="stylesheet" href="css/nav.css">
    <link rel="stylesheet" href="css/footer.css">
    <style>
        .book-container {
            border: 1px solid #ccc;
            padding: 10px;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <?php include "inc/nav.inc.php"; ?>
    <div class="container">
        <h2>Borrowed Books</h2>
        <?php
        // Assuming user is logged in and user_id is available in session
        $user_id = $_SESSION['user_id'];
        
        // Query to select borrowed books for the logged-in user
        $query = "SELECT books.book_id, books.book_title, books.author FROM borrowed_transactions
                  JOIN books ON borrowed_transactions.book_id = books.book_id
                  WHERE borrowed_transactions.user_id = ?";
        
        // Prepare and execute the query
        $stmt = $link->prepare($query);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        
        // Get the result
        $result = $stmt->get_result();
        
        // Check if there are borrowed books
        if ($result->num_rows > 0) {
            // Output each borrowed book
            while ($row = $result->fetch_assoc()) {
                ?>
                <div class="book-container">
                    <h3><?php echo htmlspecialchars($row['book_title']); ?></h3>
                    <p>Author: <?php echo htmlspecialchars($row['author']); ?></p>
                    <a href="readbook.php?book_id=<?php echo $row['book_id']; ?>&page_number=1" class="btn btn-primary">Read Book</a>
                </div>
                <?php
            }
        } else {
            echo "<p>You haven't borrowed any books yet.</p>";
        }
        ?>
    </div>
    <?php include "inc/footer.inc.php"; ?>
</body>
</html>
