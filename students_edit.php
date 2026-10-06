<?php

require_once 'includes/session_check.php';
require_once 'models/StudentModel.php';
require_once 'includes/functions.php';

$model = new StudentModel();
$id    = (int) ($_GET['id'] ?? 0);
$student = $model->findById($id);

if (!$student) {
    redirect('students_list.php');
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name    = sanitize($_POST['name'] ?? '');
    $ic      = sanitize($_POST['ic'] ?? '');
    $program = sanitize($_POST['program'] ?? '');
    $marks   = trim($_POST['marks'] ?? '');

    // keep the values on screen if validation fails
    $student = array_merge($student, compact('name', 'ic', 'program', 'marks'));

    if (empty($name) || empty($ic) || empty($program) || $marks === '') {
        $error = "All fields are required.";
    } elseif (!isValidIc($ic)) {
        $error = "IC number format is invalid (expected 12 digits).";
    } elseif (!isValidMarks($marks)) {
        $error = "Marks must be a number between 0 and 100.";
    } elseif ($model->icExists($ic, $id)) {
        $error = "Another student is already using this IC number.";
    } else {
        $model->update($id, $name, $ic, $program, $marks);
        redirect('students_list.php?saved=1');
    }
}

include 'views/students/edit.php';
