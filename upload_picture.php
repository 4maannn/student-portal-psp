<?php
// UploadController - handles profile picture upload (Part 1.1)

require_once 'includes/session_check.php';
require_once 'models/StudentModel.php';
require_once 'includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect('profile.php');
}

$studentId = $_SESSION['student_id']; // always the logged-in student, never from user input
$error     = validateProfilePicture($_FILES['profile_picture'] ?? null);

if ($error !== null) {
    $_SESSION['flash_error'] = $error;
    redirect('profile.php');
}

$file    = $_FILES['profile_picture'];
$newName = generateUploadName($file['name']);

if (!is_dir(UPLOAD_DIR)) {
    mkdir(UPLOAD_DIR, 0755, true);
}

if (!move_uploaded_file($file['tmp_name'], UPLOAD_DIR . $newName)) {
    $_SESSION['flash_error'] = "Could not save the uploaded file. Check the uploads folder permissions.";
    redirect('profile.php');
}

$model   = new StudentModel();
$student = $model->findById($studentId);
$model->updateProfilePicture($studentId, $newName);

// Delete the previous picture so old files do not pile up
if (!empty($student['profile_picture'])) {
    $old = UPLOAD_DIR . basename($student['profile_picture']);
    if (is_file($old)) {
        unlink($old);
    }
}

$_SESSION['flash_success'] = "Profile picture updated successfully.";
redirect('profile.php');
