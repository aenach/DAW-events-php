<?php
session_start();
$old_user = $_SESSION['valid_user'];
session_unset();
session_destroy();
?>
<?php require __DIR__ . '/../src/bootstrap.php'; ?>
<?php view('header', ['title' => 'Logout']); ?>
    <div class="message-box">
        <div class="message">
            <?php if (!empty($old_user)) : ?>
                Logged out.<br/>
            <?php else : ?>
                You were not logged in, and so have not been logged out.<br/>
            <?php endif; ?>
            <a href="login.php">Back to login</a>
        </div>
    </div>
<?php view('footer'); ?>