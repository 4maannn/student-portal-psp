<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>PSP Student Portal | DFP40443</title>

<!-- Bootstrap 5 via CDN -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
<link rel="stylesheet" href="public/css/style.css">
</head>
<body>

<?php if (isset($_SESSION['student_id'])): ?>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
  <div class="container">
    <a class="navbar-brand fw-bold" href="index.php">
      PSP Student Portal
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMain">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navMain">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item"><a class="nav-link" href="index.php"> Dashboard</a></li>
        <li class="nav-item"><a class="nav-link" href="profile.php"> My Profile</a></li>
        <li class="nav-item"><a class="nav-link" href="change_password.php"> Change Password</a></li>
        <li class="nav-item"><a class="nav-link" href="students_list.php"> Grade Management</a></li>
      </ul>
      
      <a href="logout.php" class="btn btn-outline-light btn-sm"> Logout</a>
    </div>
  </div>
</nav>
<?php endif; ?>

<div class="container my-4">
