<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="css/readbook.css">
    <link rel="stylesheet" href="css/nav.css">
    <link rel="stylesheet" href="css/footer.css">
    <?php include "inc/head.inc.php"; 
    require_once "zebra_session/session_start.php";

    ?>
</head>
<body>
    <?php include "inc/nav.inc.php"; ?>
    <div class="back-arrow">
        <a href="javascript:history.back()" aria-label="Go back">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
        </a>
    </div>
    <main>
        <div id="bookContainer" class="book">
            
            <?php 
            // Include the functions file
            require_once "process_readbook.php";
            
            // Check if 'page_number' is set in the URL parameters
            if (isset($_GET['page_number']) && isset($_GET['book_id'])) {
                $page_number = intval($_GET['page_number']); // Fetch the page number from URL
                $book_id = intval($_GET['book_id']); // Fetch the book ID from URL
                $page_text = retrieveBookData($book_id, $page_number); // Call the function with the book_id from URL

                if (!$page_text) {
                    echo "No text found for the specified page.";
                    // Handle the case where no text is found for the specified page
                }
            } else {
                echo "Page number and book ID are required.";
                // Handle the case where page number or book ID is not provided
            }

            // Calculate the maximum page number for the book with the given ID
            $max_page_number = getMaxPageNumber($book_id);
            ?>
            <div id="textContent" class="page">
            <!-- MAIN CONTENT -->
                <div class="row mb-5">
                <!-- Display the text of the specific page -->
                    <?php echo htmlspecialchars($page_text); ?>
                </div>
            </div>
        </div>
        <div class="page-controls">
            <?php if ($page_number > 1): ?>
                <a href="readbook.php?book_id=<?php echo $book_id ?>&page_number=<?php echo ($page_number - 1) ?>" class="button">Previous</a>
            <?php else: ?>
                <!-- Hide Previous button if it's the first page -->
                <span style="visibility:hidden;">Previous</span>
            <?php endif; ?>

            <!-- Make sure this is after the PHP block where $max_page_number is set -->
            <span>  Page <?php echo $page_number; ?> of <?php echo $max_page_number; ?>  </span>

            <?php if ($page_number < $max_page_number): ?>
                <a href="readbook.php?book_id=<?php echo $book_id ?>&page_number=<?php echo ($page_number + 1) ?>" class="button">Next</a>
            <?php else: ?>
                <!-- Hide Next button if it's the last page -->
                <span style="visibility:hidden;">Next</span>
            <?php endif; ?>
        </div>
    </main>
    <?php include "inc/footer.inc.php"; ?>
</body>
</html>
