<!DOCTYPE html>
<?php 
session_start();
require "db.php";
?>

<?php if(isset($_SESSION["login_successful_message"])): ?>
    <div id="login_message">
         <div class="progress_line"></div>
        <?php
        echo $_SESSION["login_successful_message"];
        unset($_SESSION["login_successful_message"]);
 ?>
  </div>
  <?php endif;?>

<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>AstonCV</title>
        <meta name="title" content="Aston CV">
        <meta name="description" content="A CV website that host all CV of programmers. It will show their expertise in a specific or multiple languages">
        <meta name="keyword" content="CV, expertise, skill, programmers, Show-your-work, CV-Portfolio, cv, AstonCV, purple">
        <meta name="author" content="AstonCV">
        <meta name="theme-color" content="TBD">
        <!---StyleSheets--> 
        <link rel="stylesheet" type="text/css" href="style.css">
        <link rel="stylesheet" type="text/css" href="responsive.css">
        <!---Favicons--> 
        <link rel="icon" type="image/x-icon" href="Favicons/favicon.ico" sizes="all">
        <link rel="icon" type="image/x-icon" href="Favicons/favicon-16x16.png" sizes="16x16">
        <link rel="icon" type="image/x-icon" href="Favicons/favicon-32x32.png" sizes="32x32">
        <!---Google Fonts--> 
        <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600;700&display=swap" rel="stylesheet">
        <!---Google Icons-->

    </head>
      

    <body>
        <header id="home">
            <div class="inner-content">
                <div class="header-title">
                    <a href="index.php">Aston<strong>CV</strong></a>
                </div>
                <div class="nav-links">
                    <a href="browseCV.php">Browse CV's</a>
                    <a href="pricing.php">Pricing</a>
                    <!-- Check if user session exists to display authenticated or guest navigation -->
                    <?php if (isset($_SESSION["user_id"])): ?>
                        <?php $account_color = '#6A1B6D';?>
                        <div class="account">
                            <div class="account-shape" onclick="toggleMenu()" style="background: <?= $account_color?>;">
                               <?=strtoupper($_SESSION["username"][0])?> 
                            </div>
                            <div class="nav-dropdown" id="DropDownMenu">
                                <div class="account_info">
                                    <strong><?= $_SESSION["username"]?></strong>
                                </div>
                                <hr>
                                <a href="ProfileCV.php">My CV</a> 
                                <a href="#">Settings</a>
                                <a href="logout.php">Logout</a>
                            </div>
                        </div>
                          <?php else:?>
                           <a href="register.php">Register</a>
                          <a href="login.php" class="box-model">Login</a>
                          <?php endif; ?>
                    </div>
               </div>
        </header>


        <section class="hero">
            <canvas id="linesCanvas"></canvas>
            <div class="hero-content">
                <div class="top-notification">
                    Now open - Post your CV for free 
                    <a href="register.php">Register free</a>
                </div>
                <h1 class="hero-title">
                    Find Programmers.<br><span>Get <span id="change">Discovered</span>.</span>
                </h1>
                <p class="hero-description">
                    The open CV database for programmers. <a href="browseCV.php">Browse</a>
                    profiles, Search for them, and post your own CV for completely
                    FREE.
                </p>
                <div class="hero-buttons">
                    <button class="btn-main">
                        <a href="browseCV.php">Browse CVs</a></button>
                    <button class="btn-main">
                        <a href="ProfileCV.php">Post your CV  →</a>
                    </button>
                </div>
                <div class="trusted-teams">
                    <div class="trusted-title">Trusted by teams of 100 to 1000+</div>
                    <div class="teams-logo-grid">
                        <img src="Images/Figma-logo-color.svg" class="team-logo-styling">
                        <img src="Images/cursor.avif" class="team-logo-styling">
                        <img src="Images/NVIDIA-logo.avif" class="team-logo-styling">
                        <img src="Images/OPENAI-black-wordmark-cropped.avif" class="team-logo-styling">
                        <img src="Images/ramp.avif" class="team-logo-styling">
                        <img src="Images/volvo.avif" class="team-logo-styling">
                    </div>
                </div>
            </div>
        </section>

        <section class="getting-started">
            <div class="section-title reveal">
                <h2>How <span> AstonCV </span> Works</h2>
            </div>
            <div class="vertical-line">
                <div class="timeline-progress"></div>
                <div class="box-left">
                    <div class="description reveal">
                    <h3>Create CV</h3>
                    <p>Sign Up, Login, and upload your CV in under 1 minute</p>
                </div>
             </div>
             <div class="box-right">
                <div class="description reveal">
                    <h3>Get discovered</h3>
                    <p>People and Companies browse and find your skills instantly</p>
                </div>
             </div>
             <div class="box-left">
                <div class="description reveal">
                    <h3>Find Oppurtunities</h3>
                    <p>Build connections that open doors</p>
                </div>
             </div>
            </div>
        </section>


         <section class="FAQ reveal">
            <div class="section-title">
             <h2 class="text-purple">FAQ</h2>
            </div>
          <div class="faq-container">
        <div class="faq-item">
        <div class="faq-question">
        <h3>Is AstonCV really free?</h3>
        <span>+</span>
      </div>
       <div class="faq-answer">
         <p>Yes, you can create and upload your CV completely free. However, there may be option for subscriptions to enhance your time on the website</p>
         </div>
       </div>
        <div class="faq-item">
        <div class="faq-question">
         <h3>How do companies find me?</h3>
         <span>+</span>
        </div>
       <div class="faq-answer">
       <p>Recruiters browse profiles will find you through AstonCV and contact you on your preferred contact.</p>
       </div>
       </div>
      <div class="faq-item">
      <div class="faq-question">
      <h3>Can I edit my CV later?</h3>
      <span>+</span>
      </div>
       <div class="faq-answer">
          <p>Yes, you can update your CV anytime after uploading. Just apply changes before leaving.</p>
         </div>
        </div>
      </div>
      <a class="link-to-faq" href="#">More FAQ</a>
    </section>


     <footer>
      <div class="footer-content">
        <h3>Aston<span>CV</span></h3>
        <p>The open CV platform for programmers.</p>
        <div class="footer-links">
            <a href="browseCV.php">Browse CVs</a>
            <a href="#">FAQ</a>
            <a href="#">Contact</a>
             <a href="pricing.php">Pricing</a>
        </div>
        <p class="footer-copy">© 2026 AstonCV</p>
    </div>
    </footer>












       
      <script src="script.js"></script>

    </body>



   
</html>

