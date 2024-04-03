<!DOCTYPE html>
<html lang="en">

<head>
        <link rel="stylesheet" href="css/aboutus.css">
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

    <header class="S1">
        <div class="heading">
            <h1 id="headline">Welcome to eBookify!</h1>
            <img id="header" class="img-fluid" src="images/books.jpg" />
        </div>
    </header>
    <main>
        <section class="featured-books">
            <div class="featured-container">
                <h2 class="text-center mb-4">Books</h2>
                <div class="text-center">
                    <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#exampleModal">Add Book</button>

                    <!-- Modal -->
                    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Testing</h5>
                                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form method="post">
                                        <div class="form-group">
                                            <label for="field-title" class="col-form-label">Fill Me:</label>
                                            <input type="text" class="form-control" id="field-title" name="field-title" >
                                        </div>
                                        <!-- <div class="form-group">
                                            <label for="message-text" class="col-form-label">Description:</label>
                                            <textarea class="form-control" id="field-description" name="field-description"></textarea>
                                        </div> -->
                                        <div class="form-group">
                                            <label for="message-text" class="col-form-label">Image:</label>
                                            <input type="text" class="form-control" id="field-image" name="field-image"></input>
                                        </div>
                                        <div class="form-group">
                                            <label for="message-text" class="col-form-label">Quantity:</label>
                                            <input type="text" class="form-control" id="field-quantity" name="field-quantity"></input>
                                        </div>
                                        <div class="form-group">
                                            <label for="message-text" class="col-form-label">Year Published:</label>
                                            <input type="text" class="form-control" id="field-published" name="field-published"></input>
                                        </div>
                                        <div class="form-group">
                                            <label for="message-text" class="col-form-label">Language:</label>
                                            <input type="text" class="form-control" id="field-language" name="field-language"></input>
                                        </div>
                                        <div class="form-group">
                                            <label for="message-text" class="col-form-label">Category:</label>
                                            <input type="text" class="form-control" id="field-category" name="field-category"></input>
                                        </div>
                                        <div class="form-group">
                                            <label for="message-text" class="col-form-label">Pages:</label>
                                            <input type="text" class="form-control" id="field-pages" name="field-pages"></input>
                                        </div>
                                        <div class="form-group">
                                            <label for="message-text" class="col-form-label">Sample Text:</label>
                                            <textarea class="form-control" id="field-sample" name="field-sample"></textarea>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary" id="btn-save" name="btn-save" >Save changes</button>
                                        </div>
                                    </form>
                                </div>
                                
                            </div>
                        </div>
                    </div>

                </div>

                <?php
                    if(array_key_exists('btn-save', $_POST)) { 
                        saveLogic(); 
                    } 
                    function saveLogic(){
                        $title = $errorMsg = "";
                        $image = $errorMsg = "";
                        $quantity = $errorMsg = "";
                        $published = $errorMsg = "";
                        $language = $errorMsg = "";
                        $category = $errorMsg = "";
                        $pages = $errorMsg = "";
                        $sample = $errorMsg = "";
                        $success = true;
    
                        //Validate fields
                        if (empty($_POST["field-title"]))
                        {
                            $errorMsg .= "Title is required.\\n";
                            $success = false;
                        }
                        else
                        {
                            $title = sanitize_input($_POST["field-title"]);
                        }

                        if (empty($_POST["field-image"]))
                        {
                            $errorMsg .= "Image is required.\\n";
                            $success = false;
                        }
                        else
                        {
                            $image = sanitize_input($_POST["field-image"]);
                        }

                        if (empty($_POST["field-quantity"]))
                        {
                            $errorMsg .= "Quantity is required.\\n";
                            $success = false;
                        }
                        else
                        {
                            $quantity = sanitize_input($_POST["field-quantity"]);
                        }

                        if (empty($_POST["field-published"]))
                        {
                            $errorMsg .= "Date published is required.\\n";
                            $success = false;
                        }
                        else
                        {
                            $published = sanitize_input($_POST["field-published"]);
                        }

                        if (empty($_POST["field-language"]))
                        {
                            $errorMsg .= "Language is required.\\n";
                            $success = false;
                        }
                        else
                        {
                            $language = sanitize_input($_POST["field-language"]);
                        }

                        if (empty($_POST["field-category"]))
                        {
                            $errorMsg .= "Category is required.\\n";
                            $success = false;
                        }
                        else
                        {
                            $category = sanitize_input($_POST["field-category"]);
                        }

                        if (empty($_POST["field-pages"]))
                        {
                            $errorMsg .= "Page count is required.\\n";
                            $success = false;
                        }
                        else
                        {
                            $pages = sanitize_input($_POST["field-pages"]);
                        }

                        if (empty($_POST["field-sample"]))
                        {
                            $errorMsg .= "Sample Text is required.\\n";
                            $success = false;
                        }
                        else
                        {
                            $sample = sanitize_input($_POST["field-sample"]);
                        }

                        //If success 
                        if ($success)
                        {
                            
                            saveBookToDB($title, $image, $quantity, $published, $language, $category, $pages, $sample);
                        }
                        else
                        {
                            echo "<script>alert('$errorMsg');</script>";
                        }
                        
                        
                        
                        //$fname = "Test";
                        // echo "<script>alert('$title');</script>";
                        // echo "<script>alert('$image');</script>";
                        // echo "<script>alert('$quantity');</script>";
                        // echo "<script>alert('$published');</script>";
                        // echo "<script>alert('$language');</script>";
                        // echo "<script>alert('$category');</script>";
                        // echo "<script>alert('$pages');</script>";
                        // echo "<script>alert('$sample');</script>";
    
                        
                    }
                    function sanitize_input($data)
                    {
                        $data = trim($data);
                        $data = stripslashes($data);
                        $data = htmlspecialchars($data);
                        return $data;
                    }

                    function saveBookToDB($title, $image, $quantity, $published, $language, $category, $pages, $sample)
                    {
                        //global $fname, $lname, $email, $pwd, $errorMsg, $success;
                        $errorMsg = "";
                        $success = true;

                        // Create database connection.
                        $config = parse_ini_file('/var/www/private/db-config.ini');
                        if (!$config)
                        {
                            $errorMsg = "Failed to read database config file.";
                            $success = false;
                        }
                        else
                        {
                            $conn = new mysqli(
                                $config['servername'],
                                $config['username'],
                                $config['password'],
                                $config['dbname']
                        );

                        // Check connection
                        if ($conn->connect_error)
                        {
                            $errorMsg = "Connection failed: " . $conn->connect_error;
                            $success = false;
                        }
                        else
                        {
                            // Prepare the statement:
                            $stmt = $conn->prepare("INSERT INTO books
                                (quantity, year_published, book_title, author, book_language, book_pages, sample_text) VALUES (?, ?, ?, ?, ?, ?, ?)"); 

                            // Bind & execute the query statement:
                            $stmt->bind_param("sssssss", $quantity, $published, $title, $category, $language, $pages, $sample);
                            if (!$stmt->execute())
                            {
                                $errorMsg = "Execute failed: (" . $stmt->errno . ") " .
                                    $stmt->error;
                                $success = false;
                            }
                            $stmt->close();
                        }
                        $conn->close();
                        }

                        //inform success of fail
                        if ($success)
                        {
                            echo "<script>alert('Success');</script>";
                        }
                        else
                        {
                            echo "<script>alert('$errorMsg');</script>";
                        }
                    }
                ?>

                

                <div class="row books-container flex-nowrap overflow-auto">
                    <!-- print from db -->
                <?php
                    //global $fname, $lname, $email, $pwd, $errorMsg, $success;
                    $errorMsg = "";
                    $success = true;

                    // Create database connection.
                    $config = parse_ini_file('/var/www/private/db-config.ini');
                    if (!$config)
                    {
                        $errorMsg = "Failed to read database config file.";
                        $success = false;
                    }
                    else
                    {
                        $conn = new mysqli(
                            $config['servername'],
                            $config['username'],
                            $config['password'],
                            $config['dbname']
                    );

                    // Check connection
                    if ($conn->connect_error)
                    {
                        $errorMsg = "Connection failed: " . $conn->connect_error;
                        $success = false;
                    }
                    else
                    {
                        // Prepare the statement:
                        $stmt = $conn->prepare("SELECT * FROM books");
                        $stmt->execute();
                        $result = $stmt->get_result();

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) 
                            {
                                echo '
                                <div class="col-3">
                                    <div class="card">
                                        <img src="images/Example Book.png" class="card-img-top" alt="Book ' . $row["book_id"] . '">
                                        <div class="card-body">
                                            <h5 class="card-title">' . $row["book_title"] . '</h5>
                                            <p class="card-text">Book ' . $row["sample_text"] . '</p>
                                            <button type="button" class="btn btn-warning" onclick="openModal(' . $row["book_id"] . ')">Edit</button>
                                            <button type="button" class="btn btn-danger" onclick="openModal(' . $row["book_id"] . ')">Delete</button>
                                        </div>
                                    </div>
                                </div>';
                            }
                        }
                    }
                    $conn->close();
                    }

                    //inform success of fail
                    if ($success)
                    {
                        echo "<script>alert('Generation Success');</script>";
                    }
                    else
                    {
                        echo "<script>alert('$errorMsg');</script>";
                    }
                ?>
                <script>
                    alert("Test");
                    function openModal(bookId) {
                        alert(bookId);
                        $('#editModal').modal('show');
                    }
                </script>
                    <div class="col-3">
                        <div class="card">
                            <img src="images/Example Book.png" class="card-img-top" alt="Book 6">
                            <div class="card-body">
                                <h5 class="card-title">Book Title 6</h5>
                                <p class="card-text">Book 6 description...</p>
                                <form method="post">
                                    <button type="submit" class="btn btn-warning" id="btn-edit" name="btn-edit">Edit</button>
                                    <button type="submit" class="btn btn-danger" id="btn-delete" name="btn-delete">Delete</button>
                                </form>

                                <?php
                                    if(array_key_exists('btn-edit', $_POST)) { 
                                        editLogic(); 
                                    }

                                    if(array_key_exists('btn-delete', $_POST)) { 
                                        deleteLogic(); 
                                    }

                                    function deleteLogic()
                                    {
                                        //db delete logic here
                                        echo "<script>alert('Delete');</script>";
                                        //DELETE FROM table_name WHERE = condition;

                                    }

                                    function editLogic()
                                    {
                                        //db edit logic here
                                        echo "<script>alert('Edit');</script>";
                                    }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Book</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editForm" onsubmit="saveChanges(event)">
                    <input type="hidden" id="bookIdInput" name="book_id">
                    <div class="form-group">
                        <label for="titleInput">Title</label>
                        <input type="text" class="form-control" id="titleInput" name="title">
                    </div>
                    <div class="form-group">
                        <label for="descriptionInput">Description</label>
                        <textarea class="form-control" id="descriptionInput" name="description"></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </form>
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