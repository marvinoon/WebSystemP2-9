<!DOCTYPE html>
<html lang="en">
    <head>
        <link rel="stylesheet" href="css/main.css">
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
        <main>
        <div id="welcome-wrapper">
            <section id="slideshow">
                <img src="images/slide1.jpg" alt="Slide 1">
                <img src="images/slide2.jpg" alt="Slide 2">
                <img src="images/slide3.jpg" alt="Slide 3">
            </section>
            <section id="welcome-section">
                <h1 id="headline">Welcome to eBookify!</h1>
                <div class="welcome-container">
                    <p>Discover an endless library of literary treasures, all at your fingertips. Our eBook subscription service offers you unlimited access to a diverse collection of titles - from timeless classics to the latest bestsellers.</p>
                    <ul>
                        <li>📚 Unlimited Access: Enjoy as many books as you like, whenever you want.</li>
                        <li>💡 Curated Collections: Explore expertly curated collections to discover your next great read.</li>
                        <li>🔄 New Titles Weekly: Our library is constantly updated, so you'll never run out of new adventures.</li>
                    </ul>
                    <div class="subscribe-button">
                    <a href="memberships.php" class="subscribe-btn">Sign up for free now!</a>
                    </div>
                </div>
            </section>
        </div>
        <section class="featured-books">
            <div class="featured-container">
                <h2 class="text-center mb-4">Featured Books</h2>
                <div class="row books-container flex-nowrap overflow-auto">
                    
                    <?php
                $bookid = $quantity = $year_published = $book_title =
                $author = $book_language = $book_category = $book_pages = $sample_text = $book_cover = "";
                $success = true;

                // Call the function to retrieve data
                retrieveData();
                
                function retrieveData()
{
    // Using an array to store all books' information
    $books = [];

    // Create database connection.
    $config = parse_ini_file('/var/www/private/db-config.ini');
    if (!$config) {
        echo "Failed to read database config file.";
        return []; // Return an empty array
    }

    $conn = new mysqli(
        $config['servername'],
        $config['username'],
        $config['password'],
        $config['dbname']
    );
    // Check connection
    if ($conn->connect_error) {
        echo "Connection failed: " . $conn->connect_error;
        return []; // Return an empty array
    }

    // Prepare the statement:
    $stmt = $conn->prepare("SELECT * FROM books LIMIT 6;");

    // Execute the query statement:
    if (!$stmt->execute()) {
        echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
    } else {
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            array_push($books, $row); // Push each row into the array
        }
    }
    $stmt->close();
    $conn->close();

    return $books; // Return the array of books
}

// Call the function to retrieve data and store it in $books array
$books = retrieveData();
?>

<!-- HTML and PHP to display the books -->
<section class="featured-books">
    <div class="featured-container">

        <div class="row books-container flex-nowrap overflow-auto">
            <?php foreach ($books as $book): ?>
                <div class="col-3">
                    <div class="card">
                        <img src="images/<?php echo $book['book_cover']; ?>" class="card-img-top" alt="<?php echo $book['book_title']; ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $book['book_title']; ?></h5>
                            <p class="card-text"><?php echo $book['author']; ?></p>
                            <div class="product-button">
                                <a href="productpage.php?book_id=<?php echo $book['book_id']; ?>" class="product-btn">View Details</a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
                </div>
            </div>
        </section> 
        </main>
        <?php
        include "inc/footer.inc.php";
        ?>
    </body>
</html>