
<?php
    // Start the session to access session variables
    require_once "zebra_session/session_start.php";
    require_once "zebra_session/db_connect.php";
    // Check if the user is logged in
    if (!isset($_SESSION['user_id'])) {
        // Redirect to the login page if not logged in
        header("Location: loginregister.php");
        exit;
    }

    // Include necessary files
    include "inc/head.inc.php";
    include "inc/nav.inc.php";

    // Fetch user details from the database based on the user ID stored in the session
    $user_id = $_SESSION['user_id'];
    // Replace the following SQL query with your actual query to fetch user details
    $query = "SELECT * FROM user WHERE user_id = $user_id";
    // Execute the query and fetch the user data
    $result = mysqli_query($link, $query);
    $user = mysqli_fetch_assoc($result);
?>
<!DOCTYPE html>
<html lang="en">

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="css/aboutus.css">
    <link rel="stylesheet" href="css/nav.css">
    <link rel="stylesheet" href="css/footer.css">
</head>
<section>
            <h2>Profile Details</h2>
            <li><strong>First Name:</strong> <?php echo $user['fname']; ?></li>
            <li><strong>Last Name:</strong> <?php echo $user['lname']; ?></li>
            <li><strong>Email:</strong> <?php echo $user['email']; ?></li>
            <li><strong>Membership Type:</strong> <?php echo $user['membershipType']; ?></li>
            <?php 
        if ($user['membershipType'] == 'Free') {
            // Display upgrade buttons for free members
            echo '<button onclick="upgradeRegular()">Upgrade to Regular member</button>';
            echo '<button onclick="upgradePremium()">Upgrade to Premium member</button>';
        } elseif ($user['membershipType'] == 'Regular') {
            // Display upgrade button for regular members
            echo '<button onclick="upgradePremium()">Upgrade to Premium member</button>';
        }
        ?>
        </ul>
      <!-- Add Edit Profile Button -->
      <button id="editProfileBtn" class="btn btn-primary">Edit Profile</button>
      <!-- Delete Profile Button -->
<button id="deleteProfileBtn" class="btn btn-danger">Delete Profile</button>
    </section>
    <!-- Form for Editing Profile (Initially Hidden) -->
    <section id="editProfileForm" style="display: none;">
        <h2>Edit Profile</h2>
    <form action="process_update.php" method="post">
        <label for="fname">First Name:</label>
        <input type="text" id="fname" name="fname"><br><br>
        
        <label for="lname">Last Name:</label>
        <input type="text" id="lname" name="lname"><br><br>
        
        <label for="email">Email:</label>
        <input type="email" id="email" name="email"><br><br>
        
        <label for="pwd_old">Old Password*:</label>
        <input type="password" id="pwd_old" name="pwd_old"><br><br>
        
        <label for="pwd">New Password:</label>
        <input type="password" id="pwd" name="pwd"><br><br>
        
        <label for="pwd_confirm">Confirm Password:</label>
        <input type="password" id="pws_confirm" name="pwd_confirm"><br><br>
        <input type="submit" value="Submit">
    </form>
</section>
</main>

<?php
include "inc/footer.inc.php";
?>

<script>
    // Script to toggle display of the edit profile form
    document.getElementById('editProfileBtn').addEventListener('click', function() {
        document.getElementById('editProfileForm').style.display = 'block';
    });
    // Script to handle delete profile button click
    document.getElementById('deleteProfileBtn').addEventListener('click', function() {
        // Prompt the user for confirmation
        if (confirm("Are you sure you want to delete your profile?")) {
            // Redirect to delete script with user ID
            window.location.href = "delete_profile.php?user_id=<?php echo $_SESSION['user_id']; ?>";
        }
    });
    function upgradeRegular() {
            // Redirect to upgrade regular member page
            window.location.href = "payment_regular.php";
        }

        function upgradePremium() {
            // Redirect to upgrade premium member page
            window.location.href = "payment_premium.php";
        }
</script>
</main>
</body>
</html>