<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="css/aboutus.css">
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

    <!-- Only admin can view this page -->
    <?php
    if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
        // Redirect to the homepage or another page
        header('Location: index.php');
        exit();
    }
    ?>

    <script>
        //To prevent repeated form submissions
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }
    </script>

    <header class="S1">
        <div class="heading">
            <h1 id="headline">Welcome to eBookify!</h1>
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
                                    <h5 class="modal-title" id="exampleModalLabel">Add Book</h5>
                                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form method="post">
                                        <div class="form-group">
                                            <label for="field-title" class="col-form-label">Title:</label>
                                            <input type="text" required class="form-control" id="field-title" name="field-title">
                                        </div>
                                        <div class="form-group">
                                            <label for="field-image" class="col-form-label">Image:</label>
                                            <input type="file" required class="form-control" id="field-image" name="field-image">
                                        </div>
                                        <div class="form-group">
                                            <label for="field-quantity" class="col-form-label">Quantity:</label>
                                            <input type="number" required class="form-control" id="field-quantity" name="field-quantity">
                                        </div>
                                        <div class="form-group">
                                            <label for="field-published" class="col-form-label">Year Published:</label>
                                            <input type="text" required class="form-control" id="field-published" name="field-published">
                                        </div>
                                        <div class="form-group">
                                            <label for="field-author" class="col-form-label">Author:</label>
                                            <input type="text" required class="form-control" id="field-author" name="field-author">
                                        </div>
                                        <div class="form-group">
                                            <label for="field-language" class="col-form-label">Language:</label>
                                            <input type="text" required class="form-control" id="field-language" name="field-language">
                                        </div>
                                        <div class="form-group">
                                            <label for="field-category" class="col-form-label">Category:</label>
                                            <input type="text" required class="form-control" id="field-category" name="field-category">
                                        </div>
                                        <div class="form-group">
                                            <label for="field-pages" class="col-form-label">Pages:</label>
                                            <input type="number" required class="form-control" id="field-pages" name="field-pages">
                                        </div>
                                        <div class="form-group">
                                            <label for="field-sample" class="col-form-label">Sample Text:</label>
                                            <textarea required class="form-control" id="field-sample" name="field-sample"></textarea>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary" id="btn-save" name="btn-save">Save</button>
                                        </div>
                                    </form>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <?php
                if (array_key_exists('btn-save', $_POST)) {
                    saveLogic();
                }
                function saveLogic()
                {
                    $title = $errorMsg = "";
                    $image = $errorMsg = "";
                    $quantity = $errorMsg = "";
                    $published = $errorMsg = "";
                    $author = $errorMsg = "";
                    $language = $errorMsg = "";
                    $category = $errorMsg = "";
                    $pages = $errorMsg = "";
                    $sample = $errorMsg = "";
                    $success = true;

                    //Validate fields
                    if (empty($_POST["field-title"])) {
                        $errorMsg .= "Title is required.\\n";
                        $success = false;
                    } else {
                        $title = sanitize_input($_POST["field-title"]);
                    }

                    if (empty($_POST["field-image"])) {
                        $errorMsg .= "Image is required.\\n";
                        $success = false;
                    } else {
                        //image 
                        $target_dir = "images/";
                        $target_file = $target_dir . $_POST["field-image"];
                        $uploadOk = 1;
                        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

                        // Check if image file is a actual image or fake image 
                        $check = getimagesize($target_file);
                        if ($check !== false) {
                            // File is an image - " . $check["mime"] . ". 
                            $uploadOk = 1;
                        } else {
                            $errorMsg .= "Please select an image file.\\n";
                            $uploadOk = 0;
                        }

                        // Check file size 
                        if (filesize($target_file) > 500000) {
                            $errorMsg .= "Image file is too large.\\n";
                            $uploadOk = 0;
                        }

                        // Allow certain file formats 
                        if (
                            $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
                            && $imageFileType != "gif"
                        ) {
                            $errorMsg .= "Only JPG, JPEG, PNG & GIF files are allowed.\\n";
                            $uploadOk = 0;
                        }

                        // Check if $uploadOk is set to 0 by an error 
                        if ($uploadOk == 0) {
                            $errorMsg .= "Error in Image Upload\\n";
                            $success = false;
                            // if everything is ok, try to upload file 
                        } else {
                            $image = $target_file;
                        }
                    }

                    if (empty($_POST["field-quantity"])) {
                        $errorMsg .= "Quantity is required.\\n";
                        $success = false;
                    } else {
                        $quantity = sanitize_input($_POST["field-quantity"]);
                    }

                    if (empty($_POST["field-published"])) {
                        $errorMsg .= "Date published is required.\\n";
                        $success = false;
                    } else {
                        $published = sanitize_input($_POST["field-published"]);
                    }

                    if (empty($_POST["field-author"])) {
                        $errorMsg .= "Author is required.\\n";
                        $success = false;
                    } else {
                        $author = sanitize_input($_POST["field-author"]);
                    }

                    if (empty($_POST["field-language"])) {
                        $errorMsg .= "Language is required.\\n";
                        $success = false;
                    } else {
                        $language = sanitize_input($_POST["field-language"]);
                    }

                    if (empty($_POST["field-category"])) {
                        $errorMsg .= "Category is required.\\n";
                        $success = false;
                    } else {
                        $category = sanitize_input($_POST["field-category"]);
                    }

                    if (empty($_POST["field-pages"])) {
                        $errorMsg .= "Page count is required.\\n";
                        $success = false;
                    } else {
                        $pages = sanitize_input($_POST["field-pages"]);
                    }

                    if (empty($_POST["field-sample"])) {
                        $errorMsg .= "Sample Text is required.\\n";
                        $success = false;
                    } else {
                        $sample = sanitize_input($_POST["field-sample"]);
                    }



                    //If success 
                    if ($success) {
                        saveBookToDB($title, $image, $quantity, $published, $author, $language, $category, $pages, $sample);
                    } else {
                        echo "<script>alert('$errorMsg');</script>";
                    }
                }
                function sanitize_input($data)
                {
                    $data = trim($data);
                    $data = stripslashes($data);
                    $data = htmlspecialchars($data);
                    return $data;
                }

                function saveBookToDB($title, $image, $quantity, $published, $author, $language, $category, $pages, $sample)
                {
                    $errorMsg = "";
                    $success = true;

                    // Create database connection.
                    $config = parse_ini_file('/var/www/private/db-config.ini');
                    if (!$config) {
                        $errorMsg = "Failed to read database config file.";
                        $success = false;
                    } else {
                        $conn = new mysqli(
                            $config['servername'],
                            $config['username'],
                            $config['password'],
                            $config['dbname']
                        );

                        // Check connection
                        if ($conn->connect_error) {
                            $errorMsg = "Connection failed: " . $conn->connect_error;
                            $success = false;
                        } else {
                            // Prepare the statement:
                            $stmt = $conn->prepare("INSERT INTO books
                                (quantity, year_published, book_title, author, book_language, book_category, book_pages, sample_text, book_cover) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");

                            // Bind & execute the query statement:
                            $stmt->bind_param("sssssssss", $quantity, $published, $title, $author, $language, $category, $pages, $sample, $image);
                            if (!$stmt->execute()) {
                                $errorMsg = "Execute failed: (" . $stmt->errno . ") " .
                                    $stmt->error;
                                $success = false;
                            }
                            $stmt->close();
                        }
                        $conn->close();
                    }

                    //inform success of fail
                    if ($success) {
                        echo "<script>alert('Success');</script>";
                        echo "<script>location.reload();</script>";
                    } else {
                        echo "<script>alert('$errorMsg');</script>";
                    }
                }
                ?>



                <div style="padding-top: 10px;" class="row books-container flex-nowrap overflow-auto">
                    <!-- print from db -->
                    <?php
                    $errorMsg = "";
                    $success = true;

                    // Create database connection.
                    $config = parse_ini_file('/var/www/private/db-config.ini');
                    if (!$config) {
                        $errorMsg = "Failed to read database config file.";
                        $success = false;
                    } else {
                        $conn = new mysqli(
                            $config['servername'],
                            $config['username'],
                            $config['password'],
                            $config['dbname']
                        );

                        // Check connection
                        if ($conn->connect_error) {
                            $errorMsg = "Connection failed: " . $conn->connect_error;
                            $success = false;
                        } else {
                            // Prepare the statement:
                            $stmt = $conn->prepare("SELECT * FROM books");
                            $stmt->execute();
                            $result = $stmt->get_result();

                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo '
                                <div class="col-3">
                                    <div class="card">
                                        <img src="' . $row["book_cover"] . '" class="card-img-top" alt="Book ' . $row["book_id"] . '">
                                        <div class="card-body">
                                            <h5 class="card-title">' . $row["book_title"] . '</h5>
                                            <p class="card-text">' . $row["sample_text"] . '</p>
                                            <button type="button" class="btn btn-warning" onclick="openEditModal(' . $row["book_id"] . ', ' . $row["quantity"] . ', ' . $row["year_published"] . ', \'' . $row["book_title"] . '\',\'' . $row["author"] . '\',\'' . $row["book_language"] . '\',\'' . $row["book_category"] . '\',' . $row["book_pages"] . ', \'' . $row["sample_text"] . '\',\'' . $row["book_cover"] . '\')">Edit</button>
                                            <form method="post">
                                                <input type="hidden" name="del_book_id" value="' . $row['book_id'] . '">
                                                <button type="submit" class="btn btn-danger" name="btn-delete" onclick="return confirm(\'Are you sure you want to delete this book?\')">Delete</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>';
                                }
                            }
                        }
                        $conn->close();
                    }

                    //inform success of fail
                    if (!$success) {
                        echo "<script>alert('$errorMsg');</script>";
                    }

                    if (array_key_exists('btn-delete', $_POST)) {
                        deleteFromDB();
                    }

                    function deleteFromDB()
                    {
                        $bookId = $_POST["del_book_id"];
                        $errorMsg = "";
                        $success = true;

                        // Create database connection.
                        $config = parse_ini_file('/var/www/private/db-config.ini');
                        if (!$config) {
                            $errorMsg = "Failed to read database config file.";
                            $success = false;
                        } else {
                            $conn = new mysqli(
                                $config['servername'],
                                $config['username'],
                                $config['password'],
                                $config['dbname']
                            );

                            // Check connection
                            if ($conn->connect_error) {
                                $errorMsg = "Connection failed: " . $conn->connect_error;
                                $success = false;
                            } else {

                                // Prepare the statement:
                                $stmt = $conn->prepare("DELETE FROM books WHERE (book_id = ?)");

                                // Bind & execute the query statement:
                                $stmt->bind_param("i", $bookId);
                                if (!$stmt->execute()) {
                                    $errorMsg = "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
                                    $success = false;
                                }
                                $stmt->close();
                            }
                            $conn->close();
                        }

                        //inform success of fail
                        if ($success) {
                            echo "<script>alert('Delete Success');</script>";
                            echo "<script>location.reload();</script>";
                        } else {
                            echo "<script>alert('$errorMsg');</script>";
                        }
                    }

                    ?>
                    <script>
                        function openEditModal(bookId, quant, year, title, author, lang, cat, pages, samp, cover) {
                            // Set the book ID in the modal input field
                            document.getElementById('bookIdInput').value = bookId;

                            // Populate the modal fields with the retrieved data
                            document.getElementById('edit-field-title').value = title;
                            document.getElementById('edit-field-quantity').value = quant;
                            document.getElementById('edit-field-published').value = year;
                            document.getElementById('edit-field-author').value = author;
                            document.getElementById('edit-field-language').value = lang;
                            document.getElementById('edit-field-category').value = cat;
                            document.getElementById('edit-field-pages').value = pages;
                            document.getElementById('edit-field-sample').value = samp;


                            // Show the modal
                            $('#editModal').modal('show');
                        }
                    </script>
                </div>
            </div>
        </section>

        <!-- edit modal (hidden by default) -->
        <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel">Edit Book</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="post" id="editForm">
                            <input type="hidden" class="form-control" id="bookIdInput" name="bookIdInput">
                            <div class="form-group">
                                <label for="edit-field-title" class="col-form-label">Title:</label>
                                <input type="text" required class="form-control" id="edit-field-title" name="edit-field-title">
                            </div>
                            <div class="form-group">
                                <label for="edit-field-image" class="col-form-label">Image:</label>
                                <input type="file" required class="form-control" id="edit-field-image" name="edit-field-image">
                            </div>
                            <div class="form-group">
                                <label for="edit-field-quantity" class="col-form-label">Quantity:</label>
                                <input type="number" required class="form-control" id="edit-field-quantity" name="edit-field-quantity">
                            </div>
                            <div class="form-group">
                                <label for="edit-field-published" class="col-form-label">Year Published:</label>
                                <input type="text" required class="form-control" id="edit-field-published" name="edit-field-published">
                            </div>
                            <div class="form-group">
                                <label for="edit-field-author" class="col-form-label">Author:</label>
                                <input type="text" required class="form-control" id="edit-field-author" name="edit-field-author">
                            </div>
                            <div class="form-group">
                                <label for="edit-field-language" class="col-form-label">Language:</label>
                                <input type="text" required class="form-control" id="edit-field-language" name="edit-field-language">
                            </div>
                            <div class="form-group">
                                <label for="edit-field-category" class="col-form-label">Category:</label>
                                <input type="text" required class="form-control" id="edit-field-category" name="edit-field-category">
                            </div>
                            <div class="form-group">
                                <label for="edit-field-pages" class="col-form-label">Pages:</label>
                                <input type="number" required class="form-control" id="edit-field-pages" name="edit-field-pages">
                            </div>
                            <div class="form-group">
                                <label for="edit-field-sample" class="col-form-label">Sample Text:</label>
                                <textarea required class="form-control" id="edit-field-sample" name="edit-field-sample"></textarea>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary" id="btn-save-changes" name="btn-save-changes">Save Changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <?php
        if (array_key_exists('btn-save-changes', $_POST)) {
            editLogic();
        }
        function editLogic()
        {
            $bookId = $_POST["bookIdInput"];

            $title = $errorMsg = "";
            $image = $errorMsg = "";
            $quantity = $errorMsg = "";
            $published = $errorMsg = "";
            $author = $errorMsg = "";
            $language = $errorMsg = "";
            $category = $errorMsg = "";
            $pages = $errorMsg = "";
            $sample = $errorMsg = "";
            $success = true;

            //Validate fields
            if (empty($_POST["edit-field-title"])) {
                $errorMsg .= "Title is required.\\n";
                $success = false;
            } else {
                $title = sanitize_input($_POST["edit-field-title"]);
            }

            if (empty($_POST["edit-field-image"])) {
                $errorMsg .= "Image is required.\\n";
                $success = false;
            } else {
                //image 
                $target_dir = "images/";
                $target_file = $target_dir . $_POST["edit-field-image"];
                $uploadOk = 1;
                $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

                // Check if image file is a actual image or fake image 
                $check = getimagesize($target_file);
                if ($check !== false) {
                    // File is an image - " . $check["mime"] . ". 
                    $uploadOk = 1;
                } else {
                    $errorMsg .= "Please select an image file.\\n";
                    $uploadOk = 0;
                }

                // Check file size 
                if (filesize($target_file) > 500000) {
                    $errorMsg .= "Image file is too large.\\n";
                    $uploadOk = 0;
                }

                // Allow certain file formats 
                if (
                    $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
                    && $imageFileType != "gif"
                ) {
                    $errorMsg .= "Only JPG, JPEG, PNG & GIF files are allowed.\\n";
                    $uploadOk = 0;
                }

                // Check if $uploadOk is set to 0 by an error 
                if ($uploadOk == 0) {
                    $errorMsg .= "Error in Image Upload\\n";
                    $success = false;
                    // if everything is ok, try to upload file 
                } else {
                    $image = $target_file;
                }
            }

            if (empty($_POST["edit-field-quantity"])) {
                $errorMsg .= "Quantity is required.\\n";
                $success = false;
            } else {
                $quantity = sanitize_input($_POST["edit-field-quantity"]);
            }

            if (empty($_POST["edit-field-published"])) {
                $errorMsg .= "Date published is required.\\n";
                $success = false;
            } else {
                $published = sanitize_input($_POST["edit-field-published"]);
            }

            if (empty($_POST["edit-field-author"])) {
                $errorMsg .= "Author is required.\\n";
                $success = false;
            } else {
                $author = sanitize_input($_POST["edit-field-author"]);
            }

            if (empty($_POST["edit-field-language"])) {
                $errorMsg .= "Language is required.\\n";
                $success = false;
            } else {
                $language = sanitize_input($_POST["edit-field-language"]);
            }

            if (empty($_POST["edit-field-category"])) {
                $errorMsg .= "Category is required.\\n";
                $success = false;
            } else {
                $category = sanitize_input($_POST["edit-field-category"]);
            }

            if (empty($_POST["edit-field-pages"])) {
                $errorMsg .= "Page count is required.\\n";
                $success = false;
            } else {
                $pages = sanitize_input($_POST["edit-field-pages"]);
            }

            if (empty($_POST["edit-field-sample"])) {
                $errorMsg .= "Sample Text is required.\\n";
                $success = false;
            } else {
                $sample = sanitize_input($_POST["edit-field-sample"]);
            }

            //If success 
            if ($success) {
                updateBookInDB($bookId, $title, $image, $quantity, $published, $author, $language, $category, $pages, $sample);
            } else {
                echo "<script>alert('$errorMsg');</script>";
            }
        }

        function updateBookInDB($bookId, $title, $image, $quantity, $published, $author, $language, $category, $pages, $sample)
        {
            //global $fname, $lname, $email, $pwd, $errorMsg, $success;
            $errorMsg = "";
            $success = true;

            // Create database connection.
            $config = parse_ini_file('/var/www/private/db-config.ini');
            if (!$config) {
                $errorMsg = "Failed to read database config file.";
                $success = false;
            } else {
                $conn = new mysqli(
                    $config['servername'],
                    $config['username'],
                    $config['password'],
                    $config['dbname']
                );

                // Check connection
                if ($conn->connect_error) {
                    $errorMsg = "Connection failed: " . $conn->connect_error;
                    $success = false;
                } else {

                    // Prepare the statement:
                    $stmt = $conn->prepare("UPDATE books SET quantity = ?, year_published = ?, book_title = ?, author = ?, book_language = ?, book_category = ?, book_pages = ?, sample_text = ?, book_cover = ? WHERE (book_id = ?);");

                    // Bind & execute the query statement:
                    $stmt->bind_param("sssssssssi", $quantity, $published, $title, $author, $language, $category, $pages, $sample, $image, $bookId);
                    //$stmt->bind_param("si", $quantity, $bookId);
                    if (!$stmt->execute()) {
                        $errorMsg = "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
                        $success = false;
                    }
                    $stmt->close();
                }
                $conn->close();
            }

            //inform success of fail
            if ($success) {
                echo "<script>alert('Update Success');</script>";
                echo "<script>location.reload();</script>";
            } else {
                echo "<script>alert('$errorMsg');</script>";
            }
        }
        ?>


    </main>

    <?php
    include "inc/footer.inc.php";
    ?>
</body>

</html>