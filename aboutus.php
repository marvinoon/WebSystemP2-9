<!DOCTYPE html>
<html lang="en">
    <head>
        <!-- <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>About Us</title> -->
        <link rel="stylesheet" href="css/aboutus.css">
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
    <header>
        <h1>Welcome to Our eBook Subscription Service</h1>
    </header>

    <main>
        <section id="team" class="team">

            <!--  Section Title -->
            <div class="container section-title" data-aos="fade-up">
                <h2>Our Team</h2>
            </div><!-- End Section Title -->

            <div class="container">

                <div class="row gy-5">

                <div class="col-lg-4 col-md-6 member" data-aos="fade-up" data-aos-delay="100">
                    <div class="member-img">
                    <img src="images/usericon.jpeg" class="img-fluid" alt="">
                    <div class="social">
                        <a href="#"><i class="bi bi-twitter"></i></a>
                        <a href="#"><i class="bi bi-facebook"></i></a>
                        <a href="#"><i class="bi bi-instagram"></i></a>
                        <a href="#"><i class="bi bi-linkedin"></i></a>
                    </div>
                    </div>
                    <div class="member-info text-center">
                    <h3>Jonathan Goh Zhe Hong</h4>
                    <span>Backend Developer</span>
                    </div>
                </div><!-- End Team Member -->

                <div class="col-lg-4 col-md-6 member" data-aos="fade-up" data-aos-delay="200">
                    <div class="member-img">
                    <img src="images/usericon.jpeg" class="img-fluid" alt="">
                    <div class="social">
                        <a href="#"><i class="bi bi-twitter"></i></a>
                        <a href="#"><i class="bi bi-facebook"></i></a>
                        <a href="#"><i class="bi bi-instagram"></i></a>
                        <a href="#"><i class="bi bi-linkedin"></i></a>
                    </div>
                    </div>
                    <div class="member-info text-center">
                    <h4>Oon Jun Jie Marvin</h4>
                    <span>Backend Developer</span>
                    </div>
                </div><!-- End Team Member -->

                <div class="col-lg-4 col-md-6 member" data-aos="fade-up" data-aos-delay="300">
                    <div class="member-img">
                    <img src="images/usericon.jpeg" class="img-fluid" alt="">
                    <div class="social">
                        <a href="#"><i class="bi bi-twitter"></i></a>
                        <a href="#"><i class="bi bi-facebook"></i></a>
                        <a href="#"><i class="bi bi-instagram"></i></a>
                        <a href="#"><i class="bi bi-linkedin"></i></a>
                    </div>
                    </div>
                    <div class="member-info text-center">
                    <h4>Yeo Xin Ling Jocelyn</h4>
                    <span>Backend Developer</span>
                    </div>
                </div><!-- End Team Member -->

                <div class="col-lg-4 col-md-6 member" data-aos="fade-up" data-aos-delay="400">
                    <div class="member-img">
                    <img src="images/usericon.jpeg" class="img-fluid" alt="">
                    <div class="social">
                        <a href="#"><i class="bi bi-twitter"></i></a>
                        <a href="#"><i class="bi bi-facebook"></i></a>
                        <a href="#"><i class="bi bi-instagram"></i></a>
                        <a href="#"><i class="bi bi-linkedin"></i></a>
                    </div>
                    </div>
                    <div class="member-info text-center">
                    <h4>Noor Rifat</h4>
                    <span>Frontend Developer</span>
                    </div>
                </div><!-- End Team Member -->

                <div class="col-lg-4 col-md-6 member" data-aos="fade-up" data-aos-delay="500">
                    <div class="member-img">
                    <img src="images/usericon.jpeg" class="img-fluid" alt="">
                    <div class="social">
                        <a href="#"><i class="bi bi-twitter"></i></a>
                        <a href="#"><i class="bi bi-facebook"></i></a>
                        <a href="#"><i class="bi bi-instagram"></i></a>
                        <a href="#"><i class="bi bi-linkedin"></i></a>
                    </div>
                    </div>
                    <div class="member-info text-center">
                    <h4>Koh Tong Wei</h4>
                    <span>Frontend Developer</span>
                    </div>
                </div><!-- End Team Member -->

                </div>

            </div>

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
