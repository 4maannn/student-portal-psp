<?php include 'views/layout/header.php'; ?>

<h2 class="mb-4"> Change Password</h2>

<div class="card shadow-sm border-0" style="max-width:500px;">
  <div class="card-body">

    <?php if (!empty($error)): ?>
      <div class="alert alert-danger py-2 small"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>
    <?php if (!empty($success)): ?>
      <div class="alert alert-success py-2 small"><?php echo htmlspecialchars($success); ?></div>
    <?php endif; ?>
    <div id="clientError" class="alert alert-danger py-2 small d-none"></div>

    <form method="POST" action="change_password.php" id="changePasswordForm" novalidate>
      <div class="mb-3">
        <label class="form-label">Old Password</label>
        <input type="password" name="old_password" class="form-control" required>
      </div>
      <div class="mb-3">
        <label class="form-label">New Password</label>
        <input type="password" name="new_password" id="new_password" class="form-control" minlength="6" required>
        <div class="form-text">Minimum 6 characters.</div>
      </div>
      <div class="mb-3">
        <label class="form-label">Confirm New Password</label>
        <input type="password" name="confirm_password" id="confirm_password" class="form-control" minlength="6" required>
      </div>
      <button type="submit" class="btn btn-warning">
         Update Password
      </button>
      <a href="profile.php" class="btn btn-link">Back to Profile</a>
    </form>
  </div>
</div>

<?php include 'views/layout/footer.php'; ?>
