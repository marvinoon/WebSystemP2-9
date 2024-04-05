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
    <main>
    <?php
        include "inc/nav.inc.php";
    ?>
    <?php
    include_once "db_connect.php";
        $email = $errorMsg = $fname = $lname = $pwd_hashed = "";
        $success = true;
        // Initialize error message variable
        $errorMsg = "";
        // Retrieve the user ID from the session
        $user_id = $_SESSION['user_id'];
       //first name
        $fname = sanitize_input($_POST["fname"]);
        if (!preg_match("/^[a-zA-Z ]*$/", $fname)) {
            $errorMsg .= "First name cannot contain special characters.<br>";
            $success = false;
        }

        // Sanitize and validate first name if provided
    if (!empty($_POST["fname"])) {
        $fname = sanitize_input($_POST["fname"]);
        if (!preg_match("/^[a-zA-Z ]*$/", $fname)) {
            $errorMsg .= "First name cannot contain special characters.<br>";
            $success = false;
        }
    }

    // Sanitize and validate last name if provided
    if (!empty($_POST["lname"])) {
        $lname = sanitize_input($_POST["lname"]);
        if (!preg_match("/^[a-zA-Z ]*$/", $lname)) {
            $errorMsg .= "Last name cannot contain special characters.<br>";
            $success = false;
        }
    }

    // Validate email if provided
    if (!empty($_POST["email"])) {
        $email = sanitize_input($_POST["email"]);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errorMsg .= "Invalid email format.";
            $success = false;
        } else {
            if (emailExists($email)) {
                $errorMsg .= "Email already exists.";
                $success = false;
            }
        }
    }

     // Password verification
    if (empty($_POST["pwd_old"])) {
        $errorMsg .= "Old password is required.<br>";
        $success = false;
    } else {
        // Sanitize and validate old password if provided
        $pwd_old = sanitize_input($_POST["pwd_old"]);

        // Verify the old password
        if (!verifyOldPassword($pwd_old,$user_id, $link)) {
            $errorMsg .= "Old password is incorrect.<br>";
            $success = false;
        }
    }

    // Validate password if provided
if (!empty($_POST["pwd"])) {
    if (empty($_POST["pwd_confirm"])) {
        $errorMsg .= "Password confirmation is required.<br>";
        $success = false;
    } elseif ($_POST["pwd"] != $_POST["pwd_confirm"]) {
        $errorMsg .= "Passwords do not match.<br>";
        $success = false;
    } elseif (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^a-zA-Z\d])[\w\d\W]{8,}$/', $_POST["pwd"])) {
        $errorMsg .= "Password must meet the following requirements:<br> Be at least 8 characters long <br>Contain at least one uppercase letter <br>Contain at least one lowercase letter <br>Contain at least one digit <br>Contain at least one special character <br>";
        $success = false;
    } else {
        $pwd_hashed = password_hash($_POST["pwd"], PASSWORD_DEFAULT);
    }
}
        
        if ($success)
        {
            updateMemberToDB($user_id, $link);
            echo "<h4>Update Profile Details Successful!</h4>";
            {echo "<p>Name: " . $fname . " " . $lname;
            echo "<p>Email: " . $email;}
        }
        else
        {
            echo '<div style="text-align: center;">';
            echo "<h1 style='color: red;'>Uh Oh</h1>";
            echo '<h2>The following input errors were detected:</h2>';
            echo '<p>' . $errorMsg . '</p>';
            echo '</div>';
            
            echo '<div class="mb-4 text-center" style="margin-top: 10px;">';
            echo '<button id="goBackBtn" class="btn btn-primary" onclick="goBack()">Go Back</button>';
            echo '</div>';

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

       
        // Function to verify the old password
function verifyOldPassword($pwd_old,$user_id, $link)
{
    global $email, $pwd_hashed, $errorMsg, $success;

    // Prepare the statement to fetch user details by user ID
    $stmt = $link->prepare("SELECT * FROM user WHERE user_id=?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Fetch user details
        $row = $result->fetch_assoc();
        $email = $row["email"];
        $pwd_hashed = $row["password"];

        // Check if the provided old password matches the hashed password in the database
        if (!password_verify($pwd_old, $pwd_hashed)) {
            // Close the statement and connection
            $stmt->close();
            // $link->close();
            return false;
        } else {
            // Close the statement and connection
            $stmt->close();
            // $link->close();
            return true;
        }
    } else {
        // Close the statement and connection
        $stmt->close();
        // $link->close();
        return false;
    }
    $link->close();
}


function updateMemberToDB($user_id, $link) {
    global $fname, $lname, $email, $pwd_hashed, $errorMsg, $success;
    
    
    // Initialize the update statement
    $updateStmt = "UPDATE user SET";
    $params = []; // Array  
    $types = "";  // String 
    
    // Check and append first name to the update statement if provided.
    if (!empty($fname)) {
        $updateStmt .= " fname = ?,";
        $params[] = $fname;
        $types .= "s";
    }
    
    // last name 
    if (!empty($lname)) {
        $updateStmt .= " lname = ?,";
        $params[] = $lname;
        $types .= "s";
    }
    
    // email 
    if (!empty($email)) {
        $updateStmt .= " email = ?,";
        $params[] = $email;
        $types .= "s";
    }
    
    //  hashed password 
    if (!empty($pwd_hashed)) {
        $updateStmt .= " password = ?,";
        $params[] = $pwd_hashed;
        $types .= "s";
    }
    
    // Remove the comma and append the WHERE clause.
    $updateStmt = rtrim($updateStmt, ",") . " WHERE user_id = ?";
    $params[] = $user_id;
    $types .= "i";
    $stmt = $link->prepare($updateStmt);
    $stmt->bind_param($types, ...$params);
    if (!$stmt->execute()) {
        $errorMsg = "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
        $success = false;
    }
    $stmt->close();
    $link->close();
}

        ?>
        <script>
    function goBack() {
        window.history.back();
    }
</script>
</main>
</body>
</html>