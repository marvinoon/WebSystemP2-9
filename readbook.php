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
        <main>
            <div id="bookContainer" class="book">
                <div id="textContent" class="page"></div>
                <!-- Gpt said include the db stuff here I think -->
                <!-- The page animation stuff is in the main.js -->
            </div>
            <div class="page-controls">
                <button id="prevPage">Previous</button>
                <span id="pageNumber">Page 1</span>
                <button id="nextPage">Next</button>
            </div>
        </main>
        <?php
        include "inc/footer.inc.php";
        ?>
    </body>
</html>