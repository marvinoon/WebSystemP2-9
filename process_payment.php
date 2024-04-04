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
    if (!preg_match("/^[a-zA-Z ]*$/", $name)) {
        $errorMsg .= "Name on card cannot contain special characters.<br>";
        $success = false;
    }
    
}

// Card Number
if (empty($_POST["card_number"])) {
    $errorMsg .= "Card number is required.<br>";
    $success = false;
} else {
    $card = sanitize_input($_POST["card_number"]);
    if (!preg_match('/^\d{16}$/', $card)) {
        $errorMsg .= "Card number must be a 16-digit number.<br>";
        $success = false;
    }
}

// Expiration Month
if (empty($_POST["exp_month"])) {
    $errorMsg .= "Expiration month is required.<br>";
    $success = false;
} else {
    $expirymth = sanitize_input($_POST["exp_month"]);
    // Additional validation: Check if the expiration month is in the correct format
    if (!preg_match('/^\d{2}$/', $expirymth)) {
        $errorMsg .= "Expiration month must be in the format MM.<br>";
        $success = false;
    } elseif ($expirymth < 1 || $expirymth > 12) {
        $errorMsg .= "Expiration month must be a valid month (1-12).<br>";
        $success = false;
    }

}

// Expiration Year
if (empty($_POST["exp_year"])) {
    $errorMsg .= "Expiration year is required.<br>";
    $success = false;
} else {
    $expiryyear = sanitize_input($_POST["exp_year"]);
    // Additional validation: Check if the expiration year is in the past
    $currentYear = date("Y"); // Get the current year

    if (!preg_match('/^\d{2}$/', $expiryyear)) {
        $errorMsg .= "Expiration year must be in the format YY.<br>";
        $success = false;
    }
}
//check if card is expired
// Expiration Month and Year
if (empty($_POST["exp_month"]) || empty($_POST["exp_year"])) {
    $errorMsg .= "Expiration month and year are required.<br>";
    $success = false;
} else {
    $expirymth = sanitize_input($_POST["exp_month"]);
    $expiryyear = sanitize_input($_POST["exp_year"]);

    // Extract only the first two characters as the month
    $expirymth = substr($expirymth, 0, 2);

    // Extract only the first four characters as the year
    $expiryyear = substr($expiryyear, 0, 4);

    // Additional validation: Check if the expiration month and year are in the correct format
    if (!preg_match('/^\d{2}$/', $expirymth) || !preg_match('/^\d{4}$/', $expiryyear)) {
        $errorMsg .= "Expiration month and year must be in the format MM/YYYY.<br>";
        $success = false;
    } else {
        // Convert the expiration month and year to a DateTime object
        $expiryDate = DateTime::createFromFormat('Y-m', $expiryyear . '-' . $expirymth);

        // Get the current date
        $currentDate = new DateTime();

        // Additional validation: Check if the expiration date is in the past
        if ($expiryDate < $currentDate) {
            $errorMsg .= "Expiration date cannot be in the past.<br>";
            $success = false;
        }
    }
    // Additional validation if needed
}

// CVV
if (empty($_POST["cvv"])) {
    $errorMsg .= "CVV is required.<br>";
    $success = false;
} else {
    $cvv = sanitize_input($_POST["cvv"]);
    // Additional validation: Check if CVV consists of exactly three digits
    if (!preg_match('/^\d{3}$/', $cvv)) {
        $errorMsg .= "CVV must be a 3-digit number.<br>";
        $success = false;}
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
        // Dynamically set the URL based on membership type
    $paymentPage = "payment_" . strtolower($membership_type) . ".php";
    echo '<div class="mb-4" style="margin-top: 10px;">';
    echo '<a href="' . $paymentPage . '">';
    echo '<button id="returnLoginBtn" class="btn btn-primary">Return to Payment</button>';
    echo '</a>';
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
<script>
    function goBack() {
        window.history.back();
    }
</script>