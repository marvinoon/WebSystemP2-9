<!DOCTYPE html>
<html lang="en">
<head>
    <?php include "inc/head.inc.php"; ?>
    <link rel="stylesheet" href="css/nav.css">
    <link rel="stylesheet" href="css/footer.css">
</head>
<body>
    <?php include "inc/nav.inc.php"; ?>

    <main class="container">
    <?php
        session_start(); // Start the session

        // Unset all of the session variables
        $_SESSION = array();

        // Destroy the session
        session_destroy();
    ?>
        <h1>Logged Out</h1>
        <p>You have successfully logged out.</p>
        <p>
            Click here to register a new account
            <a href="loginregister.php">Member Registration page</a>.<br>
            Click here to log in again.
            <a href="loginregister.php">Login page</a>.<br>
            Click here to return to the home page.
            <a href="/">Home</a>.
        </p>
    </main>
</body>
</html>
