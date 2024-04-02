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
        <main class="container">  
            <!-- MAIN CONTENT--> 
            <div class="row mb-5"> 
                <div class="col-5 image-container"> 
                    <div class="image"> 
                    <img class="img-fluid" src="images/Example Book.png" width="100%"/> 
                    </div> 
                </div> 
                <div class="col-6"> 
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
                            <!-- Add to Account Button --> 
                            <div class="button-add-to-account">  
                                <a href="#" class="btn-add-to-account">Add to Account</a>
                                <a href="readbook.php" class="btn-read-book">Read Book</a>  
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