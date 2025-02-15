<?php

function create_user( $firstname,  $lastname,  $email,  $username,  $password){
    $conn = getDBConnection();

    $sql = "INSERT INTO users (username, lastname, firstname, email, password) VALUES (?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);

    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    $stmt->bind_param("sssss", $username, $lastname, $firstname, $email, $hashedPassword);

    if (!$stmt->execute()) {
        return false;
    }

    $stmt->close();
    $conn->close();
    return true;
}


function edit_user($user_id, $firstname, $lastname, $photo) {
$connection = getDBConnection();

$sql = 'UPDATE users SET  firstname = ?, lastname = ?, photo = ? WHERE id = ?';

if ($statement = $connection->prepare($sql)) {
$statement->bind_param('sssi', $firstname, $lastname, $photo, $user_id);  // 's' represents string, 'i' represents integer type

if ($statement->execute()) {
$statement->close();
$connection->close();
return true;
} else {
echo "Error: " . $statement->error;
}
}

$connection->close();
return false;
}

function get_user_by_id($user_id) {
    $connection = getDBConnection();

    $sql = 'SELECT id, email, role, verified, firstname, lastname, photo FROM users WHERE id = ?';

    if ($statement = $connection->prepare($sql)) {
        $statement->bind_param('i', $user_id);
        $statement->execute();

        $result = $statement->get_result();
        $user = $result->fetch_assoc();

        $statement->close();
    }

    $connection->close();

    return $user;
}

function delete_user($userId) {
    $connection = getDBConnection();

    $sql = 'DELETE FROM users WHERE id = ?';
    if ($statement = $connection->prepare($sql)) {
        $statement->bind_param('i', $userId);

        if ($statement->execute()) {
            $statement->close();
            $connection->close();
            return true;
        } else {
            echo "Error: " . $statement->error;
            $connection->close();
            return false;
        }
    }
}

function get_all_users() {
    $connection = getDBConnection();

    $sql = 'SELECT id, email, role, username, verified FROM users';
    $result = $connection->query($sql);

    $users = [];
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $users[] = $row;
        }
        $result->free();
    }

    $connection->close();

    return $users;
}

function update_user_role($userId, $newRole) {
    $connection = getDBConnection();

    $sql = "UPDATE users SET role = ? WHERE id = ?";
    if ($statement = $connection->prepare($sql)) {
        $statement->bind_param('si', $newRole, $userId);

        if ($statement->execute()) {
            $statement->close();
            $connection->close();
            return true;
        } else {
            echo "Error: " . $statement->error;
            $connection->close();
            return false;
        }
    }
}

function verify_user($userId) {
    $connection = getDBConnection();

    $sql = "UPDATE users set verified = 1 WHERE id = ?";
    if ($statement = $connection->prepare($sql)) {
        $statement->bind_param('i', $userId);

        if ($statement->execute()) {
            $statement->close();
            $connection->close();
            return true;
        } else {
            echo "Error: " . $statement->error;
            $connection->close();
            return false;
        }
    }
}