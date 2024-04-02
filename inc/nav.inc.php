<nav class="navbar navbar-expand-md navbar-custom navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#" >
                <img src="images/Logo.png" alt="Logo" style="height: 35px;">
            </a>
                        <!-- Toggler/collapsibe Button -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#collapsibleNavbar" aria-controls="collapsibleNavbar" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <!-- Navbar links -->
            <div class="collapse navbar-collapse" id="collapsibleNavbar">
                
                <ul class="navbar-nav nav-custom ms-auto">
    
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Home</a>
                    </li>
    
                    <li class="nav-item">
                        <a class="nav-link" href="aboutus.php">About Us</a>
                    </li>
    
                    <li class="nav-item">
                        <a class="nav-link" href="memberships.php">Memberships</a>
                    </li>
    
                    <!-- <li class="nav-item">
                        <a class="nav-link btn-custom" href="loginregister.php">Sign Up</a>
                    </li> -->

                    <?php 
                        session_start();
                        if (isset($_SESSION['email'])) {
                            echo '<li class="nav-item">
                                    <a class="nav-link btn-custom" href="logout.php">Logout</a>
                                </li>';
                        }
                        else {
                            echo '<li class="nav-item">
                                    <a class="nav-link btn-custom" href="loginregister.php">Login</a>
                                    </li>';
                        }
                    ?>
                </ul>
            </div>
        </div>  
    </nav>