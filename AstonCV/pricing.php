<!DOCTYPE html>
<?php 
session_start();
?>



<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Pricing</title>
        <meta name="title" content="Pricing">
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

        <section class="pricing">
            <div class="pricing-header">
                <h1>Simple, Transparent Pricing</h1>
                <p>Choose the plan that works best for you</p>
            </div>

            <div class="pricing-container">
                <div class="pricing-card">
                    <div class="pricing-card-header">
                        <h3>Standard</h3>
                        <p class="plan-subtitle">Perfect to get started</p>
                    </div>
                    <div class="pricing-card-price">
                        <span class="price-symbol">£</span>
                        <span class="price-amount">0</span>
                        <span class="price-period">/month</span>
                    </div>
                    <button class="pricing-btn">Get Started</button>
                    <div class="pricing-features">
                        <p class="feature-title">What's included:</p>
                        <ul class="features-list">
                            <li><span class="checkmark">✓</span> Create your CV</li>
                            <li><span class="checkmark">✓</span> Basic profile visibility</li>
                            <li><span class="checkmark">✓</span> 1 CV upload</li>
                            <li><span class="checkmark">✓</span> Community access</li>
                            <li><span class="checkmark-x">✗</span> Premium profile badge</li>
                            <li><span class="checkmark-x">✗</span> Up to 5 CVs</li>
                            <li><span class="checkmark-x">✗</span> CV analytics & insights</li>
                            <li><span class="checkmark-x">✗</span> Priority support</li>
                            <li><span class="checkmark-x">✗</span> Advanced search options</li>
                        </ul>
                    </div>
                </div>
          
                <div class="pricing-card featured">
                    <div class="pricing-card-badge">Most Popular</div>
                    <div class="pricing-card-header">
                        <h3>Professional</h3>
                        <p class="plan-subtitle">For serious professionals</p>
                    </div>
                    <div class="pricing-card-price">
                        <span class="price-symbol">£</span>
                        <span class="price-amount">9.99</span>
                        <span class="price-period">/month</span>
                    </div>
                    <button class="pricing-btn btn-purple">Upgrade Now</button>
                    <div class="pricing-features">
                        <p class="feature-title">Everything in Standard, plus:</p>
                        <ul class="features-list">
                            <li><span class="checkmark">✓</span> Premium profile badge</li>
                            <li><span class="checkmark">✓</span> Up to 5 CVs</li>
                            <li><span class="checkmark">✓</span> CV analytics & insights</li>
                            <li><span class="checkmark">✓</span> Priority support</li>
                            <li><span class="checkmark">✓</span> Advanced search options</li>
                        </ul>
                    </div>
                </div>
                

                <div class="pricing-card">
                    <div class="pricing-card-header">
                        <h3>Enterprise</h3>
                        <p class="plan-subtitle">For organizations</p>
                    </div>
                    <div class="pricing-card-price">
                        <span class="price-symbol">Custom</span>
                        <span class="price-period">contact us</span>
                    </div>
                    <button class="pricing-btn">Contact Sales</button>
                    <div class="pricing-features">
                        <p class="feature-title">Everything in Professional, plus:</p>
                        <ul class="features-list">
                            <li><span class="checkmark">✓</span> Unlimited CVs & profiles</li>
                            <li><span class="checkmark">✓</span> Team management</li>
                            <li><span class="checkmark">✓</span> Advanced analytics</li>
                            <li><span class="checkmark">✓</span> API access</li>
                            <li><span class="checkmark">✓</span> Dedicated support</li>
                            <li><span class="checkmark">✓</span> Custom branding</li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>

        
         <section class="FAQ">
            <div class="section-title">
             <h2>Pricing <strong class="text-purple"> FAQ</strong></h2>
            </div>
          <div class="faq-container">
        <div class="faq-item">
        <div class="faq-question">
        <h3>Can I try Professional for free?</h3>
        <span>+</span>
      </div>
       <div class="faq-answer">
         <p>Yes! Start with our free Standard plan to explore all features. Upgrade to Professional anytime to unlock premium capabilities like analytics and priority support.</p>
         </div>
       </div>
        <div class="faq-item">
        <div class="faq-question">
         <h3>Can I cancel my subscription anytime?</h3>
         <span>+</span>
        </div>
       <div class="faq-answer">
       <p>Absolutely! There are no long-term contracts. Cancel your Professional subscription at any time from your account settings. Your access continues until the end of the billing period.</p>
       </div>
       </div>
      <div class="faq-item">
      <div class="faq-question">
      <h3>What's the difference between Professional and Enterprise?</h3>
      <span>+</span>
      </div>
       <div class="faq-answer">
          <p>Professional is for individual professionals with up to 5 CVs and analytics. Enterprise is for organizations needing unlimited profiles, team management, API access, and dedicated support.</p>
         </div>
        </div>
        <div class="faq-item">
        <div class="faq-question">
        <h3>Is there a discount for annual billing?</h3>
        <span>+</span>
      </div>
       <div class="faq-answer">
         <p>Contact our sales team for annual billing options and custom enterprise packages. We offer flexible payment terms for all subscription levels.</p>
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
                </div>
                <p class="footer-copy">© 2026 AstonCV</p>
            </div>
        </footer>

        <script src="script.js"></script>
    </body>
      