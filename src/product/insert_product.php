<?php
require_once __DIR__ . '/../bootstrap.php';
require_once __DIR__ . '/products.php';

if (is_post_request()) {

    check_csrf_token();

    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
    $user_id = $_SESSION['user_id'];
    $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING);
    $price = filter_input(INPUT_POST, 'price', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $quantity = filter_input(INPUT_POST, 'quantity', FILTER_SANITIZE_NUMBER_INT);
    $info = filter_input(INPUT_POST, 'info', FILTER_SANITIZE_STRING);

    $errors = [];

    $maxFileSize = 5 * 1024 * 1024; // 5mb max
    if (isset($_FILES['productImage']) && $_FILES['productImage']['error'] !== UPLOAD_ERR_NO_FILE) {
        $tmpFilePath = $_FILES['productImage']['tmp_name'];

        if ($_FILES['productImage']['size'] <= $maxFileSize) {
            $imageInfo = getimagesize($tmpFilePath);

            if ($imageInfo !== false) {
                $productImage = file_get_contents($tmpFilePath);
            } else {
                $errors[] = 'Invalid photo. Please choose another one or proceed with no photo.';
            }
        } else {
            $errors[] = 'File exceed limit';
        }
    } else {
        $productImage = '';
    }

    if (empty($name)) {
        $errors[] = 'Product name is required.';
    }

    if (empty($description)) {
        $errors[] = 'Product description is required.';
    }

    if ($price === false || $price <= 0) {
        $errors[] = 'Invalid price. Please enter a valid positive number.';
    }

    if ($quantity === false || $quantity <= 0 || $quantity > 201) {
        $errors[] = 'Invalid quantity, please keep it between 0 and 200.';
    }

    $existingProduct = retrieveProductByName($name);
    if ($existingProduct) {
        $errors[] = 'A product with the same name already exists.';
    }

    if (!empty($errors)) {
        redirect_with_message(
            '../../public/insert_product.php',
            implode('<br>', $errors),
            FLASH_ERROR
        );
    } else {

        $result = insertProduct($name, $description, $price, $quantity, $user_id, $info, $productImage);

        if (str_contains($result, 'inserted into')) {
            redirect_with_message(
                '../../public/insert_product.php',
                'The product has been inserted.'
            );
        } else {
            redirect_with_message(
                '../../public/insert_product.php',
                $result,
                FLASH_ERROR
            );
        }
    }
}
