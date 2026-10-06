<?php
require_once 'includes/session_check.php';
require_once 'models/StudentModel.php';

$model   = new StudentModel();
$student = $model->findById($_SESSION['student_id']);
$total   = count($model->getAll());
?>
<?php include 'views/layout/header.php'; ?>

<h2 class="mb-1">Welcome, <?php echo htmlspecialchars($student['name']); ?> </h2>
<p class="text-muted mb-4">Program: <?php echo htmlspecialchars($student['program']); ?></p>

<div class="row g-4">
  <div class="col-md-4">
    <div class="card shadow-sm border-0 h-100">
      <div class="card-body">
        <i class="bi bi-person-circle text-primary" style="font-size:1.8rem;"></i>
        <h5 class="mt-2">My Profile</h5>
        <p class="text-muted small">View your personal record based on your active session.</p>
        <a href="profile.php" class="btn btn-sm btn-outline-primary">View Profile</a>
      </div>
    </div>
  </div>
  <div class="col-md-4">
    <div class="card shadow-sm border-0 h-100">
      <div class="card-body">
        <i class="bi bi-key text-warning" style="font-size:1.8rem;"></i>
        <h5 class="mt-2">Account Security</h5>
        <p class="text-muted small">Update your password securely at any time.</p>
        <a href="change_password.php" class="btn btn-sm btn-outline-warning">Change Password</a>
      </div>
    </div>
  </div>
  <div class="col-md-4">
    <div class="card shadow-sm border-0 h-100">
      <div class="card-body">
        <i class="bi bi-table text-success" style="font-size:1.8rem;"></i>
        <h5 class="mt-2">Grade Management</h5>
        <p class="text-muted small"><?php echo $total; ?> student record(s) stored in MySQL.</p>
        <a href="students_list.php" class="btn btn-sm btn-outline-success">Manage Records</a>
      </div>
    </div>
  </div>
</div>

<?php include 'views/layout/footer.php'; ?>
