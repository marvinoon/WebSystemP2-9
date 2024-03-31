<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>About Us</title>
        <link rel="stylesheet" href="css/aboutus.css">
        <link rel="stylesheet" href="css/nav.css">
        <link rel="stylesheet" href="css/footer.css">
        <?php
            include "inc/head.inc.php"
        ?>
    </head>
    <body>
    <?php
        include "inc/nav.inc.php";
    ?>
    <header>
        <h1>Welcome to Our eBook Subscription Service</h1>
    </header>

    <main>
        <section class="description">
            <h2>Discover an Endless Library of Literary Treasures</h2>
            <p>At our eBook subscription service, we offer you unlimited access to a diverse collection of titles - from timeless classics to the latest bestsellers.</p>
        </section>

        <section class="features">
            <h2>What We Offer</h2>
            <ul>
                <li>
                    <strong>Unlimited Access:</strong>
                    <p>Enjoy as many books as you like, whenever you want.</p>
                </li>
                <li>
                    <strong>Curated Collections:</strong>
                    <p>Explore expertly curated collections to discover your next great read.</p>
                </li>
                <li>
                    <strong>New Titles Weekly:</strong>
                    <p>Our library is constantly updated, so you'll never run out of new adventures.</p>
                </li>
            </ul>
        </section>
        <section class="location">
            <h2>Our Location</h2>
            <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d15954.661612111953!2d103.848787!3d1.3774334!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31da16e96db0a1ab%3A0x3d0be54fbbd6e1cd!2sSingapore%20Institute%20of%20Technology%20(SIT%40NYP)!5e0!3m2!1sen!2ssg!4v1711877683423!5m2!1sen!2ssg" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </section>
    </main>
    <?php
    include "inc/footer.inc.php";
    ?>
    </body>
</html>
