<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="css/catalog.css">
    <link rel="stylesheet" href="css/nav.css">
    <link rel="stylesheet" href="css/footer.css">
    <?php
    include "inc/head.inc.php";
    require_once "zebra_session/session_start.php";
    ?>
</head>
    <body>
        <?php
            include "inc/nav.inc.php";
        ?>
        <div class="row container">
            <div class="col-lg-2">
                <div class="back-arrow">
                    <a href="javascript:history.back()" aria-label="Go back">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                    </a>
                </div>
            </div>
            <div class="col-sm-12 col-lg-10 mt-2">
                <h1>Browse our Catalog!</h1>
            </div>
        </div>
    
        <main>
            <!-- MAIN BODY -->
            <div class="row container">
            <!-- SIDE BAR -->
            <div class="col-lg-2 mt-3 ml-3 side-bar">
                <div class="category">
                    <h4>Category</h4>
                    <ul>
                        <li><a href="#">All</a></li>
                        <li><a href="#">Non Fiction</a></li>
                        <li><a href="#">Science Fiction</a></li>
                        <li><a href="#">Romance</a></li>
                        <li><a href="#">Mystery</a></li>
                        <li><a href="#">Horror</a></li>
                    </ul>
                </div>
            </div>

            <!-- MAIN BAR-->
            <div class="col-sm-12 col-lg-10 main-content">
            <div class="drop-down">
                <label>Sort By:</label>
                <select class="filter-type">
                    <option>Name A-Z</option>
                    <option>Name Z-A</option>
                    <option>Oldest to newest</option>
                    <option>Newest to Oldest</option>
                </select>
            </div>
                <div class="book-cards-container mt-3 mb-3">
                    <div class="book-card">
                        <img src="images/Example Book.png" alt="Book Title" class="book-image">
                        <div class="book-info">
                            <h5 class="book-title">Book Title</h5>
                            <p class="book-author">Author Name</p>
                            <p class="book-category">Category</p>
                            <div class="product-button">
                                <a href="productpage.php" class="product-btn">View Details</a>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Repeat for as many books as you have. Foreach loop using DB I think-->
                </div>
            </div>
        </main>
        <?php
        include "inc/footer.inc.php";
        ?>
    </body>
</html>
