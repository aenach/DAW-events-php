<?php
require __DIR__ . '/../src/bootstrap.php';
require __DIR__ . '/../src/contact.php';

?>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>

<?php view('header', ['title' => 'Contact us']); ?>

<style>
    form {
        border: 1px solid #ddd;
        max-width: 600px;
        box-sizing: border-box;
        background-color: #fff;
        padding: 5%;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        margin-left: auto;
        margin-right: auto;
    }

    label {
        display: block;
        margin-bottom: 5px;
    }
</style>


<div class="container-fluid" style="margin-bottom: 2%">
    <div class="row" style="margin-top: 3%; margin-bottom: 3%;">
        <div class="col-md-6 col-md-offset-3">
            <form method="post" action="../src/contact.php">
                <h3 class="text-center" style=" ">Contact us</h3>

                <div class="form-group">

                    <label for="name" style=" ">Name:</label>
                    <input type="text" class="form-input" id="name" name="name" required>
                </div>
                <div class="form-group">

                    <label for="email" style=" ">Email:</label>
                    <input type="email" class="form-input" id="email" name="email" required
                    ></div>

                <div class="form-group">

                    <label for="message">How can we help you?</label>
                    <textarea class="form-input" id="message" name="message" required
                              style="width: 100%"></textarea></div>

                <!-- Google reCAPTCHA box -->
                <div class="g-recaptcha"
                     data-sitekey="<?php echo $siteKey; ?>"></div>

                <div class="text-center">
                    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                    <button type="submit" class="button">
                        Send message
                    </button>
                </div>
            </form>
        </div>
        <div class="col-md-2"></div>
    </div>
</div>

<?php view('footer') ?>

