<!DOCTYPE html>
<html lang="en">

<head>
        <link rel="stylesheet" href="css/membership.css">
        <link rel="stylesheet" href="css/nav.css">
        <link rel="stylesheet" href="css/footer.css">
        <?php
            include "inc/head.inc.php";
            require_once "zebra_session/session_start.php";
            // Check if the user is logged in
if (isset($_SESSION['user_id'])) {
    $loggedIn = true;
    // Retrieve membership type from session
    $membershipType = $_SESSION['membership_type'] ?? 'free';
} else {
    $loggedIn = false;
    // Default membership type for non-logged in users
    $membershipType = 'free';}
        ?>
    </head>
<body>
    <?php
    include "inc/nav.inc.php";
    ?>
    <div class="back-arrow">
        <a href="javascript:history.back()" aria-label="Go back">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                
        </a>
    </div>
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
                        <!-- Display button conditionally -->
                        <?php if (!$loggedIn): ?>
                            <a href="loginregister.php" class="btn btn-primary">Sign Up Now</a>
                        <?php endif; ?>
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
                        <!-- Change button text based on membership type -->
                        <?php if ($loggedIn && $membershipType !== 'Regular'): ?>
                            <a href="payment_regular.php" class="btn btn-primary">Upgrade to Regular Tier</a>
                        <?php elseif (!$loggedIn): ?>
                            <a href="loginregister.php" class="btn btn-primary">Sign Up Now</a>
                        <?php endif; ?>
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
                        <!-- Change button text based on membership type -->
                        <?php if ($loggedIn && $membershipType !== 'Premium'): ?>
                            <a href="payment_premium.php" class="btn btn-primary">Upgrade to Premium Tier</a>
                        <?php elseif (!$loggedIn): ?>
                            <a href="loginregister.php" class="btn btn-primary">Sign Up Now</a>
                        <?php endif; ?>
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