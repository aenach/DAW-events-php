<?php
require __DIR__ . '/../src/bootstrap.php';
require __DIR__ . '/../src/user/reset_password.php'; ?>
<?php view('header', ['title' => 'Password reset']) ?>
    <style>
        <?php include 'css/new_pass.css' ?>
    </style>
    <div id="page-container">
        <div id="content-wrap">
            <form class="login-form" action="../src/user/reset_password.php" method="post">
                <input type="hidden" name="token" value="<?php echo htmlspecialchars($_GET['token']); ?>">
                <h2 class="form-title">New password</h2>
                <div class="form-group">
                    <label>New password</label>
                    <input type="password" name="new_pass">
                </div>
                <div class="form-group">
                    <label>Confirm new password</label>
                    <input type="password" name="new_pass_c">
                </div>
                <div class="form-group">
                    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                    <button type="submit" name="new_password" class="button">Submit</button>
                </div>
            </form>
        </div>
    </div>

<?php view('footer') ?>