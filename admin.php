<!DOCTYPE html>
<html lang="en">

<head>
        <link rel="stylesheet" href="css/nav.css">
        <link rel="stylesheet" href="css/footer.css">
    <?php
    include "inc/head.inc.php";
    ?>
</head>

<body>
    <?php
    include "inc/nav.inc.php";
    ?>
    <div>
    </div>



    <main class="container">
        <section id="dogs">
            <h2>Please select what you wish to do:</h2>
            <div class="list-group">
                <a href="/admin_view_books.php" class="list-group-item list-group-item-action">View Book</a>
                <!-- <a href="/admin_add_book.php" class="list-group-item list-group-item-action">Add Books</a> -->
                <a href="/admin_view_users.php" class="list-group-item list-group-item-action">View Users</a>
            </div>
        </section>
    </main>
    <?php
    include "inc/footer.inc.php";
    ?>
</body>

</html>