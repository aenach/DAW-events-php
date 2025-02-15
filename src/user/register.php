<?php
require_once __DIR__ . '/../bootstrap.php';
require_once __DIR__ . '/../inc/auth.php';
$nameErr = "";


function isValidEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

function isValidPassword($password): bool
{
    return strlen($password) >= 6;
}

function isUsernameAlreadyTaken($username): bool
{
    return find_user_by_username($username) !== null;
}

function validateRegistration($firstname, $lastname, $username, $email, $password, $password2, $acceptedTermsOfService): array
{

    $errors = [];

    if (empty($firstname)) {
        $errors[] = 'First name is required.';
    }

    if (empty($lastname)) {
        $errors[] = 'Last name is required.';
    }

    if (empty($username)) {
        $errors[] = 'Username is required.';
    }

    if (isUsernameAlreadyTaken($username)) {
        $errors[] = 'Username already taken. Please choose a different one.';
    }

    if (empty($email) || !isValidEmail($email)) {
        $errors[] = 'Email should have a valid format.';
    }

    if (empty($password) || !isValidPassword($password)) {
        $errors[] = 'Password should have at least 6 characters.';
    }

    if ($password !== $password2) {
        $errors[] = 'Passwords do not match.';
    }

    if (!$acceptedTermsOfService) {
        $errors[] = 'Please accept the terms and conditions';
    }

    return $errors;
}

if (is_post_request()) {

    check_csrf_token();


    if (($_POST["firstname"])=='') {
        $nameErr = "Name is required";
    } else {
        $name = $_POST["firstname"];
    }

    $firstname = htmlspecialchars($_POST['firstname']);
    $lastname = htmlspecialchars($_POST['lastname']);
    $username = htmlspecialchars($_POST['username']);
    $email = htmlspecialchars($_POST['email']);
    $password = htmlspecialchars($_POST['password']);
    $password2 = htmlspecialchars($_POST['password2']);
    $acceptedTermsOfService = isset($_POST['agree']) && $_POST['agree'] === 'on';

    $errors = validateRegistration($firstname, $lastname, $username, $email, $password, $password2, $acceptedTermsOfService);

    if (empty($errors)) {
        try {
            if (register_user($firstname, $lastname, $email, $username, $password)) {
                redirect_to('../../public/registration_success.php');
                unset($_SESSION['inputs']);
            }
        } catch (Exception $e) {
            $errors[] = $e->getMessage();
        }
    }

    $_SESSION['inputs'] = $_POST;
    $_SESSION['errors'] = $errors;
    header('Location: ../../public/register.php');
    exit();
}