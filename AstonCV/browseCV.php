<!DOCTYPE html>
<?php
session_start();
require 'db.php';
//this is the function to safely output texts. Makes sure there is no XSS attacks
function e($value) {
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}
//get search queery from URL
//if this is not sett then we default the string to 0
$q = trim($_GET['q'] ?? '');

//get CV ID to view
$viewId = isset($_GET['view']) ? intval($_GET['view']) : 0;
//search function from web to db 
$query = "SELECT * FROM cvs";
$params = [];
if ($q !== '') {
    //search by programming language or name
    $query .= " WHERE name LIKE :q OR keyprogramming LIKE :q";
    //parameter to make sure no going beyong scope
    $params[':q'] = "%{$q}%";}

$query .= " ORDER BY id DESC";
$stmt = $conn->prepare($query);
$stmt->execute($params);
//make sure to get all matching CV's 
$cvs = $stmt->fetchAll(PDO::FETCH_ASSOC);

$selectedCV = null;
//if ID is right, we are going to fetch only that CV and display it in full. 
if ($viewId > 0) {
    $stmt = $conn->prepare("SELECT * FROM cvs WHERE id = :id LIMIT 1");
    $stmt->execute([':id' => $viewId]);
    $selectedCV = $stmt->fetch(PDO::FETCH_ASSOC);
}



?>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Browse CVs</title>
        <meta name="description" content="Browse programmer CVs by name or primary programming language.">
        <link rel="stylesheet" href="style.css">
        <link rel="stylesheet" href="responsive.css">
    </head>
    <body>
        <header id="home">
            <div class="inner-content">
                <div class="header-title"><a href="index.php">Aston<strong>CV</strong></a></div>
                <div class="nav-links">
                    <a href="browseCV.php">Browse CV's</a>
                    <a href="pricing.php">Pricing</a>
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <?php $account_color = '#6A1B6D'; ?>
                        <div class="account">
                            <div class="account-shape" onclick="toggleMenu()" style="background: <?= $account_color ?>;"><?= strtoupper($_SESSION['username'][0]) ?></div>
                            <div class="nav-dropdown" id="DropDownMenu">
                                <div class="account_info"><strong><?= e($_SESSION['username']) ?></strong></div>
                                <hr>
                                <a href="ProfileCV.php">My CV</a>
                                <a href="#">Settings</a>
                                <a href="logout.php">Logout</a>
                            </div>
                        </div>
                    <?php else: ?>
                        <a href="register.php">Register</a>
                        <a href="login.php" class="box-model">Login</a>
                    <?php endif; ?>
                </div>
            </div>
        </header>

        <main class="browse-cv-container">
            <section class="cv-page-title">
                <p class="cv-count"><?= count($cvs) ?> developers</p>
            </section>
            <section class="cv-search-area">
                <h2>Search All CVs</h2>
                <p>Search by name or programming language.</p>
                <form method="get" class="cv-search-form">
                    <input type="text" name="q" value="<?= e($q) ?>" placeholder="Search by name or language..." autofocus>
                    <button type="submit">Search</button>
                </form>
            </section>

            <?php if ($selectedCV): ?>
                <section class="cv-details-panel">
                    <div class="cv-back-link"><a href="browseCV.php<?= $q ? '?q=' . urlencode($q) : '' ?>">← Back to all CVs</a></div>
                    <div class="cv-details-top">
                        <div class="cv-details-head">
                            <h2 class="expanded-name"><?= e($selectedCV['name']) ?></h2>
                            <?php if (!empty(trim($selectedCV['email']))): ?>
                                <p class="cv-email"><?= e($selectedCV['email']) ?></p>
                            <?php endif; ?>
                            <p class="cv-location">United Kingdom</p>
                        </div>
                        <div class="cv-tech-tag"><?= e($selectedCV['keyprogramming'] ?: 'General') ?></div>
                    </div>

                    <div class="cv-box">
                        <h4>Profile</h4>
                        <p><?= nl2br(e($selectedCV['profile'] ?: 'No profile text added yet.')) ?></p>
                    </div>

                    <div class="cv-box">
                        <h4>Education</h4>
                        <p><?= nl2br(e($selectedCV['education'] ?: 'No education details provided.')) ?></p>
                    </div>

                    <div class="cv-box">
                        <h4>Links</h4>
                        <div class="cv-links">
                            <?php for ($i = 1; $i <= 3; $i++): ?>
                                <?php $link = trim($selectedCV['URLlinks' . $i]); ?>
                                <?php if (!empty($link)): ?>
                                    <a href="<?= e($link) ?>" target="_blank" 
                                    rel="noopener noreferrer" class="cv-link-item"><?= e(parse_url($link, PHP_URL_HOST) ?: $link) ?></a>
                                <?php endif; ?>
                            <?php endfor; ?>
                        </div>
                    </div>
                </section>
            <?php endif; ?>

                
            <!-- If no CV send an error, however if there is, we display the CV -->
            <section class="cv-grid">
                <?php if (empty($cvs)): ?>
                    <div class="empty-message">No CVs found. Try inputting a name or programming language. 
                    <br>
                    <br> 
                     For example = "Python" for programming language or "Adam" for Name</div>
                <?php else: ?>

                    <?php foreach ($cvs as $cv): ?>
                        <article class="cv-card">
                            <h3><?= e($cv['name']) ?></h3>
                            <?php if (!empty(trim($cv['email']))): ?>
                                <p class="muted"><?= e($cv['email']) ?></p>
                            <?php endif; ?>

                            <span class="tag"><?= e($cv['keyprogramming'] ?: 'General') ?></span>
                            <p><?= e(mb_strimwidth($cv['profile'], 0, 140, '...')) ?></p>
                            <a class="cv-view-link" href="browseCV.php?view=<?= 
                            (int)$cv['id'] ?>&q=<?= urlencode($q) ?>">View full details</a>
                        </article>
                    <?php endforeach; ?>
                <?php endif; ?>
            </section>
        </main>

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
</html>
      