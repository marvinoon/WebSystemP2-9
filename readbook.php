<!DOCTYPE html>
<html lang="en">
    <head>
        <link rel="stylesheet" href="css/readbook.css">
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
        <div class="back-arrow">
            <a href="javascript:history.back()" aria-label="Go back">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
            </a>
        </div>
        <main class="container">
            <div class="row">
            <div class="col"> 
                    <div class="item-details-container"> 
                        <h1>Voyage Beyond The Stars</h1> 
                        
                        <div class="product-details"> 
                            <h2>Description</h2> 
                            <p>Embark on an unforgettable journey with "Voyage Beyond The Stars".  
                            This gripping novel by Alex R. Nova takes you on an interstellar adventure, where boundaries are limitless and the unknown awaits.  
                            This tale of courage, discovery, and the quest for knowledge is a must-read for sci-fi enthusiasts.</p> 
                            
                            <!-- Book Details Section --> 
                            <div class="book-details"> 
                                <h3>Book Information</h3> 
                                <p><strong>Author:</strong> Alex R. Nova</p> 
                                <p><strong>ISBN:</strong> 123-4567890123</p> 
                                <p><strong>Year Published:</strong> 2024</p> 
                                <p><strong>Language:</strong> English</p> 
                                <p><strong>Category:</strong> Science Fiction</p> 
                                <p><strong>Number of Pages:</strong> 320</p> 
                                <p><strong>Quantity Remaining:</strong> 10</p> 
                            </div> 
                        </div> 
                    </div> 
                </div>
                <div class="col" id="book">
                    <div id="textContent" class="page"></div>
                    <!-- Gpt said include the db stuff here I think -->
                    <!-- The page animation stuff is in the main.js -->
                    <div class="page-controls">
                        <button id="prevPage">Previous</button>
                        <span id="pageNumber">Page 1</span>
                        <button id="nextPage">Next</button>
                    </div>
                </div>   
            </div>
        </main>
        <?php
        include "inc/footer.inc.php";
        ?>
    </body>
</html>