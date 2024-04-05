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
    <main>
    <?php
        $email = $errorMsg = $fname = $lname = $pwd_hashed = "";
        $success = true;
        
       //first name
        $fname = sanitize_input($_POST["fname"]);
        if (!preg_match("/^[a-zA-Z ]*$/", $fname)) {
            $errorMsg .= "First name cannot contain special characters.<br>";
            $success = false;
        }

        //last name
        if (empty($_POST["lname"]))
        {
            $errorMsg .= "Last name is required.<br>";
            $success = false;
        }
        else
        {
            $lname = sanitize_input($_POST["lname"]);
            if (!preg_match("/^[a-zA-Z ]*$/", $lname)) {
                $errorMsg .= "Last name cannot contain special characters.<br>";
                $success = false;
            }
        }

        //email
        if (empty($_POST["email"]))
        {
            $errorMsg .= "Email is required.<br>";
            $success = false;
        }
        else
        {
            $email = sanitize_input($_POST["email"]);
            if (!filter_var($email, FILTER_VALIDATE_EMAIL))
                {
                    $errorMsg .= "Invalid email format.";
                    $success = false;
                }else{
                    if (emailExists($email)) {
                        $errorMsg .= "Email already exists.";
                        $success = false;
                    }
                }
        }

        //password
        if (empty($_POST["pwd"]))
        {
            $errorMsg .= "Password is required.<br>";
            $success = false;
        }else if (empty($_POST["pwd_confirm"]))
        {
            $errorMsg .= "Password confirmation is required.<br>";
            $success = false;
        }
        else if ($_POST["pwd"] != $_POST["pwd_confirm"])
        {
            $errorMsg .= "Passwords do not match.<br>";
            $success = false;
        }
        else if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^a-zA-Z\d])[\w\d\W]{8,}$/', $_POST["pwd"])) {
            $errorMsg .= "Password must meet the following requirements:<br> Be at least 8 characters long <br>Contain at least one uppercase letter <br>Contain at least one lowercase letter <br>Contain at least one digit <br>Contain at least one special character <br>";
            $success = false;
        }
        else
        {
            $pwd_hashed = password_hash($_POST["pwd"], PASSWORD_DEFAULT);
        }

        //membership type
        if (empty($_POST["membershipType"]))
        {
            $errorMsg .= "Membership type is required.<br>";
            $success = false;
        }
        else
        {
            $membershipType = $_POST["membershipType"];
        }
        
        
        if ($success)
        {
            saveMemberToDB();
            echo "<h4>Registration successful!</h4>";
            //add if statement if membership == Regular or ==Premium bring to payment_regular.php or payment_premium.php
            // Redirect to payment page based on membership type
            echo "$membershipType";
                if ($membershipType === "regular") {
                    header("Location: payment_regular.php");
                    exit(); // Ensure script execution stops after redirection
                } elseif ($membershipType === "premium") {
                    header("Location: payment_premium.php");
                    exit(); // Ensure script execution stops after redirection
                }
                elseif($membershipType === "free") {
            echo "<p>Name: " . $fname . " " . $lname;
            echo "<p>Email: " . $email;}
        }
        else
        {
            echo '<div style="text-align: center;">';
            echo "<h1 style='color: red;'>Uh Oh</h1>";
            echo '<h4>The following input errors were detected:</h4>';
            echo '<p>' . $errorMsg . '</p>';
            echo '</div>';

            echo '<div class="mb-4 text-center" style="margin-top: 10px;">
            <form action="loginregister.php" method="post">
            <button type="submit" class="btn btn-primary" name="returnToLogin">Return to Login</button>
            </form>
        </div>';
        }

        /*
        * Helper function that checks input for malicious or unwanted content.
        */
        function sanitize_input($data)
        {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }

       // Helper function to check if email already exists
        function emailExists($email) {
            // Create database connection (assuming db connection setup elsewhere in your code)
            $config = parse_ini_file('/var/www/private/db-config.ini');
            if (!$config) {
                return false; // Return false if unable to read config file
            }

            $conn = new mysqli(
                $config['servername'],
                $config['username'],
                $config['password'],
                $config['dbname']
            );
            
            if ($conn->connect_error) {
                return false; // Return false if unable to connect to database
            }

            $stmt = $conn->prepare("SELECT * FROM user WHERE email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();
            $stmt->close();
            $conn->close();

            return $result->num_rows > 0;
        }


        /*
        * Helper function to write the member data to the database.
        */
        function saveMemberToDB()
        { 
            global $fname, $lname, $email, $pwd_hashed, $membershipType, $errorMsg, $success;
            
            // Create database connection.
            $config = parse_ini_file('/var/www/private/db-config.ini');
            if (!$config)
            { 
                $errorMsg = "Failed to read database config file.";
                $success = false;
            } 
            else
            { 
                $conn = new mysqli(
                    $config['servername'],
                    $config['username'],
                    $config['password'],
                    $config['dbname']
                );

                // Check connection
                if ($conn->connect_error)
                { 
                    $errorMsg = "Connection failed: " . $conn->connect_error;
                    $success = false;
                } 
                else
                { 
                    // Prepare the statement:
                    $stmt = $conn->prepare("INSERT INTO user
                        (fname, lname, email, password, membershipType) VALUES (?, ?, ?, ?, ?)");

                    // Bind & execute the query statement:
                    $stmt->bind_param("sssss", $fname, $lname, $email, $pwd_hashed, $membershipType);
                    if (!$stmt->execute())
                    { 
                        $errorMsg = "Execute failed: (" . $stmt->errno . ") " .
                            $stmt->error;
                        $success = false;
                    } 
                    $stmt->close();
                } 

                $conn->close();
                } 
            }
        
        ?>
         <script>
    function goBack() {
        window.history.back();
    }
</script>
</main>
</body>