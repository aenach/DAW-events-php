<?php
require_once __DIR__ . '/../bootstrap.php';
require_once 'products.php';

if (is_post_request()) {
    check_csrf_token();
    $are_valid = true;
    if (is_seller()) {
        $userID = $_SESSION['user_id'];
        foreach ($_POST['productIDs'] as $productID) {
            if (!hasProduct($productID, $userID)) {

                $are_valid = false;
            }
        }
    }
    if ($are_valid) {
        deleteProduct($_POST['product_id']);
        unset($_POST['product_id']);
        redirect_with_message(
            '../../public/products.php',
            'The product has been successfully deleted.'
        );
    } else {
        redirect_with_message(
            '../../public/products.php',
            'You do not have rights to delete this!', FLASH_ERROR);
    }
}
