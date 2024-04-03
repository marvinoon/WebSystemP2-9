<!DOCTYPE html>
<html lang="en">
<head>
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
    <?php

        $email = $errorMsg = "";
        $success = true;


        //email
        if (empty($_POST["email"]))
        {
            $errorMsg .= "Email is required.<br>";
            $success = false;
        }
        else
        {
            $email = sanitize_input($_POST["email"]);
            if (!filter_var($email, FILTER_VALIDATE_EMAIL))
                {
                    $errorMsg .= "Invalid email format.";
                    $success = false;
                }
        }

        //password
        if (empty($_POST["pwd"]))
        {
            $errorMsg .= "Password is required.<br>";
            $success = false;
        }


        if (!empty($_POST["email"]) && !empty($_POST["pwd"])) {
            checkAdmin();
        }
    
        if ($success)
        {
            $_SESSION['lname'] = $lname;
            header("Location: index.php");
            exit();
        }
        else
        {
            echo "<h4>The following errors were detected:</h4>";
            echo "<p>" . $errorMsg . "</p>";
            echo '<div class="mb-4" style="margin-top: 10px;"> <a href="loginregister.php"> <button id="returnLoginBtn" class="btn btn-primary">Return to Login</button> </a> </div>';
        }
        /*
        * Helper function that checks input for malicious or unwanted content.
        */
        function sanitize_input($data)
        {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }

        function checkAdmin()
        {
            global $admin_id, $fname, $lname, $email, $pwd_hashed, $errorMsg, $success;

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
                    // Prepare the statement to check if the user is an admin:
                    $stmt = $conn->prepare("SELECT * FROM admin WHERE email=?");
                    
                    // Bind & execute the query statement:
                    $stmt->bind_param("s", $email);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    if ($result->num_rows > 0)
                    {
                        // User is an admin, log in as admin.
                        $_SESSION['admin'] = true;

                        $row = $result->fetch_assoc();
                        $fname = $row["fname"];
                        $lname = $row["lname"];
                        $pwd_hashed = $row["password"];
                        $admin_id = $row["admin_id"];
                        
                        $_SESSION['admin_id'] = $admin_id;
                        $_SESSION['lname'] = $lname; 
                        header("Location: admin.php");
                        exit();
                    }
                    else
                    {
                        // User is not an admin, continue with normal login.
                        authenticateUser();
                    }
                    $stmt->close();
                }

                $conn->close();
            }
        }

        /*
        * Helper function to authenticate the login.
        */
        function authenticateUser()
        {
            global $fname, $lname, $email, $pwd_hashed, $errorMsg, $success;
        
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
                $stmt = $conn->prepare("SELECT * FROM user WHERE email=?");
                
                // Bind & execute the query statement:
                $stmt->bind_param("s", $email);
                $stmt->execute();
                $result = $stmt->get_result();
                if ($result->num_rows > 0)
                {
                    // Note that email field is unique, so should only have
                    // one row in the result set.
                    $row = $result->fetch_assoc();
                    $fname = $row["fname"];
                    $lname = $row["lname"];
                    $pwd_hashed = $row["password"];

                    $user_id = $row["user_id"];
                    $_SESSION['user_id'] = $user_id;
               
                    // Check if the password matches:
                    if (!password_verify($_POST["pwd"], $pwd_hashed))
                    {
                        // Don't be too specific with the error message - hackers don't
                        // need to know which one they got right or wrong. :)
                        $errorMsg = "Email not found or password doesn't match...";
                        $success = false;
                    }
                }
                else
                {
                    $errorMsg = "Email not found or password doesn't match...";
                    $success = false;
                }
                $stmt->close();
            }
        
            $conn->close();
        }
    }

        ?>
</body>