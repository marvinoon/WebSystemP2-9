<?php
    require_once "zebra_session/session_start.php";
    require_once "zebra_session/db_connect.php";

    // Check if user is logged in
    if (!isset($_SESSION['user_id'])) {
        header("Location: loginregister.php");
        exit;
    }

    // Check if user ID is  in the URL
    if (isset($_GET['user_id'])) {
        $user_id = intval($_GET['user_id']);

        // Delete user from database
        $delete_query = "DELETE FROM user WHERE user_id = ?";
        $stmt = $link->prepare($delete_query);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $stmt->close();

        // Log out user and redirect to login page
        session_destroy();
        header("Location: loginregister.php");
        exit;
    } else {
        // Redirect to profile page if user ID is not provided
        header("Location: account_page.php");
        exit;
    }
?>
