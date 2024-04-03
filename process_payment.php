<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
$name = $card = $expirymth = $expiryyear = $cvv =  "";
$success = true;

// Name
if (empty($_POST["name_on_card"])) {
    $errorMsg .= "Name on card is required.<br>";
    $success = false;
} else {
    $name = sanitize_input($_POST["name_on_card"]);
    // Additional validation if needed
}

// Card Number
if (empty($_POST["card_number"])) {
    $errorMsg .= "Card number is required.<br>";
    $success = false;
} else {
    $card = sanitize_input($_POST["card_number"]);
    // Additional validation if needed
}

// Expiration Month
if (empty($_POST["exp_month"])) {
    $errorMsg .= "Expiration month is required.<br>";
    $success = false;
} else {
    $expirymth = sanitize_input($_POST["exp_month"]);
    // Additional validation if needed
}

// Expiration Year
if (empty($_POST["exp_year"])) {
    $errorMsg .= "Expiration year is required.<br>";
    $success = false;
} else {
    $expiryyear = sanitize_input($_POST["exp_year"]);
    // Additional validation if needed
}

// CVV
if (empty($_POST["cvv"])) {
    $errorMsg .= "CVV is required.<br>";
    $success = false;
} else {
    $cvv = sanitize_input($_POST["cvv"]);
    // Additional validation if needed
}

// Email
if (empty($_POST["email"])) {
    $errorMsg .= "Email is required.<br>";
    $success = false;
} else {
    $email = sanitize_input($_POST["email"]);
    // Additional validation if needed
}
// Retrieve membership type from the form
$membership_type = isset($_POST['membership_type']) ? $_POST['membership_type'] : '';
// Retrieve user ID based on email
$user_id = getUserIDFromEmail($email);

if ($user_id !== false) {
    // If user ID is retrieved successfully, proceed to save payment details
    if ($success) {
        savePaymentToDB($user_id, $name, $card, $expirymth, $expiryyear, $cvv, $membership_type);
        echo "<h4>Registration successful!</h4>";
        header("Location: index.php");
            exit();
    } else {
        echo '<div style="text-align: center;">';
        echo "<h1 style='color: red;'>Uh Oh</h1>";
        echo '<h4>The following input errors were detected:</h4>';
        echo '<p>' . $errorMsg . '</p>';
        echo '</div>';
    }
} else {
    echo "<p>Failed to retrieve user ID for the provided email.</p>";
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


function savePaymentToDB($user_id, $name, $card, $expirymth, $expiryyear, $cvv, $membership_type)
{
    global $errorMsg, $success;

    // Create database connection.
    $config = parse_ini_file('/var/www/private/db-config.ini');
    if (!$config) {
        $errorMsg = "Failed to read database config file.";
        $success = false;
        return;
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
        return;
    }

   // Prepare the statement:
$stmt = $conn->prepare("INSERT INTO payment 
(user_id, name, card, expirymth, expiryyear, cvv, membership_type) VALUES (?, ?, ?, ?, ?, ?, ?)");

// Bind & execute the query statement:
$stmt->bind_param("isssiss", $user_id, $name, $card, $expirymth, $expiryyear, $cvv, $membership_type);

    if (!$stmt->execute()) {
        $errorMsg = "Execute failed: (" . $stmt->errno . ") " .
            $stmt->error;
        $success = false;
    }
    $stmt->close();
    $conn->close();
}

// Helper function to check if email exists and retrieve user ID
function getUserIDFromEmail($email)
{
    // Create database connection (assuming db connection setup elsewhere in your code)
    $config = parse_ini_file('/var/www/private/db-config.ini');
    if (!$config) {
        return false; // Return false if unable to read config file
    }

    $conn = new mysqli(
        $config['servername'],
        $config['username'],
        $config['password'],
        $config['dbname']
    );

    if ($conn->connect_error) {
        return false; // Return false if unable to connect to database
    }

    // Prepare and execute query to select user ID based on email
    $stmt = $conn->prepare("SELECT user_id FROM user WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if email exists
    if ($result->num_rows > 0) {
        // Fetch user ID
        $row = $result->fetch_assoc();
        $user_id = $row['user_id'];
    } else {
        // Return false if email does not exist
        $user_id = false;
    }

    $stmt->close();
    $conn->close();

    return $user_id;
}
?>
