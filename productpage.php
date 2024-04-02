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
    <?php include "db_connect.php"; 
    ?> 
    <?php 
// Assuming you have a book_id to query. In a real application, this might come from the URL or user input. 
$book_id = 1; // Example book ID 
 
// Prepare the SQL statement 
$stmt = $conn->prepare("SELECT * FROM books WHERE book_id = ?"); 
$stmt->bind_param("i", $book_id); 
 
// Execute the query 
$stmt->execute(); 
$result = $stmt->get_result(); 
 
// Fetch the book details 
if ($result->num_rows > 0) { 
    $book = $result->fetch_assoc(); // Get the book details 
} else { 
    echo "No book found."; 
} 
 
$stmt->close(); 
$conn->close(); 
?> 
 
        <main class="container"> 
            <header> 
                <div class="row mt-3 nav-container"> 
                    <div class="col-sm-12 col-md-6"> 
                        ADD BOOKS TO YOUR LIST 
                    </div> 
                    <nav class="col-sm-12 col-md-6 nav-item"> 
                        <ul>               
                            <li><a href="#"><i class="fa-solid fa-user"></i><span>Account</span></a></li> 
                            <li><a href="#"><i class="fa-solid fa-heart"></i><span>Wishlist</span></a></li> 
                        </ul> 
                    </nav> 
                </div> 
            </header> 
 
            <!-- BREADCRUMB --> 
            <div class="breadcrumb mt-5"> 
                <ul> 
                    <li><a href="#">Home</a></li> 
                    <li><a href="#">Collections</a></li> 
                    <li><a href="#">Products</a></li> 
                </ul> 
            </div> 
 
            <!-- MAIN CONTENT--> 
            <div class="row mb-5"> 
                <div class="col-5 image-container"> 
                    <div class="image"> 
                    <img class="img-fluid" src="images/Example Book.png" width="100%"/> 
                    </div> 
                </div> 
                <div class="col-6"> 
                    <div class="item-details-container"> 
                        <!-- <h1>Voyage Beyond The Stars</h1> --> 
                        <h1><?php echo $book['book_title']; ?></h1> 
                        <div class="product-details"> 
                            <h2>Description</h2> 
                            <!-- <p>Embark on an unforgettable journey with "Voyage Beyond The Stars".  
                            This gripping novel by Alex R. Nova takes you on an interstellar adventure, where boundaries are limitless and the unknown awaits.  
                            This tale of courage, discovery, and the quest for knowledge is a must-read for sci-fi enthusiasts.</p> --> 
                            <p><?php echo $book['sample_text']; ?></p> 
                            <!-- Book Details Section --> 
                            <div class="book-details"> 
                                <h3>Book Information</h3> 
                                <!-- <p><strong>Author:</strong> Alex R. Nova</p> 
                                <p><strong>ISBN:</strong> 123-4567890123</p> 
                                <p><strong>Year Published:</strong> 2024</p> 
                                <p><strong>Language:</strong> English</p> 
                                <p><strong>Category:</strong> Science Fiction</p> 
                                <p><strong>Number of Pages:</strong> 320</p> 
                                <p><strong>Quantity Remaining:</strong> 10</p> --> 
                                <p><strong>Author:</strong> <?php echo $book['author']; ?></p> 
            <p><strong>Year Published:</strong> <?php echo $book['year_published']; ?></p> 
            <p><strong>Language:</strong> <?php echo $book['book_language']; ?></p>
            <p><strong>Category:</strong> <?php echo $book['book_category']; ?></p> 
            <p><strong>Number of Pages:</strong> <?php echo $book['book_pages']; ?></p> 
            <p><strong>Quantity Remaining:</strong> <?php echo $book['quantity']; ?></p> 
         
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