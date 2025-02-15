<?php

require_once __DIR__ .'/../users.php';

if (is_post_request()) {
    check_csrf_token();
    if (isset($_POST['update_role'])) {
        update_user_role($_POST['user_id'], $_POST['new_role']);
    } else if (isset($_POST['verify'])) {
        verify_user($_POST['user_id']);
    } else if (isset($_POST['delete_user'])) {
        delete_user($_POST['user_id']);
    }
}