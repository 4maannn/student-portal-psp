<?php

require_once 'includes/session_check.php';
require_once 'models/StudentModel.php';
require_once 'includes/functions.php';

$model   = new StudentModel();
$student = $model->findById($_SESSION['student_id']); // strictly from session

if (!$student) {
    // Safety net: session refers to a record that no longer exists
    session_unset();
    session_destroy();
    redirect('login.php');
}

include 'views/profile/profile.php';
