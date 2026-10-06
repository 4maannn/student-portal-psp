<?php

require_once 'includes/session_check.php';
require_once 'models/StudentModel.php';
require_once 'models/UserModel.php';
require_once 'includes/functions.php';

$model     = new StudentModel();
$userModel = new UserModel();
$error     = '';

// pre-fill values so the form can redisplay them after a validation error
$old = ['name' => '', 'ic' => '', 'program' => '', 'marks' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name    = sanitize($_POST['name'] ?? '');
    $ic      = sanitize($_POST['ic'] ?? '');
    $program = sanitize($_POST['program'] ?? '');
    $marks   = trim($_POST['marks'] ?? '');

    $old = compact('name', 'ic', 'program', 'marks');

    // Server-side validation (in addition to client-side JS validation)
    if (empty($name) || empty($ic) || empty($program) || $marks === '') {
        $error = "All fields are required.";
    } elseif (!isValidIc($ic)) {
        $error = "IC number format is invalid (expected 12 digits).";
    } elseif (!isValidMarks($marks)) {
        $error = "Marks must be a number between 0 and 100.";
    } elseif ($model->icExists($ic)) {
        $error = "A student with this IC number already exists.";
    } else {
        $defaultPassword = "Student@123"; // student can change it via Password Exchange Module
        $newStudentId    = $model->create($name, $ic, $program, $marks);
        $userModel->createForStudent($newStudentId, $defaultPassword);
        redirect('students_list.php?saved=1');
    }
}

include 'views/students/create.php';
