<!DOCTYPE html>
<?php 
session_start();
// Prevent guests from accessing the CV page without an account.
// If they try to access it directly via the URL, they will be redirected
// to the log in page with instructions telling them to log in. 
$user_id = $_SESSION['user_id'] ?? null;
if (!$user_id) {
    header("Location: login.php?msg=Please+log+in+to+access+your+CV");
    exit;
}
require 'db.php'; 

$message = "";

//user pressing submit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $keyprogramming = $_POST['keyprogramming'] ?? '';
    $profile = $_POST['profile'] ?? '';
    $education = $_POST['education'] ?? '';
    // Handle three separate URL fields, one for git, linkedin, and like user website or something else.
    $URLlinks = $_POST['URLlinks'] ?? [];
    $URLlinks1 = $URLlinks[0] ?? '';
    $URLlinks2 = $URLlinks[1] ?? '';
    $URLlinks3 = $URLlinks[2] ?? '';


    //inserting into database 'astoncv' //also making sure they are no duplicated email, if it exist, then we update the existing CV 
    $sql = "INSERT INTO cvs (user_id, name, email, keyprogramming, profile, education, URLlinks1, URLlinks2, URLlinks3)
            VALUES (:user_id, :name, :email, :keyprogramming, :profile, :education, :URLlinks1, :URLlinks2, :URLlinks3)
            ON DUPLICATE KEY UPDATE 
            name=:name, keyprogramming=:keyprogramming, profile=:profile, education=:education, URLlinks1=:URLlinks1, URLlinks2=:URLlinks2, URLlinks3=:URLlinks3";

    $stmt = $conn->prepare($sql);
    $stmt->execute([
        ':user_id' => $user_id,
        ':name' => $name,
        ':email' => $email,
        ':keyprogramming' => $keyprogramming,
        ':profile' => $profile,
        ':education' => $education,
        ':URLlinks1' => $URLlinks1,
        ':URLlinks2' => $URLlinks2,
        ':URLlinks3' => $URLlinks3
    ]);

    //message on top of form when pressing save changes
    $message = "CV updated successfully!";
}

// Making sure that we fetch their previous record from DB so they dont have to input everything again. 
$stmt = $conn->prepare("SELECT name, email, keyprogramming, profile, education, URLlinks1, URLlinks2, URLlinks3 FROM cvs WHERE user_id = :user_id");
$stmt->execute([':user_id' => $user_id]);
$cv = $stmt->fetch(PDO::FETCH_ASSOC);
$name = $cv['name'] ?? '';
$email = $cv['email'] ?? '';
$keyprogramming = $cv['keyprogramming'] ?? '';
$profile = $cv['profile'] ?? '';
$education = $cv['education'] ?? '';
// Get three separate URLs
$URLlinks1 = $cv['URLlinks1'] ?? '';
$URLlinks2 = $cv['URLlinks2'] ?? '';
$URLlinks3 = $cv['URLlinks3'] ?? '';


$URLlinks_array = array_filter([$URLlinks1, $URLlinks2, $URLlinks3], function($url) { return !empty(trim($url)); });
//making sure one is empty always. always the best thing to do
if (empty($URLlinks_array)) {
    $URLlinks_array = ['', '', ''];
} else {
    // showing three url anuways. best practice
    while (count($URLlinks_array) < 3) {
        $URLlinks_array[] = '';
    }
}?>


<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Profile</title>
        <meta name="title" content="Profile">
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


      <body>
        <section class="profile-container">
            <div class="profile-header">
                <h2>Edit Your <strong class="text-purple">CV</strong></h2>
                <p>Enhance your CV and let your CV do the talking</p>
            </div>
            <form class="cv-form" method="post">
                <?php if($message): ?>
                    <div class="message success"><?php echo htmlspecialchars($message); ?></div>
                <?php endif; ?>
                <div class="form-group">
                    <label for="name">Full Name</label>
                    <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($name); ?>" required>
                </div>
                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required>
                </div>
                <div class="form-group">
                    <label for="keyprogramming">Main Programming Language  (most proficient)</label>
                    <input type="text" id="keyprogramming" name="keyprogramming" value="<?php echo htmlspecialchars($keyprogramming); ?>" placeholder="e.g., JavaScript, Python, C++, PHP.">
                </div>
                <div class="form-group">
                    <label for="profile">Summary Profile</label>
                    <textarea id="profile" name="profile" placeholder="Tell us about yourself, your experience, and what you're looking for..."><?php echo htmlspecialchars($profile); ?></textarea>
                </div>
                <div class="form-group">
                    <label for="education">Education</label>
                    <textarea id="education" name="education" placeholder="List your educational background, degrees, or optional information which will stand out to a company"><?php echo htmlspecialchars($education); ?></textarea>
                </div>
                 <!-- form group for seperate three links that can be added by the user.  -->
                <div class="form-group">
                    <label>Portfolio & Social Links</label>
                    <div id="urls-container">
                        <?php
                        $defaultUrlPlaceholders = [
                            'https://github.com/your-username',
                            'https://linkedin.com/in/your-name',
                            'https://your-portfolio.com'
                        ];
                        ?>
                        <?php foreach ($URLlinks_array as $index => $url): ?>
                            <div class="url-field-wrapper">
                                <?php $placeholder = $defaultUrlPlaceholders[$index] ?? 'https://your-link.com'; ?>
                                <input type="url" name="URLlinks[]" class="url-input" value="<?php echo htmlspecialchars($url); ?>" placeholder="<?php echo htmlspecialchars($placeholder); ?>">
                                <button type="button" class="btn-remove-url" onclick="removeUrlField(this)">X</button>
                            </div>
                        <?php endforeach; ?>
                    </div>
                     <!-- button disappears when there is more than 3 links -->
                    <button type="button" class="btn-add-url" onclick="addUrlField()" <?php echo count($URLlinks_array) >= 3 ? 'style="display:none;"' : ''; ?>>Add Social Link</button>
                </div>
                 <!-- Submit button for POST -->
                <button type="submit" class="cv-submit-btn">Save Changes</button>
            </form>
        </section>

        <footer>
            <div class="footer-content">
                <h3>Aston<span>CV</span></h3>
                <p>The open CV platform for programmers.</p>
                <div class="footer-links">
                    <a href="browseCV.php">Browse CVs</a>
                    <a href="#">FAQ</a>
                    <a href="#">Contact</a>
                </div>
                <p class="footer-copy">© 2026 AstonCV</p>
            </div>
        </footer>

    <script src="script.js"></script>
    </body>