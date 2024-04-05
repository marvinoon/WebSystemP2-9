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
    <?php include "inc/nav.inc.php"; ?>
    <div class="back-arrow">
        <a href="javascript:history.back()" aria-label="Go back">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
        </a>
    </div>
    <main>
        <div id="bookContainer" class="book">
            <div id="textContent" class="page"></div>

            <!-- MAIN CONTENT -->
            <form class="form sign-in" action="process_payment.php" method="post">
                <h1>Premium Membership Payment</h1>
                <input type="hidden" name="membership_type" value="Premium">
                <h3>$99.00/Year</h3>
                        <div class="form-group">
                        <label for="nameOnCard">Name on Card:</label>
                        <input maxlength="45" type="text" id="nameOnCard" name="name_on_card" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input maxlength="45" type="email" id="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="cardNumber">Card Number:</label>
                        <input max="16" type="number" id="cardNumber" name="card_number" required>
                    </div>

                    <div class="form-group">
                        <label for="expMonth">Expiration Month:</label>
                        <input max="2" type="number" id="expMonth" name="exp_month" required>
                    </div>

                    <div class="form-group">
                        <label for="expYear">Expiration Year:</label>
                        <input max="4" type="number" id="expYear" name="exp_year" required>
                    </div>

                    <div class="form-group">
                        <label for="cvv">CVV:</label>
                        <input max="3" type="number" id="cvv" name="cvv" required>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="payment-btn">Proceed to Payment</button>
                    </div>
                    
                </form>
            </div>
    </main>
    <?php include "inc/footer.inc.php"; ?>
</body>
</html>
