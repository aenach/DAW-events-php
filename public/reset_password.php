<?php
require __DIR__ . '/../src/bootstrap.php';
require __DIR__ . '/../src/user/reset_password.php';
?>
<?php view('header', ['title' => 'Password reset']) ?>
    <style>
        <?php include 'css/new_pass.css' ?>
        form {
            margin :10% auto;
        }
    </style>
    <div id="page-container">
        <div id="content-wrap">
            <form class="login-form" action="../src/user/reset_password.php" method="post">
                <h2 class="form-title">Reset password</h2>
                <div class="form-group">
                    <label>Your email address</label>
                    <input type="email" name="email">
                </div>
                <div class="form-group">
                    <button type="submit" name="reset-password">Submit</button>
                    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                </div>
            </form>
        </div>
    </div>

<?php view('footer') ?>