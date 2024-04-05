<?php
    // Include necessary files
    require_once "zebra_session/session_start.php";
    require_once "db_connect.php";

    // Fetch distinct categories from the books table
    $queryCategory = "SELECT DISTINCT book_category FROM books";
    $resultCategory = mysqli_query($link, $queryCategory);
    
    // Initialize an empty array to store categories
    $categories = array();
    
    // Check if query was successful and retrieve categories
    if ($resultCategory) {
        while ($row = mysqli_fetch_assoc($resultCategory)) {
            $categories[] = $row['book_category'];
        }
    }
    
    // Check if a category is selected
    if (isset($_GET['category'])) {
        // Sanitize the selected category
        $selectedCategory = mysqli_real_escape_string($link, $_GET['category']);
        
        // Fetch books belonging to the selected category
        $query = "SELECT * FROM books WHERE book_category = '$selectedCategory'";
    } else {
        // Fetch all books if no category is selected
        $query = "SELECT * FROM books";
    }
    
    // Execute the query to fetch books
    $result = mysqli_query($link, $query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="css/catalog.css">
    <link rel="stylesheet" href="css/nav.css">
    <link rel="stylesheet" href="css/footer.css">
    <?php include "inc/head.inc.php"; ?>
</head>
<body>
    <?php include "inc/nav.inc.php"; ?>
    <div class="row container">
        <div class="col-lg-2">
            <div class="back-arrow">
                <a href="javascript:history.back()" aria-label="Go back">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left">
                        <line x1="19" y1="12" x2="5" y2="12"></line>
                        <polyline points="12 19 5 12 12 5"></polyline>
                    </svg>
                </a>
            </div>
        </div>
        <div class="col-sm-12 col-lg-10 mt-2">
            <h1>Browse our Catalog!</h1>
        </div>
    </div>
    <main>
        <div class="row container">
            <div class="col-lg-2 mt-3 ml-3 side-bar">
                <div class="category">
                    <h4>Category</h4>
                    <ul>
                        <!-- Add a link for "All" -->
                        <li><a href="catalog.php">All</a></li>
                        <!-- Loop through the categories array to generate list items dynamically -->
                        <?php foreach ($categories as $category) { ?>
                            <li><a href="catalog.php?category=<?php echo urlencode($category); ?>"><?php echo $category; ?></a></li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
            <div class="col-sm-12 col-lg-10 main-content">
                <div class="drop-down">
                    <label>Sort By:</label>
                    <select class="filter-type" onchange="sortBooks(this.value)">
                        <option value="name_az">Name A-Z</option>
                        <option value="name_za">Name Z-A</option>
                        <option value="oldest_newest">Oldest to Newest</option>
                        <option value="newest_oldest">Newest to Oldest</option>
                    </select>
                </div>
                <div class="book-cards-container mt-3 mb-3">
                    <?php
                        // Check if there are any books
                        if(mysqli_num_rows($result) > 0) {
                            // Loop through each book record
                            while($row = mysqli_fetch_assoc($result)) {
                                // Output book card
                                echo '<div class="book-card">';
                                echo '<img src="' . $row['book_cover'] . '" alt="' . $row['book_title'] . '" class="book-image">';
                                echo '<div class="book-info">';
                                echo '<h5 class="book-title">' . $row['book_title'] . '</h5>';
                                echo '<p class="book-author">' . $row['author'] . '</p>';
                                echo '<p class="book-category">' . $row['book_category'] . '</p>';
                                echo '<p class="book-date">' . $row['year_published'] . '</p>'; // Add year_published here
                                echo '<div class="product-button">';
                                echo '<a href="productpage.php?book_id=' . $row['book_id'] . '" class="product-btn">View Details</a>';
                                echo '</div>';
                                echo '</div>';
                                echo '</div>';
                            }
                        } else {
                            echo "No books found.";
                        }
                    ?>
                </div>
            </div>
        </div>
    </main>
    <?php include "inc/footer.inc.php"; ?>
</body>

<script>
    // Function to sort books based on the selected option
    function sortBooks(sortBy) {
        // Get the container of book cards
        var bookContainer = document.querySelector('.book-cards-container');

        // Get all book cards
        var books = bookContainer.querySelectorAll('.book-card');

        // Convert the NodeList to an array for easier manipulation
        var booksArray = Array.from(books);

        // Perform sorting based on the selected option
        switch (sortBy) {
            case 'name_az':
                booksArray.sort((a, b) => a.querySelector('.book-title').textContent.localeCompare(b.querySelector('.book-title').textContent));
                break;
            case 'name_za':
                booksArray.sort((a, b) => b.querySelector('.book-title').textContent.localeCompare(a.querySelector('.book-title').textContent));
                break;
            case 'oldest_newest':
                booksArray.sort((a, b) => new Date(a.querySelector('.book-date').textContent) - new Date(b.querySelector('.book-date').textContent));
                break;
            case 'newest_oldest':
                booksArray.sort((a, b) => new Date(b.querySelector('.book-date').textContent) - new Date(a.querySelector('.book-date').textContent));
                break;
        }

        // Clear the book container
        bookContainer.innerHTML = '';

        // Append sorted book cards back to the container
        booksArray.forEach(book => {
            bookContainer.appendChild(book);
        });
    }
</script>
</html>
