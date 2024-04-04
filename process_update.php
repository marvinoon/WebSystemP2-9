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
        if (!verifyOldPassword($pwd_old,$user_id)) {
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
            updateMemberToDB($user_id);
            echo "<h4>Registration successful!</h4>";
            //add if statement if membership == Regular or ==Premium bring to payment_regular.php or payment_premium.php
            // Redirect to payment page based on membership type
            {
            echo "<p>Name: " . $fname . " " . $lname;
            echo "<p>Email: " . $email;}
        }
        else
        {
            echo '<div style="text-align: center;">';
            echo "<h1 style='color: red;'>Uh Oh</h1>";
            echo '<h4>The following input errors were detected:</h4>';
            echo '<p>' . $errorMsg . '</p>';
            
            echo '<div class="mb-4" style="margin-top: 10px;">';
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
function verifyOldPassword($pwd_old,$user_id)
{error_reporting(E_ALL);
    ini_set('display_errors', 1);
    global $email, $pwd_hashed, $errorMsg, $success;

    

    // Create database connection.
    $config = parse_ini_file('/var/www/private/db-config.ini');
    if (!$config) {
        $errorMsg = "Failed to read database config file.";
        $success = false;
        return false;
    }

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
        return false;
    }

    // Prepare the statement to fetch user details by user ID
    $stmt = $conn->prepare("SELECT * FROM user WHERE user_id=?");
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
            $conn->close();
            return false;
        } else {
            // Close the statement and connection
            $stmt->close();
            $conn->close();
            return true;
        }
    } else {
        // Close the statement and connection
        $stmt->close();
        $conn->close();
        return false;
    }
}


        /*
        * Helper function to write the member data to the database.
        */
//         function updateMemberToDB($user_id)
//         { error_reporting(E_ALL);
//             ini_set('display_errors', 1);
//             global $fname, $lname, $email, $pwd_hashed, $errorMsg, $success;
            
//             // Create database connection.
//             $config = parse_ini_file('/var/www/private/db-config.ini');
//             if (!$config)
//             { 
//                 $errorMsg = "Failed to read database config file.";
//                 $success = false;
//             } 
//             else
//             { 
//                 $conn = new mysqli(
//                     $config['servername'],
//                     $config['username'],
//                     $config['password'],
//                     $config['dbname']
//                 );

//                 // Check connection
//                 if ($conn->connect_error)
//                 { 
//                     $errorMsg = "Connection failed: " . $conn->connect_error;
//                     $success = false;
//                 } 
//                 else
//                 { 
//                     // Prepare the base update statement:
//                     $updateStmt = "UPDATE user SET";

//                     // Initialize an array to store the parameters and their types:
//                     $params = array();
//                     $types = "";

//                     // Check if the first name field is not empty, and include it in the update statement:
//                     if (!empty($fname)) {
//                         $updateStmt .= " fname = ?,";
//                         $params[] = $fname;
//                         $types .= "s";
//                     }

//                     // Check if the last name field is not empty, and include it in the update statement:
//                     if (!empty($lname)) {
//                         $updateStmt .= " lname = ?,";
//                         $params[] = $lname;
//                         $types .= "s";
//                     }

//                     // Check if the email field is not empty, and include it in the update statement:
//                     if (!empty($email)) {
//                         $updateStmt .= " email = ?,";
//                         $params[] = $email;
//                         $types .= "s";
//                     }

//                     // Check if the password field is not empty, and include it in the update statement:
//                     if (!empty($pwd_hashed)) {
//                         $updateStmt .= " password = ?,";
//                         $params[] = $pwd_hashed;
//                         $types .= "s";
//                     }

//                     // Trim the trailing comma from the update statement:
//                     $updateStmt = rtrim($updateStmt, ",");

//                     // Add the WHERE clause:
//                     $updateStmt .= " WHERE user_id = ?";
// echo $updateStmt;
//                     // Add the user ID parameter and its type:
//                     $params[] = $user_id;
//                     $types .= "i";
//                     // Prepare the statement:
//                     $stmt = $conn->prepare($updateStmt);

//                     // Bind & execute the query statement:
//                     $stmt->bind_param("sssss", $fname, $lname, $email, $pwd_hashed);
//                     if (!$stmt->execute())
//                     { 
//                         $errorMsg = "Execute failed: (" . $stmt->errno . ") " .
//                             $stmt->error;
//                         $success = false;
//                     } 
//                     $stmt->close();
//                 } 

//                 $conn->close();
//                 } 
//             }
function updateMemberToDB($user_id) {
    global $fname, $lname, $email, $pwd_hashed, $errorMsg, $success;
    
    // Create database connection.
    $config = parse_ini_file('/var/www/private/db-config.ini');
    if (!$config) {
        $errorMsg = "Failed to read database config file.";
        $success = false;
        return;
    }
    
    $conn = new mysqli($config['servername'], $config['username'], $config['password'], $config['dbname']);
    if ($conn->connect_error) {
        $errorMsg = "Connection failed: " . $conn->connect_error;
        $success = false;
        return;
    }
    
    // Initialize the update statement.
    $updateStmt = "UPDATE user SET";
    $params = []; // Array to hold dynamic parameters
    $types = "";  // String to hold types of dynamic parameters
    
    // Check and append first name to the update statement if provided.
    if (!empty($fname)) {
        $updateStmt .= " fname = ?,";
        $params[] = $fname;
        $types .= "s";
    }
    
    // Check and append last name to the update statement if provided.
    if (!empty($lname)) {
        $updateStmt .= " lname = ?,";
        $params[] = $lname;
        $types .= "s";
    }
    
    // Check and append email to the update statement if provided.
    if (!empty($email)) {
        $updateStmt .= " email = ?,";
        $params[] = $email;
        $types .= "s";
    }
    
    // Check and append hashed password to the update statement if provided.
    if (!empty($pwd_hashed)) {
        $updateStmt .= " password = ?,";
        $params[] = $pwd_hashed;
        $types .= "s";
    }
    
    // Remove the trailing comma and append the WHERE clause.
    $updateStmt = rtrim($updateStmt, ",") . " WHERE user_id = ?";
    $params[] = $user_id;
    $types .= "i";
    
    // Prepare the statement.
    $stmt = $conn->prepare($updateStmt);
    
    // Dynamically bind parameters
    $stmt->bind_param($types, ...$params);
    
    // Execute the query statement.
    if (!$stmt->execute()) {
        $errorMsg = "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
        $success = false;
    }
    
    // Close the statement and connection.
    $stmt->close();
    $conn->close();
}

        ?>
        <script>
    function goBack() {
        window.history.back();
    }
</script>
</body>