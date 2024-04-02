<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="css/membership.css">
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
                                <li>Preview select content from each book</li>
                                <li>Post and read community reviews</li>
                                <li>Monthly curated book selection</li>
                            </ul>
                            <a href="loginregister.php" class="btn btn-primary">Sign Up Now</a>
                        </div>
                    </div>
                    <!-- Regular Tier -->
                    <div class="col-md-4">
                        <div class="plan-box">
                            <h3>Regular Tier</h3>
                            <ul>
                                <li>Access to the full content of each book</li>
                                <li>Loan duration extended to 15 days</li>
                                <li>Maximum of 1 active book loan at a time</li>
                            </ul>
                            <a href="loginregister.php" class="btn btn-primary">Sign Up Now</a>
                        </div>
                    </div>
                    <!-- Premium Tier -->
                    <div class="col-md-4">
                        <div class="plan-box">
                            <h3>Premium Tier</h3>
                            <ul>
                                <li>All Regular Tier benefits, plus:</li>
                                <li>Extended loan duration of 30 days</li>
                                <li>Maximum of 5 active book loans simultaneously</li>
                                <li>Access to exclusive Premium-only book selections</li>
                            </ul>
                            <a href="loginregister.php" class="btn btn-primary">Sign Up Now</a>
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