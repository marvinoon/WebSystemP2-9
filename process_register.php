<!DOCTYPE html>
<html lang="en">
    <head>
        <?php 
            include "inc/head.inc.php";
        ?>
    </head>
    <body>
        <?php 
            include "inc/nav.inc.php";
        ?>
        <?php
            $fname = $errorMsg = "";
            $lname = $errorMsg = "";
            $email = $errorMsg = "";
            $pwd = $errorMsg = "";
            $success = true;

            //validate name
            if (empty($_POST["lname"]))
            {
                $errorMsg .= "Last name is required.<br>";
                $success = false;
            }
            else
            {
                $fname = sanitize_input($_POST["fname"]);
                $lname = sanitize_input($_POST["lname"]);
            }

            //validate email
            if (empty($_POST["email"]))
            {
                $errorMsg .= "Email is required.<br>";
                $success = false;
            }
            else
            {
                $email = sanitize_input($_POST["email"]);

                // Additional check to make sure e-mail address is well-formed.
                if (!filter_var($email, FILTER_VALIDATE_EMAIL))
                {
                    $errorMsg .= "Invalid email format.";
                    $success = false;
                }
            }

            //validate password
            if (empty($_POST["pwd"]))
            {
                $errorMsg .= "Password is required.<br>";
                $success = false;
            }
            else
            {
                if($_POST["pwd"] != $_POST["pwd_confirm"])
                {
                    $errorMsg .= "Passwords do not match";
                    $success = false;
                }else{
                    $pwd = password_hash($_POST["pwd"],PASSWORD_DEFAULT);
                }
            }

            //validate checkbox
            if (empty($_POST["agree"]))
            {
                $errorMsg .= "Please agree to our terms and conditions.<br>";
                $success = false;
            }

            //display user inputs
            if ($success)
            {
                echo "<h4>Registration successful!</h4>";
                echo "<p>Name: " . $fname . " " . $lname;
                echo "<p>Email: " . $email;
                echo "<p>Password hash: " . $pwd;
            }
            else
            {
                echo "<h4>The following input errors were detected:</h4>";
                echo "<p>" . $errorMsg . "</p>";
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
        ?>
    </body>

