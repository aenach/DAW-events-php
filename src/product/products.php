<?php

function retrieveProductById($productId) {
    $db = getDBConnection();

    $productId = intval($productId);

    $query = "SELECT * FROM products WHERE id = ?";
    $stmt = $db->prepare($query);

    if (!$stmt) {
        return null;
    }

    $stmt->bind_param("i", $productId);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $product = [
            'name' => htmlspecialchars($row["name"]),
            'description' => htmlspecialchars($row["description"]),
            'price' => htmlspecialchars($row["price"]),
            'quantity' => htmlspecialchars($row["quantity"]),
            'id' => htmlspecialchars($row["id"]),
            'image' => $row["image"],
            'info' => $row["info"]
        ];

        $stmt->close();
        $db->close();

        return $product;
    } else {
        $stmt->close();
        $db->close();
        return null;
    }
}

function retrieveProducts($sortOrder = 'asc') {
    $db = getDBConnection();

    $orderBy = ($sortOrder === 'desc') ? 'DESC' : 'ASC';
    $query = "SELECT * FROM products ORDER BY price $orderBy";

    if ($stmt = $db->prepare($query)) {
        $stmt->execute();

        $result = $stmt->get_result();

        $products = [];

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $product = [
                    'name' => htmlspecialchars($row["name"]),
                    'description' => htmlspecialchars($row["description"]),
                    'price' => htmlspecialchars($row["price"]),
                    'quantity' => htmlspecialchars($row["quantity"]),
                    'id' => htmlspecialchars($row["id"]),
                    'image' => $row["image"],
                    'info' => $row["info"]

                ];


                $products[] = $product;
            }
        } else {
            echo "0 results";
        }

        $stmt->close();
    } else {
        echo "Error in prepared statement";
    }

    $db->close();

    return $products;
}

function retrieveProductByName($productName) {
    $db = getDBConnection();

    $query = "SELECT * FROM products WHERE name = ?";
    $stmt = $db->prepare($query);

    if (!$stmt) {
        return null;
    }

    $stmt->bind_param("s", $productName);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $product = [
            'name' => htmlspecialchars($row["name"]),
            'description' => htmlspecialchars($row["description"]),
            'price' => htmlspecialchars($row["price"]),
            'quantity' => htmlspecialchars($row["quantity"]),
            'id' => htmlspecialchars($row["id"]),
            'image' => $row["image"],
            'info' => $row["info"]
        ];

        $stmt->close();
        $db->close();

        return $product;
    } else {
        $stmt->close();
        $db->close();
        return null;
    }
}


function insertProduct($name, $description, $price, $quantity, $userID, $info, $productImage) {
    $db = getDBConnection();

    $name = htmlspecialchars(trim($name));
    $description = htmlspecialchars(trim($description));
    $info = htmlspecialchars(trim($info));
    $price = floatval($price);
    $quantity = intval($quantity);
    $userID = intval($userID);

    if (empty($name) || empty($description) || empty($price) || empty($quantity)) {
        return "All fields are required.";
    }

    $query = "INSERT INTO products (name, description,info, price, quantity, user_id, image) VALUES (?, ?, ?, ?, ?,?, ?)";
    $stmt = $db->prepare($query);

    if (!$stmt) {
        return "Error: Couldn't prepare the statement.";
    }

    $stmt->bind_param("sssdiis", $name, $description, $info, $price, $quantity, $userID,$productImage);
    $stmt->execute();

    $affected_rows =  $stmt->affected_rows;
    if ($stmt->affected_rows > 0) {
        $stmt->close();
        $db->close();
        return $affected_rows . " product inserted into the database.";
    } else {
        $stmt->close();
        $db->close();
        return "An error has occurred. The item was not added.";
    }
}

function deleteProduct($productID) {
    $db = getDBConnection();

    $query = "DELETE FROM products WHERE id = ?";
    $stmt = $db->prepare($query);

    if (!$stmt) {
        echo "Error: Couldn't prepare the statement.";
    }

    $stmt->bind_param("i", $productID);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        $stmt->close();
        $db->close();
        echo "Product with ID {$productID} deleted successfully.";
    } else {
        $stmt->close();
        $db->close();
    }
}

function hasProduct($productID, $userID) {
    $db = getDBConnection();

    $productID = intval($productID);
    $userID = intval($userID);

    $query = "SELECT COUNT(*) as count FROM products WHERE id = ? AND user_id = ?";
    $stmt = $db->prepare($query);

    if (!$stmt) {
        return "Error: Couldn't prepare the statement.";
    }

    $stmt->bind_param("ii", $productID, $userID);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();

    $db->close();

    return $count > 0;
}
