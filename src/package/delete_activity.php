<?php
require __DIR__ . '/../bootstrap.php';

function deleteActivityById($activityId)
{
    $db = getDBConnection();

    $activityId = intval($activityId);

    $query = "DELETE FROM activities WHERE id = ?";
    $stmt = $db->prepare($query);

    if (!$stmt) {
        return false;
    }

    $stmt->bind_param("i", $activityId);
    $result = $stmt->execute();

    $stmt->close();
    $db->close();

    return $result;
}


if (is_post_request() && is_admin()) {
    check_csrf_token();
    if (isset($_POST['delete_activity'])) {
        $activityId = $_POST['activity_id'];

        $result = deleteActivityById($activityId);

        if ($result === true) {
            redirect_with_message(
                '../../public/activities.php',
                'The activity has been deleted successfully.'
            );
        } else {
            redirect_with_message(
                '../../public/activities.php',
                'Error deleting the activity. Please try again.',
                FLASH_ERROR
            );
        }
    } else {
        redirect_with_message(
            '../../public/activities.php',
            'Invalid request. Please try again.',
            FLASH_ERROR
        );
    }
} else {
    redirect_with_message(
        '../../public/activities.php',
        'You do not have permission to perform this action.',
        FLASH_ERROR
    );
}
