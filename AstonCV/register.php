<!DOCTYPE html>

<?php 
session_start();
require "db.php";

$errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = trim($_POST["username"]);
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);
    $confirm = trim($_POST["confirm_password"]);

    // validating each input 
    if (!$username || !$email || !$password || !$confirm) {
        $errors[] = "All input fields are required";
    }

    if ($password != $confirm) {
        $errors[] = "Passwords do not match"; 
    }

    if (strlen($username) > 50) {
        $errors[] = "Username too long (max 50 characters)";
    }

    if (strlen($password) < 6) {
        $errors[] = "Password too short (minimum 6 characters)";
    }

    $email = filter_var($email, FILTER_VALIDATE_EMAIL);
    if (!$email) {
        $errors[] = "Invalid email format";
    }


    if (empty($errors)) {

        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$email]);

        if ($stmt->rowCount() > 0) {
            $errors[] = "Email already exists";
        } else {
            // hash password and insert into db 
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
            if ($stmt->execute([$username, $email, $hashedPassword])) {
                header("Location: login.php");
                exit;
            } else {
                $errors[] = "Something went wrong, please try again";
            }
        }
    }
}
?>


<html lang="en">
    <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="with=device-width, initial-scale=1">
      <title>Register</title>  
      <meta name="title" content="Register (Aston CV)">
      <meta name="description" content="Page for registering in AstonCV">
       <!---StyleSheets--> 
        <link rel="stylesheet" type="text/css" href="style.css">
        <link rel="stylesheet" type="text/css" href="responsive.css">
        <!---Favicons--> 
        <link rel="icon" type="image/x-icon" href="Favicons/favicon.ico" sizes="all">
        <link rel="icon" type="image/x-icon" href="Favicons/favicon-16x16.png" sizes="16x16">
        <link rel="icon" type="image/x-icon" href="Favicons/favicon-32x32.png" sizes="32x32">
        <!---Google Fonts--> 
        <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600;700&display=swap" rel="stylesheet">
    </head> 

    <body>
        <div class="register-title">
            <a href="index.php">Aston<strong>CV</strong></a>
        </div>
        <div class="form-pos">
            <form method="POST">
                <h2>Create Account</h2>
                <input type="text" name="username" placeholder="Username*" class="input-box"><br><br>
                <input type="email" name="email" placeholder="Email*" class="input-box"><br><br>
                <input type="password" name="password" placeholder="Password*" class="input-box"><br><br>
                <input type="password" name="confirm_password" placeholder="Confirm Password*" class="input-box"><br><br>
                <button class="form-submit-button" type="sumbit">Register Now</button>
               <a href="login.php" class="already_have_acc">Already have an account.</strong> Click here</strong></a>
                <?php if (!empty($errors)): ?>
                <div class="error-box">
                    <ul>
                        <?php foreach ($errors as $err): ?>
                        <li><?php echo $err; ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <?php endif; ?>
            </form>
        </div>


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
        
    </body>
