<?php
require __DIR__ . '/../src/bootstrap.php';
require __DIR__ . '/../src/contact.php';

?>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>

<div style="text-align: left; margin-left: 0; padding: 15px; width: 30%; background-color: rgba(227, 224, 204, 0.3); ">
    <form method="post" action="../src/contact.php">
        <label for="name" style=" ">Name:</label>
        <input type="text" class="form-input text-center" id="name" name="name" required style="background-color:rgba(197, 213, 197, 0.6);   "><br>

        <label for="email" style=" ">Email:</label>
        <input type="email" class="form-input text-center" id="email" name="email" required style="background-color: rgba(197, 213, 197, 0.6);   "><br>

        <label for="message" style=" ">How can we help you?</label>
        <textarea class="form-input text-center" id="message" name="message" required style="background-color:rgba(197, 213, 197, 0.6);   "></textarea><br>

        <div class="form-input">
            <!-- Google reCAPTCHA box -->
            <div class="g-recaptcha" data-sitekey="<?php echo $siteKey; ?>"></div>
        </div>
        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
        <button type="submit" class="button" style="background-color: rgba(197, 213, 197, 0.6); color: black;  ">Tell us about your event</button>
    </form>
</div>
