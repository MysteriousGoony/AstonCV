<!DOCTYPE html>
<?php 
session_start();
require "db.php";

$error = "";

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"]);
    $password = $_POST["password"];

    if (!$email || !$password) {
        $error = "All input fields are required";
    } else {
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user["password"])) {
            $_SESSION["user_id"] = $user["id"];
            $_SESSION["username"] = $user["username"];
            $_SESSION["login_successful_message"] = "Welcome Back          " . $_SESSION["username"] ."!";
            header("Location: index.php");
            exit;
        } else {
            $error = "Invalid email or password. Try Again";
        }
    }
}
?>


<html lang="en">
    <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="with=device-width, initial-scale=1">
      <title>Login</title>  
      <meta name="title" content="Login(Aston CV)">
      <meta name="description" content="Page to login, at AstonCV website">
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
        <div class="login-title">
            <a href="index.php">Aston<strong>CV</strong></a>
        </div>
      <div class="form-pos">
        <form method="POST">
            <h2>Welcome Back</h2>
            <input name="email" type="email" placeholder="Email" class="input-box" required><br>
            <input name="password" type="password" placeholder="Password" class="input-box" required><br><br>
            <button class="form-submit-button" type="submit">Login</button>
            <a href="register.php" class="already_have_acc">Dont have an Account. Click here</a>
            <p class="login-error" style="color:red; margin: 25px; "><?= $error ?></p>
             <!-- Redirect message to login, if user with guest account tries to access ProfileCV -->
        <?php
        if (isset($_GET['msg'])) {
            echo "<p style='margin: 0; font-weight: medium;' >" . htmlspecialchars($_GET['msg']) . "</p>";
        }?>
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