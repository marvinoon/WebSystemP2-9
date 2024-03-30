<!DOCTYPE html>
<html lang="en">
<head>
        <link rel="stylesheet" href="css/membership.css">
        <?php
            include "inc/head.inc.php"
        ?>
    </head>
<body>
    <?php
        include "inc/nav.inc.php";
    ?>
    <header class="S2">
        <div class="heading">
            <h1 id="headline">Our Membership Plans!</h1>
        </div>
    </header>
    <main>
        <section class="membership-plans">
            <div class="container">
                <div class="row justify-content-center">
                    <!-- Free Tier -->
                    <div class="col-md-4">
                        <div class="plan-box">
                            <h3>Free Tier</h3>
                            <ul>
                                <li>Benefit 1</li>
                                <li>Benefit 2</li>
                                <li>More...</li>
                            </ul>
                            <a href="#" class="btn btn-primary">Sign Up Now</a>
                        </div>
                    </div>
                    <!-- Regular Tier -->
                    <div class="col-md-4">
                        <div class="plan-box">
                            <h3>Regular Tier</h3>
                            <ul>
                                <li>Benefit 1</li>
                                <li>Benefit 2</li>
                                <li>More...</li>
                            </ul>
                            <a href="register.php" class="btn btn-primary">Sign Up Now</a>
                        </div>
                    </div>
                    <!-- Premium Tier -->
                    <div class="col-md-4">
                        <div class="plan-box">
                            <h3>Premium Tier</h3>
                            <ul>
                                <li>Benefit 1</li>
                                <li>Benefit 2</li>
                                <li>More...</li>
                            </ul>
                            <a href="#" class="btn btn-primary">Sign Up Now</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
    <?php
    include "inc/footer.inc.php";
    ?>
</body>
</html>