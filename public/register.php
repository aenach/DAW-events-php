<?php
require __DIR__ . '/../src/bootstrap.php';
require __DIR__ . '/../src/user/register.php';
?>

<?php view('header', ['title' => 'Register']); ?>
<style>
    <?php include 'css/register.css' ?>
</style>
<div id="page-container">
    <div id="content-wrap">
        <form action="../src/user/register.php" method="post">
            <h2>Sign Up</h2>

            <div>
                <label for="firstname">First name:</label>
                <input type="text" name="firstname" id="firstname"
                       value="<?= isset($_SESSION['inputs']['firstname']) ? htmlspecialchars($_SESSION['inputs']['firstname']) : '' ?>"
                       class="form-input text-center">
            </div>
            <div>
                <label for="lastname">Last name:</label>
                <input type="text" name="lastname" id="lastname"
                       value="<?= isset($_SESSION['inputs']['lastname']) ? htmlspecialchars($_SESSION['inputs']['lastname']) : '' ?>"
                       class="form-input text-center">
            </div>
            <div>
                <label for="username">Username:</label>
                <input type="text" name="username" id="username"
                       value="<?= isset($_SESSION['inputs']['username']) ? htmlspecialchars($_SESSION['inputs']['username']) : '' ?>"
                       class="form-input text-center">
            </div>
            <div>
                <label for="email">Email:</label>
                <input type="email" name="email" id="email"
                       value="<?= isset($_SESSION['inputs']['email']) ? htmlspecialchars($_SESSION['inputs']['email']) : '' ?>"
                       class="form-input text-center">
            </div>
            <div>
                <label for="password">Password:</label>
                <input type="password" name="password" id="password"
                       value="<?= isset($_SESSION['inputs']['password']) ? htmlspecialchars($_SESSION['inputs']['password']) : '' ?>"
                       class="form-input text-center">
            </div>
            <div>
                <label for="password2">Password Again:</label>
                <input type="password" name="password2" id="password2"
                       value="<?= isset($_SESSION['inputs']['password2']) ? htmlspecialchars($_SESSION['inputs']['password2']) : '' ?>"
                       class="form-input text-center">
            </div>

            <div class="checkbox-group">
                <label for="agree" style="text-align: center">I agree with the <a>terms of services.</a></label>
                <input type="checkbox" name="agree" id="agree" <?= isset($_SESSION['inputs']['agree']) && $_SESSION['inputs']['agree'] ? 'checked' : '' ?> value="on">
            </div>

            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">

            <button type="submit" name="register">Register</button>
            <a href="login.php" class="styled-link" style="color: white">Already a member? Login here</a>
        </form>
    </div>
</div>
<?php view('footer') ?>
