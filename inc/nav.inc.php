<?php
    require_once "zebra_session/session_start.php";
?>

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
                        <a class="nav-link" href="catalog.php">Catalog</a>
                    </li>
    
                    <li class="nav-item">
                        <a class="nav-link" href="aboutus.php">About Us</a>
                    </li>
    
                    <li class="nav-item">
                        <a class="nav-link" href="memberships.php">Memberships</a>
                    </li>


                    
                    <?php 
                        if (isset($_SESSION['user_id'])) { 
                            echo '<li class="nav-item">
                            <a class="nav-link btn-custom" href="books_borrowed.php">Books</a>
                          </li>
                          <li class="nav-item">
                            <a class="nav-link btn-custom" href="cart.php">Cart</a>
                          </li>
                            <li class="nav-item">
                                <a class="nav-link btn-custom" href="account_page.php">' . $_SESSION['lname'] . '</a>
                            </li>
                          <li class="nav-item">
                            <a class="nav-link btn-custom" href="logout.php">Logout</a>
                          </li>';
                        }
                        else if (isset($_SESSION['admin_id'])) {
                            echo '<li class="nav-item">
                            <span class="nav-link btn-custom">Welcome, ' . $_SESSION['lname'] . '</span>
                          </li>
                          <li class="nav-item">
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