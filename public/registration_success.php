<!DOCTYPE html>
<?php
require __DIR__ . '/../src/bootstrap.php';
?>

<?php view('header', ['title' => 'Registration successfully']); ?>
<div class="message-box">
    <p class="success-message">Your account has been created successfully.</p>
    <p>Please verify your email before logging in.</p>
</div>
<?php view('footer') ?>