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
        // header('Location: index.php');
        // exit();
    }
    ?>
    <script>//To prevent repeated form submissions
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
                <h2 class="text-center mb-4">Users</h2>
                <ul class="list-group list-group-light">
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <img src="https://mdbootstrap.com/img/new/avatars/8.jpg" alt="" style="width: 45px; height: 45px" class="rounded-circle" />
                            <h3>ID: 1</h3>
                            <div class="ms-3">
                                <p class="fw-bold mb-1">John Doe</p>
                                <p class="text-muted mb-0">john.doe@gmail.com</p>
                            </div>
                        </div>
                        <span class="badge rounded-pill badge-success">Active</span>
                    </li>
                </ul>

                <ul class="list-group list-group-light">
                    <!-- print from db -->
                    <?php
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
                            $stmt = $conn->prepare("SELECT * FROM user");
                            $stmt->execute();
                            $result = $stmt->get_result();

                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo '
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center">
                                        <h3>ID: ' . $row["user_id"] . '</h3>
                                        <div class="ms-3">
                                            <p class="fw-bold mb-1">' . $row["fname"] . ' ' . $row["lname"] . '</p>
                                            <p class="text-muted mb-0">' . $row["email"] . '</p>
                                        </div>
                                    </div>
                                    <span class="badge rounded-pill badge-success">' . $row["membershipType"] . '</span>
                                    <button type="button" class="btn btn-warning" onclick="openEditModal(' . $row["user_id"] . ', \'' . $row["fname"] . '\', \'' . $row["lname"] . '\', \'' . $row["email"] . '\', \'' . $row["membershipType"] . '\')">Edit</button>
                                    <form method="post">
                                        <input type="hidden" name="del_user_id" value="' . $row['user_id'] . '">
                                        <button type="submit" class="btn btn-danger" id="btn-delete" name="btn-delete" onclick="return confirm(\'Are you sure you want to delete this user?\')">Delete</button>
                                    </form>
                                </li>';
                                }
                            }
                        }
                        $conn->close();
                    }

                    //inform success of fail
                    if ($success) {
                        echo "<script>alert('Generation Success');</script>";
                    } else {
                        echo "<script>alert('$errorMsg');</script>";
                    }

                    if (array_key_exists('btn-delete', $_POST)) {
                        deleteFromDB();
                    }

                    function deleteFromDB()
                    {
                        $userId = $_POST["del_user_id"];
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
                                $stmt = $conn->prepare("DELETE FROM user WHERE (user_id = ?);");

                                // Bind & execute the query statement:
                                $stmt->bind_param("i", $userId);
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
                        function openEditModal(userId, fname, lname, email, membershipType) {
                            // Set the book ID in the modal input field
                            document.getElementById('userIdInput').value = userId;

                            // Populate the modal fields with the retrieved data
                            document.getElementById('edit-field-fname').value = fname;
                            document.getElementById('edit-field-lname').value = lname;
                            document.getElementById('edit-field-email').value = email;
                            document.getElementById('edit-field-membershipType').value = membershipType;


                            // Show the modal
                            $('#editModal').modal('show');
                        }
                    </script>
                </ul>
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
                            <input type="hidden" class="form-control" id="userIdInput" name="userIdInput">
                            <div class="form-group">
                                <label for="edit-field-fname" class="col-form-label">First Name:</label>
                                <input type="text" class="form-control" id="edit-field-fname" name="edit-field-fname">
                            </div>
                            <div class="form-group">
                                <label for="edit-field-lname" class="col-form-label">Last Name:</label>
                                <input type="text" class="form-control" id="edit-field-lname" name="edit-field-lname"></input>
                            </div>
                            <div class="form-group">
                                <label for="edit-field-email" class="col-form-label">Email:</label>
                                <input type="email" class="form-control" id="edit-field-email" name="edit-field-email"></input>
                            </div>
                            <div class="form-group">
                                <label for="edit-field-membershipType" class="col-form-label">Membership Type:</label>
                                <select class="form-control" id="edit-field-membershipType" name="edit-field-membershipType">
                                    <option value="Free">Free</option>
                                    <option value="Regular">Regular</option>
                                    <option value="Premium">Premium</option>
                                </select>
                                <!-- <input type="text" class="form-control" id="edit-field-membershipType" name="edit-field-membershipType"></input> -->
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
            $userId = $_POST["userIdInput"];

            $fname = $errorMsg = "";
            $lname = $errorMsg = "";
            $email = $errorMsg = "";
            $membershipType = $errorMsg = "";
            $success = true;

            //Validate fields
            if (empty($_POST["edit-field-lname"])) {
                $errorMsg .= "Last name is required.\\n";
                $success = false;
            } else {
                $fname = sanitize_input($_POST["edit-field-fname"]);
                $lname = sanitize_input($_POST["edit-field-lname"]);
            }

            if (empty($_POST["edit-field-email"])) {
                $errorMsg .= "Email is required.\\n";
                $success = false;
            } else {
                $email = sanitize_input($_POST["edit-field-email"]);
            }

            if (empty($_POST["edit-field-membershipType"])) {
                $errorMsg .= "Membership type is required.\\n";
                $success = false;
            } else {
                $membershipType = sanitize_input($_POST["edit-field-membershipType"]);
            }


            //If success 
            if ($success) {
                updateUserInDB($userId, $fname, $lname, $email, $membershipType);
            } else {
                echo "<script>alert('$errorMsg');</script>";
            }
        }

        function updateUserInDB($userId, $fname, $lname, $email, $membershipType)
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
                    $stmt = $conn->prepare("UPDATE user SET fname = ?, lname = ?, email = ?, membershipType = ? WHERE (user_id = ?);");

                    // Bind & execute the query statement:
                    $stmt->bind_param("ssssi", $fname, $lname, $email, $membershipType, $userId);
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

        function sanitize_input($data)
        {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }
        ?>


    </main>

    <?php
    include "inc/footer.inc.php";
    ?>
</body>

</html>