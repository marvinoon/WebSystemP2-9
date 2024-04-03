<!DOCTYPE html>
<html lang="en">
    <head>
        <link rel="stylesheet" href="css/main.css">
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
                    <!-- Book 1 -->
                    <div class="col-3">
                        <div class="card">
                            <img src="images/Example Book.png" class="card-img-top" alt="Book 1">
                            <div class="card-body">
                                <h5 class="card-title">Book Title 1</h5>
                                <p class="card-text">Book 1 Author</p>
                                <div class="product-button">
                                    <a href="productpage.php" class="product-btn">View Details</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Book 2 -->
                    <div class="col-3">
                        <div class="card">
                            <img src="images/Example Book.png" class="card-img-top" alt="Book 2">
                            <div class="card-body">
                                <h5 class="card-title">Book Title 2</h5>
                                <p class="card-text">Book 2 Author</p>
                                <div class="product-button">
                                    <a href="productpage.php" class="product-btn">View Details</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="card">
                            <img src="images/Example Book.png" class="card-img-top" alt="Book 3">
                            <div class="card-body">
                                <h5 class="card-title">Book Title 3</h5>
                                <p class="card-text">Book 3 Author</p>
                                <div class="product-button">
                                    <a href="productpage.php" class="product-btn">View Details</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="card">
                            <img src="images/Example Book.png" class="card-img-top" alt="Book 4">
                            <div class="card-body">
                                <h5 class="card-title">Book Title 4</h5>
                                <p class="card-text">Book 4 Author</p>
                                <div class="product-button">
                                    <a href="productpage.php" class="product-btn">View Details</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="card">
                            <img src="images/Example Book.png" class="card-img-top" alt="Book 5">
                            <div class="card-body">
                                <h5 class="card-title">Book Title 5</h5>
                                <p class="card-text">Book 5 Author</p>
                                <div class="product-button">
                                    <a href="productpage.php" class="product-btn">View Details</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="card">
                            <img src="images/Example Book.png" class="card-img-top" alt="Book 6">
                            <div class="card-body">
                                <h5 class="card-title">Book Title 6</h5>
                                <p class="card-text">Book 6 Author</p>
                                <div class="product-button">
                                    <a href="productpage.php" class="product-btn">View Details</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section> 
        </main>
        <?php
        include "inc/footer.inc.php";
        ?>
    </body>
</html>