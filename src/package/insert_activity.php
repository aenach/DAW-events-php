<?php
require_once __DIR__ . '/../bootstrap.php';
include 'activities.php';

if (is_post_request()) {

    check_csrf_token();

    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
    $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING);
    $price = filter_input(INPUT_POST, 'price', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $season = filter_input(INPUT_POST, 'season', FILTER_SANITIZE_STRING);
    $country = filter_input(INPUT_POST, 'country', FILTER_SANITIZE_STRING);
    $max_group_number = filter_input(INPUT_POST, 'max_group_number', FILTER_SANITIZE_NUMBER_INT);
    $info = filter_input(INPUT_POST, 'info', FILTER_SANITIZE_STRING);
    $category = filter_input(INPUT_POST, 'category', FILTER_SANITIZE_STRING);

    $errors = [];

    $maxFileSize = 5 * 1024 * 1024; // 5mb max
    if (isset($_FILES['serviceImage']) && $_FILES['serviceImage']['error'] !== UPLOAD_ERR_NO_FILE) {
        $tmpFilePath = $_FILES['serviceImage']['tmp_name'];

        if ($_FILES['serviceImage']['size'] <= $maxFileSize) {
            $imageInfo = getimagesize($tmpFilePath);

            if ($imageInfo !== false) {
                $serviceImage = file_get_contents($tmpFilePath);
            } else {
                $errors[] = 'Invalid photo. Please choose another one or proceed with no photo.';
            }
        } else {
            $errors[] = 'File exceed limit';
        }
    } else {
        $serviceImage = '';
    }

    if (empty($name)) {
        $errors[] = 'Activity name is required.';
    }

    if (empty($description)) {
        $errors[] = 'Activity description is required.';
    }

    if ($price === false || $price <= 0) {
        $errors[] = 'Invalid price. Please enter a valid positive number.';
    }

    $valid_seasons_options = ['winter', 'spring', 'summer', 'autumn', 'all'];
    if (empty($season) || !in_array($season, $valid_seasons_options)) {
        $errors[] = 'Invalid menu type selected.';
    }

    $valid_category = ['hiking', 'cycling', 'skiing', 'camping', 'kayaking '];
    if (empty($category) || !in_array($category, $valid_category)) {
        $errors[] = 'Invalid category selected.';
    }

    if ($max_group_number === false || $max_group_number <= 0 || $max_group_number > 10001) {
        $errors[] = 'Invalid maximum group number, should be between 0 and 10000';
    }

    if (!empty($errors)) {
        redirect_with_message(
            '../../public/insert_activity.php',
            implode('<br>', $errors),
            FLASH_ERROR
        );
    } else {
        $result = insertActivity($name, $description, $price, $season, $country, $max_group_number, $serviceImage, $category, $info);

        if (str_contains($result, 'inserted into')) {
            redirect_with_message(
                '../../public/insert_activity.php',
                'The activity has been inserted.'
            );
        } else {
            redirect_with_message(
                '../../public/insert_activity.php',
                $result,
                FLASH_ERROR
            );
        }
    }
}