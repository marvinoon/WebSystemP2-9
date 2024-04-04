<!DOCTYPE html>
<html lang="en">
    <head>
        <link rel="stylesheet" href="css/readbook.css">
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
        <div class="back-arrow">
            <a href="javascript:history.back()" aria-label="Go back">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
            </a>
        </div>
        <main>
            <div id="bookContainer" class="book">
                <div id="textContent" class="page"></div>
                <?php
// Function to retrieve book data including the text of a specific page
function retrieveBookData($book_id, $page_number)
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

    // Prepare the SQL query to fetch the text of the specific page
    $stmt = $conn->prepare("SELECT text_ofPage FROM book_pages WHERE book_id = ? AND page_number = ?");
    $stmt->bind_param("ii", $book_id, $page_number);

    if (!$stmt->execute()) {
        echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
        $stmt->close();
        $conn->close();
        return null;
    }

    // Bind the result
    $stmt->bind_result($text_ofPage);

    // Fetch the result
    $stmt->fetch();

    // Close the statement
    $stmt->close();

    // Close the connection
    $conn->close();

    // Return the text of the specific page
    return $text_ofPage;
}

// // Check if 'book_id' and 'page_number' are set in the URL parameters
// if (isset($_GET['book_id']) && isset($_GET['page_number'])) {
//     // $book_id = intval($_GET['book_id']);
//     $book_id = 1;
//     $page_number = intval($_GET['page_number']); // Assuming page number is passed in the URL
//     $page_text = retrieveBookData($book_id, $page_number);
//     if (!$page_text) {
//         echo "No text found for the specified page.";
//         // Handle the case where no text is found for the specified page
//     }
// } else {
//     echo "Book ID and page number are required.";
//     // Handle the case where book ID or page number is not provided
// }
// Temporarily using a hardcoded book_id of 1 for testing
$book_id = 1;

// Check if 'page_number' is set in the URL parameters
if (isset($_GET['page_number'])) {
    $page_number = intval($_GET['page_number']); // Fetch the page number from URL
    $page_text = retrieveBookData($book_id, $page_number); // Call the function with the hardcoded book_id

    if (!$page_text) {
        echo "No text found for the specified page.";
        // Handle the case where no text is found for the specified page
    }
} else {
    echo "Page number is required.";
    // Handle the case where page number is not provided
}
function getMaxPageNumber($book_id)
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

    // Prepare the SQL query to fetch the maximum page number
    $stmt = $conn->prepare("SELECT MAX(page_number) AS max_page_number FROM book_pages WHERE book_id = ?");
    $stmt->bind_param("i", $book_id);

    if (!$stmt->execute()) {
        echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
        $stmt->close();
        $conn->close();
        return null;
    }

    // Bind the result
    $stmt->bind_result($max_page_number);

    // Fetch the result
    $stmt->fetch();

    // Close the statement
    $stmt->close();

    // Close the connection
    $conn->close();

    // Return the maximum page number
    return $max_page_number;
}

// Calculate the maximum page number for the book with the given ID
$max_page_number = getMaxPageNumber($book_id);

?>

<!-- MAIN CONTENT -->
<div class="row mb-5">
    <!-- Display the text of the specific page -->
    <?php echo htmlspecialchars($page_text); ?>
    
</div>
</main>     
</div>
            <!-- <div class="page-controls">
                <button id="prevPage">Previous</button>
                <span id="pageNumber">Page 1</span>
                <button id="nextPage" onclick="goToNextPage()">Next</button>
            </div> -->
            <div class="page-controls">
    <?php if ($page_number > 1): ?>
        <a href="readbook.php?book_id=<?php echo $book_id ?>&page_number=<?php echo ($page_number - 1) ?>" class="button">Previous</a>
    <?php else: ?>
        <!-- Hide Previous button if it's the first page -->
        <span style="visibility:hidden;">Previous</span>
    <?php endif; ?>

    <!-- Make sure this is after the PHP block where $max_page_number is set -->
    <span>Page <?php echo $page_number; ?> of <?php echo $max_page_number; ?></span>

    <?php if ($page_number < $max_page_number): ?>
        <a href="readbook.php?book_id=<?php echo $book_id ?>&page_number=<?php echo ($page_number + 1) ?>" class="button">Next</a>
    <?php else: ?>
        <!-- Hide Next button if it's the last page -->
        <span style="visibility:hidden;">Next</span>
    <?php endif; ?>
</div>

        </main>
        <?php
        include "inc/footer.inc.php";
        ?>
    </body>
</html>