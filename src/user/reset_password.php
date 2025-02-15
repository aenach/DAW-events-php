<?php
require_once __DIR__ . '/../../phpmailer/mail_cod.php';
require_once __DIR__ . '/../inc/db_connection.php';
require_once __DIR__ . '/../libs/helpers.php';

if(!isset($_SESSION))
{
    session_start();
}

$inputs=[];
$errors = [];
if (isset($_POST['reset-password'])) {
    check_csrf_token();
    $db = getDBConnection();
    $email = $_POST['email'];

    if (empty($email)) {
        $errors['no_email'] = 'Your email is required';
    } else {
        $query = "SELECT email FROM users WHERE email=?";
        $stmt = mysqli_prepare($db, $query);
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);

        if (mysqli_stmt_num_rows($stmt) <= 0) {
            $errors['no_email'] = 'Sorry, no user exists on our system with that email';
        } else {
            try {
                $token = bin2hex(openssl_random_pseudo_bytes(64));
                $sql = "INSERT INTO password_reset (email, token) VALUES (?, ?)";
                $stmt = mysqli_prepare($db, $sql);
                mysqli_stmt_bind_param($stmt, "ss", $email, $token);
                mysqli_stmt_execute($stmt);

                $subject = "Reset your password on DETAILS - event planner";
                $msg = "Hi there, click on this <a href=\"http://daw-events-planner-ed298d55c5bd.herokuapp.com/public/new_password.php?token=" . $token . "\">link</a> to reset your password on our site";
                $msg = wordwrap($msg, 70);
                send_email($email, $subject, $msg);
                $_SESSION['flash_message'] = 'Password reset link sent to your email';
                header('Location: ../../public/pending.php?email=' . $email);
                exit();
            } catch (Exception $e) {
                $errors['token_generation'] = 'Token generation failed ' . $e->getMessage();
            }
        }
    }

    $_SESSION['errors'] = $errors;
    $_SESSION['inputs'] = $inputs;
    redirect_to('../../public/reset_password.php');
}

if (isset($_POST['new_password'])) {
    check_csrf_token();
    $db = getDBConnection();

    $new_pass = mysqli_real_escape_string($db, $_POST['new_pass']);
    $new_pass_c = mysqli_real_escape_string($db, $_POST['new_pass_c']);

    $token = htmlspecialchars($_POST['token']);

    if (empty($token))
        $errors[''] = 'This link is incorrect. Please try accessing again from your email';

    if (!(strlen($new_pass) >= 6) )
        $errors[''] = 'Password should have at least 6 characters.';

    if (empty($new_pass) || empty($new_pass_c))
        $errors[''] = 'Enter a password';
    if ($new_pass !== $new_pass_c)
        $errors[''] = 'Password does not match';


    if (count($errors) == 0) {
        // select email address of user from the password_reset table
        $sql = "SELECT email FROM password_reset WHERE token='$token' LIMIT 1";
        $results = mysqli_query($db, $sql);
        $email = mysqli_fetch_assoc($results)['email'];

        if ($email) {
            $new_hashed_pass = password_hash($new_pass, PASSWORD_BCRYPT);
            $sql = "UPDATE users SET password='$new_hashed_pass' WHERE email='$email'";
            $results = mysqli_query($db, $sql);
            $_SESSION['flash_message'] = 'Password has been successfully updated';
            header('Location: ../../public/password_reset_success.php');
            exit();
        } else $errors[''] = 'Error updating password';
    }


    $_SESSION['errors'] = $errors;
    $_SESSION['inputs'] = $inputs;
    redirect_to('../../public/new_password.php?token=' . $token);
}

[$inputs, $errors] = session_flash('inputs', 'errors');
if (!empty($errors)) {
    foreach ($errors as $errorKey => $errorMessage) {
        flash('flash_' . uniqid(),  $errorMessage, FLASH_ERROR);
    }
}

