<?php
include 'db_connection.php';
require_once(__DIR__."/../../phpmailer/mail_cod.php");
/**
 * @throws Exception
 */
function register_user(string $firstname, string $lastname, string $email, string $username, string $password): bool
{
    $conn = getDBConnection();

    $existingEmailUser = find_user_by_email($email);
    if ($existingEmailUser !== null) {
        throw new Exception("Email already registered. Please login.");
    }

    $sql = "INSERT INTO users (username, lastname, firstname, email, password) VALUES (?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);

    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    $stmt->bind_param("sssss", $username, $lastname, $firstname, $email, $hashedPassword);

    if (!$stmt->execute()) {
        return false;
    }

    if (!send_activation_email($email)) {
        return false;
    }

    $stmt->close();
    $conn->close();
    return true;
}

function send_activation_email(string $email): bool
{
    $verificationCode = md5($email);
    $verificationLink = "http://localhost/daw-project-event-planner/src/user/verify.php?code=$verificationCode";
    $subject = "Verify Your Email Address";
    $message = "Click the link below to verify your email address:\n$verificationLink";

    $mailed = send_email($email, $subject, $message);

    if (!$mailed) {
        return false;
    }

    return true;
}

function find_user_by_username(string $username): ?array
{
    $conn = getDBConnection();

    $sql = 'SELECT id, username, password, role, verified, email, lastname, firstname, photo FROM users WHERE username=?';
    $statement = $conn->prepare($sql);

    if (!$statement) {
        return null;
    }

    $statement->bind_param('s', $username);
    $statement->execute();
    $statement->store_result();

    if ($statement->num_rows === 0) {
        $statement->close();
        return null; // No user found
    }

    $statement->bind_result($fetchedId, $fetchedUsername, $fetchedPassword, $fetchedRole,
        $fetchedVerified, $fetchedEmail, $fetchedLastname, $fetchedFirstname, $fetchedPhoto);
    $statement->fetch();

    $result = [
        'id' => $fetchedId,
        'username' => $fetchedUsername,
        'password' => $fetchedPassword,
        'role' => $fetchedRole,
        'verified' => $fetchedVerified,
        'email' => $fetchedEmail,
        'lastname' => $fetchedLastname,
        'firstname' => $fetchedFirstname,
        'photo' => $fetchedPhoto
    ];

    $statement->close();

    return $result;
}

function find_user_by_email(string $email): ?array
{
    $conn = getDBConnection();

    $sql = 'SELECT id, username, password FROM users WHERE email=?';
    $statement = $conn->prepare($sql);

    if (!$statement) {
        return null;
    }

    $statement->bind_param('s', $email);
    $statement->execute();
    $statement->store_result();

    if ($statement->num_rows === 0) {
        $statement->close();
        return null; // No user found
    }

    $statement->bind_result($fetchedId, $fetchedUsername, $fetchedPassword);
    $statement->fetch();

    $result = [
        'id' => $fetchedId,
        'username' => $fetchedUsername,
        'password' => $fetchedPassword,
    ];

    $statement->close();

    return $result;
}

/**
 * @throws Exception
 */
function login(string $username, string $password): void
{
    $user = find_user_by_username($username);

    if (!$user) {
        throw new Exception("Wrong username");
    }

    if ($user['verified'] == 0) {
        throw new Exception("Email not verified");
    }

    if (!password_verify($password, $user['password'])) {
        throw new Exception("Wrong password");
    }

    $_SESSION['valid_user'] = $user['username'];
    $_SESSION['role'] = $user['role'];
    $_SESSION['user_id'] = $user['id'];

    // Additional details
    $_SESSION['email'] = $user['email'];
    $_SESSION['lastname'] = $user['lastname'];
    $_SESSION['firstname'] = $user['firstname'];
    $_SESSION['photo'] = $user['photo'];
}

function is_user_logged_in(): bool
{
    return isset($_SESSION['valid_user']);
}

function is_admin(): bool
{
    return isset($_SESSION['role']) && ($_SESSION['role'] === 'admin');
}

function is_seller(): bool
{
    return isset($_SESSION['role']) && ($_SESSION['role'] === 'seller');
}

function current_user()
{
    if (is_user_logged_in()) {
        return $_SESSION['valid_user'];
    }
    return null;
}


function isAuthorizedRoute($currentRoute)
{
    // List of authorized routes
    $authorizedRoutes = [
        '/daw-project-event-planner/public/' => '/daw-project-event-planner/public/',
        '/daw-project-event-planner/public/index.php' => '/daw-project-event-planner/public/index.php',
        '/daw-project-event-planner/public/login.php' => '/daw-project-event-planner/public/login.php',
        '/daw-project-event-planner/public/admin_tool.php' => '/daw-project-event-planner/public/admin_tool.php',
        '/daw-project-event-planner/public/contact.php' => '/daw-project-event-planner/public/contact.php',
        '/daw-project-event-planner/public/edit_profile.php' => '/daw-project-event-planner/public/edit_profile.php',
        '/daw-project-event-planner/public/edit_profile_success.php' => '/daw-project-event-planner/public/edit_profile_success.php',
        '/daw-project-event-planner/public/password_reset_success.php' => '/daw-project-event-planner/public/password_reset_success.php',
        '/daw-project-event-planner/public/reset_password.php' => '/daw-project-event-planner/public/reset_password.php',
        '/daw-project-event-planner/public/insert_product.php' => '/daw-project-event-planner/public/insert_product.php',
        '/daw-project-event-planner/public/insert_activity.php' => '/daw-project-event-planner/public/insert_activity.php',
        '/daw-project-event-planner/public/leave_review.php' => '/daw-project-event-planner/public/leave_review.php',
        '/daw-project-event-planner/public/logout.php' => '/daw-project-event-planner/public/logout.php',
        '/daw-project-event-planner/public/new_password.php' => '/daw-project-event-planner/public/new_password.php',
        '/daw-project-event-planner/public/product_details.php' => '/daw-project-event-planner/public/product_details.php',
        '/daw-project-event-planner/public/products.php' => '/daw-project-event-planner/public/products.php',
        '/daw-project-event-planner/public/registration_success.php' => '/daw-project-event-planner/public/registration_success.php',
        '/daw-project-event-planner/public/reviews.php' => '/daw-project-event-planner/public/reviews.php',
        '/daw-project-event-planner/public/activities.php' => '/daw-project-event-planner/public/activities.php',
        '/daw-project-event-planner/public/user_account.php' => '/daw-project-event-planner/public/user_account.php',
        '/daw-project-event-planner/public/register.php' => '/daw-project-event-planner/public/register.php',
        '/daw-project-event-planner/public/shopping_cart.php' => '/daw-project-event-planner/public/shopping_cart.php',
    ];

    if (in_array($currentRoute, $authorizedRoutes)) {
        return true;
    }

    $parsedUrl = parse_url($currentRoute);
    $path = $parsedUrl['path'];
    $query = $parsedUrl['query'] ?? '';

    return in_array($path, $authorizedRoutes) && !empty($query);
}