<?php
require_once 'auth.php';

$currentRoute = $_SERVER['REQUEST_URI'];

// 404 if not authorized roots
if (!isAuthorizedRoute($currentRoute)) {
    redirect_to('../../public/403.php');
    exit;
}

//check for cookies
if (!isset($_COOKIE['cookiesAccepted']) || $_COOKIE['cookiesAccepted'] !== 'true') {
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="This is a website for event organization">
    <meta name="keywords" content="Nature, Expedition, Adventure, Holiday">
    <meta name="author" content="Alexandru Enache">
    <?php include 'stylesheets.html' ?>
    <title><?= $title ?? 'Home' ?></title>
    <style>
        <?php include 'css/reset.css' ?>
        <?php include 'css/nav.css' ?>
        <?php include 'css/general.css' ?>
    </style>
</head>
<body>
<nav class="navbar navbar-inverse">
    <div class="container-fluid" style="font-size: 2rem">
        <div class="collapse navbar-collapse" id="navbar-collapse">
            <ul class="nav navbar-nav">
                <li>
                    <a href="index.php" style="font-weight: bold"><i class="fas fa-home"></i> Home</a>
                </li>
                <li class="dropdown">
                    <a href="activities.php" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fas fa-gift"></i> ACTIVITIES <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="activities.php">ALL</a></li>
                        <li><a href="activities.php?category=hiking"><i class="fas fa-hiking"></i> HIKING </a></li>
                        <li><a href="activities.php?category=cycling"><i class="fas fa-bicycle"></i> CYCLING </a></li>
                        <li><a href="activities.php?category=skiing"><i class="fas fa-skiing"></i> SKIING AND SNOWBOARDING</a></li>
                        <li><a href="activities.php?category=kayaking"><i class="rowing"></i> Kayaking & Canoeing</a></li>
                        <li><a href="activities.php?category=camping"><i class="fas fa-campground"></i> Camping Expeditions</a></li>
                    </ul>
                </li>
                <li><a href="products.php"><i class="fas fa-shopping-basket"></i> Equipment </a></li>
                <li><a href="reviews.php"><i class="fas fa-pen"></i> Reviews</a></li>
                <li><a href="contact.php"><i class="fas fa-envelope"></i> Contact</a></li>
            </ul>

            <ul class="nav navbar-nav navbar-right">
                <?php
                $username = current_user();
                if ($username != null) :
                    if (isset($_SESSION['cart'])):
                    ?>
                    <li><a href="shopping_cart.php"><i class="fas fa-shopping-cart"></i> <label class="badge"><?= count($_SESSION['cart']) ?></label></a></li>
                    <?php endif; ?>

                    <li><a href="user_account.php"><i class="fas fa-user"></i> <?= $username ?></a></li>
                    <?php
                    if (is_admin()) :
                        ?>
                        <li><a href="admin_tool.php"><i class="fas fa-user-shield"></i> Admin Tool</a></li>
                    <?php endif; ?>
                    <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
                <?php else : ?>
                    <li><a href="login.php"><i class="fas fa-sign-in-alt"></i> Login</a></li>
                <?php endif; ?>

            </ul>

        </div>
    </div>
</nav>
<?php if (flash()): ?>
    <div class="popup-container">
        <div class="popup-content">
            <?php flash() ?>
        </div>
    </div>
<?php endif; ?>

<script>
    // Check for dark mode preference on page load
    (function() {
        const darkModeEnabled = localStorage.getItem('darkMode') === 'enabled';
        if (darkModeEnabled) {
            document.body.classList.add('dark-mode');
        }
    })();

    // Toggle dark mode function
    document.getElementById('toggleDarkMode').addEventListener('click', function() {
        document.body.classList.toggle('dark-mode');
        if (document.body.classList.contains('dark-mode')) {
            localStorage.setItem('darkMode', 'enabled');
        } else {
            localStorage.setItem('darkMode', 'disabled');
        }
    });
</script>

<main>


