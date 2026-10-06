<?php

require_once 'includes/session_check.php';
require_once 'models/UserModel.php';
require_once 'includes/functions.php';

$model   = new UserModel();
$error   = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $old     = $_POST['old_password'] ?? '';
    $new     = $_POST['new_password'] ?? '';
    $confirm = $_POST['confirm_password'] ?? '';

    if (empty($old) || empty($new) || empty($confirm)) {
        $error = "All fields are required.";
    } elseif (strlen($new) < 6) {
        $error = "New password must be at least 6 characters long.";
    } elseif ($new !== $confirm) {
        $error = "New password and confirmation password do not match.";
    } elseif (!$model->verifyPassword($_SESSION['user_id'], $old)) {
        // Old password validated against the hashed value stored in the users table
        $error = "The old password you entered is incorrect.";
    } elseif ($old === $new) {
        $error = "New password must be different from the old password.";
    } else {
        $model->updatePassword($_SESSION['user_id'], $new); // stored via password_hash()
        $success = "Your password has been updated successfully.";
    }
}

include 'views/profile/change_password.php';
