<?php
require_once 'auth.php';

$currentRoute = $_SERVER['REQUEST_URI'];

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
    <?php include 'stylesheets.html' ?>
    <title><?= $title ?? 'Home' ?></title>
    <style>
        <?php include 'css/reset.css' ?>
        <?php include 'css/vertical_nav.css' ?>
        <?php include 'css/general.css' ?>
    </style>
</head>
<body>
<nav class="navbar navbar-inverse">
    <div class="container-fluid" style="font-size: 2rem">
        <div class="collapse navbar-collapse" id="navbar-collapse">
            <ul class="nav navbar-nav">
                <li><a href="index.php"><i class="fas fa-user"></i> Home </a></li>
                <li><a href="admin_tool.php"><i class="fas fa-user"></i> Users management</a></li>
                <li><a href="products.php"><i class="fas fa-shopping-basket"></i> Product Management </a></li>
                <li><a href="activities.php"><i class="fas fa-shopping-basket"></i> Activities Management </a></li>
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

<main>


