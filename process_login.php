<!DOCTYPE html>
<html lang="en">
<head>
<link rel="stylesheet" href="css/nav.css">
<link rel="stylesheet" href="css/footer.css">
    <?php 
        include "inc/head.inc.php";
        require_once "zebra_session/session_start.php";
        include "db_connect.php"; // Change require_once to include
    ?>
</head>
<body>
    <?php
        include "inc/nav.inc.php";
    ?>
    <?php
        $email = $errorMsg = "";
        $success = true;
        $update_status_success = updateMemberStatus($user_id, $link);
        // Email
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

        // Password
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
            echo "<h1 style='color: red;'>Uh Oh</h1>";
            echo "<h1>The following errors were detected:</h1>";
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
            global $admin_id, $fname, $lname, $email, $pwd_hashed, $errorMsg, $success, $link;

            // Prepare the statement to check if the user is an admin:
            $stmt = $link->prepare("SELECT * FROM admin WHERE email=?");

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

        /*
        * Helper function to authenticate the login.
        */
        function authenticateUser()
{
    global $fname, $lname, $email, $pwd_hashed, $errorMsg, $success, $link;

    // Prepare the statement:
    $stmt = $link->prepare("SELECT * FROM user WHERE email=?");
    
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
        if (password_verify($_POST["pwd"], $pwd_hashed)) {
            // Password is correct, set session variables and redirect to the appropriate page
            $_SESSION['user_id'] = $user_id;
            header("Location: index.php"); // or any other desired page
            exit();
        } else {
            $errorMsg = "Email not found or password doesn't match...";
            $success = false;
        }
    } else {
        $errorMsg = "Email not found or password doesn't match...";
        $success = false;
    }
    
    $stmt->close();
}


        function updateMemberStatus($user_id, $conn) {
            // Prepare the SQL statement to update member_status based on expiry_date
            $sql = "UPDATE user SET member_status = CASE 
                        WHEN membershipType != 'Free' AND expiry_date < CURRENT_DATE THEN 'Expired' 
                        ELSE 'Active' 
                    END 
                    WHERE user_id = ?";
            
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $user_id);
            
            // Execute the query and check for success
            if ($stmt->execute()) {
                // Success, now check the updated status
                $stmt->close();
                $stmt = $conn->prepare("SELECT member_status FROM user WHERE user_id = ?");
                $stmt->bind_param("i", $user_id);
                $stmt->execute();
                $stmt->bind_result($member_status);
                $stmt->fetch();
                $stmt->close();
                return $member_status;
            } else {
                // Handle error
                $errorMsg = "Error updating member status: " . $stmt->error;
                $stmt->close();
                return false;
            }
        }
    ?>
</body>
</html>
