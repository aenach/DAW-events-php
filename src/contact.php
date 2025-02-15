<?php
require __DIR__ . '/../src/bootstrap.php';
require_once '../phpmailer/mail_cod.php';

$siteKey = '6Le-XNgqAAAAANrf2v3i0qMBQ20nAMdC28wkUWrw';
$secretKey = '6LesZEgpAAAAALwD4sgieWSCkBCd0wFBaQL1jKnL';

if (is_post_request()) {
    check_csrf_token();
    $errors = [];

    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
    if (empty($name)) {
        $errors[] = 'Name is required.';
    }

    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    if (empty($email)) {
        $errors[] = 'Invalid email address.';
    }

    $message = filter_input(INPUT_POST, 'message', FILTER_SANITIZE_STRING);
    if (empty($message)) {
        $errors[] = 'Message is required.';
    }

    // Validate reCAPTCHA
    if (empty($_POST['g-recaptcha-response'])) {
        $errors[] = 'Please check on the reCAPTCHA box.';
    } else {
        $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . $secretKey . '&response=' . $_POST['g-recaptcha-response']);
        $responseData = json_decode($verifyResponse);
        if (!$responseData->success) {
            $errors[] = 'Robot verification failed, please try again.';
        }
    }

    if (empty($errors)) {
        $client_message = "Hi $name,\n\nYour message is: $message.\nWe will get back to you soon!";
        $subject = "Thank you for your message!";
        $mail_to_customer = send_email($email, $subject, $client_message);

        $company_email = 'proiectproiect61@gmail.com';
        $company_message = "You got a new message from $name, $email: $message.";
        $company_subject = 'You have a new message';
        $mail_to_company = send_email($company_email, $company_subject, $company_message, $email);

        if ($mail_to_customer && $mail_to_company) {
            redirect_with_message(
                '../public/thank_you.php',
                'Thank you! Your message has been sent.'
            );
        } else {
            redirect_with_message(
                '../public/contact.php',
                'Oops! Something went wrong, please try again later.',
                FLASH_ERROR
            );
        }
    } else {
        redirect_with_message(
            '../public/contact.php',
            implode('<br>', $errors),
            FLASH_ERROR
        );
    }
}
