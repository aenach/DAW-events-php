<?php

require_once __DIR__ . '/../bootstrap.php';

$db = getDBConnection();

if (isset($_GET['code'])) {
    $code = $_GET['code'];

    $stmt = $db->prepare("UPDATE users SET verified = 1 WHERE MD5(email) = ?");

    $stmt->bind_param("s", $code);

    if ($stmt->execute()) {
        echo "Email verified successfully.";
    } else {
        echo "Error verifying email: " . $stmt->error;
    }

    $stmt->close();
}
echo '<br><a href="../../public/index.php">Back to Home</a>';