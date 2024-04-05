<!DOCTYPE html>
<html lang="en">
    <head>
        <link rel="stylesheet" href="css/loginregister.css">
        <link rel="stylesheet" href="css/nav.css">
        <link rel="stylesheet" href="css/footer.css">
        <?php
            include "inc/head.inc.php";
            require_once "zebra_session/session_start.php";
        ?>
        <title>Login/Register</title>
    </head>
    <body>
        <?php
            include "inc/nav.inc.php";
        ?>
        <main>
        <div class="back-arrow">
            <a href="javascript:history.back()" aria-label="Go back">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
            </a>
        </div>
        <br>
        <br>       
            <div class="cont">
                <form class="form sign-in" action="process_login.php" method="post">
                    <h2>Welcome</h2>
                    <label>
                        <span>Email</span>
                        <input required maxlength="45" type="email" id="email" name="email" class="form-control">
                    </label>
                    <label>
                        <span>Password</span>
                        <input required type="password" id="pwd" name="pwd" class="form-control">
                    </label>
                    <p class="forgot-pass">Forgot password?</p>
                    <button type="submit" class="submit">Sign In</button>
                </form>
                <div class="sub-cont">
                    <div class="img">
                        <div class="img__text m--up">
                            <h3>Don't have an account? Please Sign up!</h3>
                        </div>
                        <div class="img__text m--in">
                            <h3>If you already have an account, just sign in.</h3>
                        </div>
                        <div class="img__btn">
                            <span class="m--up">Sign Up</span>
                            <span class="m--in">Sign In</span>
                        </div>
                    </div>
                    <form class="form sign-up" action="process_register.php" method="post">
                        <h2>Create your Account</h2>
                        <label>
                            <span>First Name</span>
                            <input maxlength="45" type="text" id="fname" name="fname" class="form-control">
                        </label>
                        <label>
                            <span>Last Name</span>
                            <input required maxlength="45" type="text" id="lname" name="lname" class="form-control">
                        </label>
                        <label>
                            <span>Email</span>
                            <input required maxlength="45" type="email" id="email" name="email" class="form-control">
                        </label>
                        <label>
                            <span>Select Membership Type</span>
                            <select name="membershipType" id="membershipType" class="form-select">
                                <option value="free">Free Tier</option>
                                <option value="regular">Regular Tier</option>
                                <option value="premium">Premium Tier</option>
                            </select>
                        </label>
                        <label>
                            <span>Password</span>
                            <input required type="password" id="pwd" name="pwd" class="form-control" minlength="8">
                        </label>
                        <label>
                            <span>Confirm Password</span>
                            <input required type="password" id="pwd_confirm" name="pwd_confirm" class="form-control" minlength ="8">
                        </label>
                        <button type="submit" class="submit">Sign Up</button>
                    </form>
                </div>
            </div>

            <script>
                document.querySelector('.img__btn').addEventListener('click', function() {
                    document.querySelector('.cont').classList.toggle('s--signup');
                });
            </script>
        <?php
        include "inc/footer.inc.php";
        ?>
        </main>
    </body>
</html>