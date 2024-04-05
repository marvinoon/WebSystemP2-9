<!DOCTYPE html>
<html lang="en">
<head>
    <?php include "inc/head.inc.php"; ?>
    <link rel="stylesheet" href="css/nav.css">
    <link rel="stylesheet" href="css/footer.css">
    <title>Logout</title>
</head>
<body>
    <?php include "inc/nav.inc.php"; 
    require_once "zebra_session/session_start.php";
    ?>

    <?php
    
        // Unset all of the session variables
        $_SESSION = array();

        // Destroy the session
        session_destroy();
        header("Location: index.php");
    ?>

</body>

