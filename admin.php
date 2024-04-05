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
    <!-- Only admin can view this page -->
    <?php
    if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
        //Redirect to the homepage or another page
        header('Location: index.php');
        exit();
    }
    ?>
    <div>
    </div>
    <main class="container">
        <section id="dogs">
            <h2 style="text-align: center;">Welcome Admin</h2>
            <h2 style="text-align: center;">Please select what you wish to do:</h2>
            <div class="list-group" style="padding-bottom: 25px;">
                <h4>Select to manage book entires</h4>
                <a href="/admin_view_books.php" class="list-group-item list-group-item-action">View Book</a>
                <h4>Select to manage users</h4>
                <a href="/admin_view_users.php" class="list-group-item list-group-item-action">View Users</a>
            </div>
        </section>
    </main>
    <?php
    include "inc/footer.inc.php";
    ?>
</body>

</html>