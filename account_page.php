<?php
    // Start the session to access session variables
    require_once "zebra_session/session_start.php";

    // Check if the user is logged in
    if (!isset($_SESSION['user_id'])) {
        // Redirect to the login page if not logged in
        header("Location: login.php");
        exit;
    }

    // Include necessary files
    include "inc/head.inc.php";
    include "inc/nav.inc.php";

    // Fetch user details from the database based on the user ID stored in the session
    $user_id = $_SESSION['user_id'];
    // Replace the following SQL query with your actual query to fetch user details
    $query = "SELECT * FROM users WHERE user_id = $user_id";
    // Execute the query and fetch the user data
    // Assuming $conn is your database connection variable
    $result = mysqli_query($conn, $query);
    $user = mysqli_fetch_assoc($result);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="css/aboutus.css">
    <link rel="stylesheet" href="css/nav.css">
    <link rel="stylesheet" href="css/footer.css">
</head>
<body>

<header>
    <h1>Welcome to Your Profile</h1>
</header>

<main>
    <section class="user-details">
        <h2>User Details</h2>
        <ul>
            <li><strong>First Name:</strong> <?php echo $user['fname']; ?></li>
            <li><strong>Last Name:</strong> <?php echo $user['lname']; ?></li>
            <li><strong>Email:</strong> <?php echo $user['email']; ?></li>
            <li><strong>Password:</strong> ********</li> <!-- Do not display password -->
            <li><strong>Membership Type:</strong> <?php echo $user['membershipType']; ?></li>
            <li><strong>Member Status:</strong> <?php echo $user['member_status']; ?></li>
            <li><strong>Expiry Date:</strong> <?php echo $user['expiry_date']; ?></li>
        </ul>
    </section>
</main>

<?php
include "inc/footer.inc.php";
?>

</body>
</html>