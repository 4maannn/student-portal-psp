<?php

session_start();

require_once 'models/UserModel.php';
require_once 'includes/functions.php';

if (isset($_SESSION['student_id'])) {
    redirect('index.php');
}

$error   = '';
$timeout = isset($_GET['timeout']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ic       = sanitize($_POST['ic'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($ic) || empty($password)) {
        $error = "IC number and password are both required.";
    } else {
        $userModel = new UserModel();
        // joins users -> students on student_id to fetch account + profile in one go
        $account   = $userModel->findByStudentIc($ic);

        // password_verify() checks plain input against the stored bcrypt hash
        if ($account && password_verify($password, $account['password'])) {
            // Regenerate session ID on login to prevent session fixation
            session_regenerate_id(true);
            $_SESSION['user_id']       = $account['user_id'];
            $_SESSION['student_id']    = $account['student_id'];
            $_SESSION['student_name']  = $account['name'];
            $_SESSION['last_activity'] = time();
            redirect('index.php');
        } else {
            $error = "Invalid IC number or password.";
        }
    }
}

include 'views/auth/login.php';
