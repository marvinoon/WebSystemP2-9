<!DOCTYPE html> 
<html lang="en"> 
    <head> 
        <link rel="stylesheet" href="css/productpage.css"> 
        <link rel="stylesheet" href="css/nav.css"> 
        <link rel="stylesheet" href="css/footer.css"> 
        <?php 
            include "inc/head.inc.php" 
        ?> 
    </head> 
    <body> 
    <?php 
        include "inc/nav.inc.php"; 
    ?> 
    <body> 
        <div class="back-arrow">
            <a href="javascript:history.back()" aria-label="Go back">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                
            </a>
        </div>
        <?php
            //function to retrieve data
            function retrieveData($book_id)
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

                $stmt = $conn->prepare("SELECT * FROM books WHERE book_id = ?");
                $stmt->bind_param("i", $book_id);

                if (!$stmt->execute()) {
                    echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
                    $stmt->close();
                    $conn->close();
                    return null;
                }

                $result = $stmt->get_result();
                if ($row = $result->fetch_assoc()) {
                    $stmt->close();
                    $conn->close();
                    return $row;
                } else {
                    $stmt->close();
                    $conn->close();
                    return null;
                }
            }

            // Check if 'book_id' is set in the string
            if (isset($_GET['book_id'])) {
                $book_id = intval($_GET['book_id']);
                $book = retrieveData($book_id);
                if (!$book) {
                    echo "No book found.";
                    // Handle the case where no book is found
                }
            } else {
                echo "No book ID provided.";
                // Handle the case where no book_id is provided
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
                                <button class="btn-add-to-account">Add to Account</button>
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