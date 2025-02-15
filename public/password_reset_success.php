<?php
require __DIR__ . '/../src/bootstrap.php';
?>

<?php view('header', ['title' => 'Email was sent successfully']); ?>

    <div class="message-box">
        <p>Password has been successfully reset.</p>
        <p>You can <a href="login.php">login </a>now.</p>
    </div>
<?php view('footer') ?>