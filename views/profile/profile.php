<?php include 'views/layout/header.php'; ?>

<h2 class="mb-4"> My Profile</h2>

<?php if (!empty($_SESSION['flash_success'])): ?>
  <div class="alert alert-success" style="max-width:600px;"><?php echo htmlspecialchars($_SESSION['flash_success']); unset($_SESSION['flash_success']); ?></div>
<?php endif; ?>
<?php if (!empty($_SESSION['flash_error'])): ?>
  <div class="alert alert-danger" style="max-width:600px;"><?php echo htmlspecialchars($_SESSION['flash_error']); unset($_SESSION['flash_error']); ?></div>
<?php endif; ?>

<div class="card shadow-sm border-0" style="max-width:600px;">
  <div class="card-body">
    <div class="text-center mb-4">
      <?php if (!empty($student['profile_picture'])): ?>
        <img src="uploads/profile/<?php echo htmlspecialchars($student['profile_picture']); ?>"
             alt="Profile picture" class="rounded-circle border" width="150" height="150" style="object-fit:cover;">
      <?php else: ?>
        <i class="bi bi-person-circle text-secondary" style="font-size:150px; line-height:1;"></i>
      <?php endif; ?>

      <form action="upload_picture.php" method="POST" enctype="multipart/form-data" class="mt-3" id="uploadForm">
        <input type="file" name="profile_picture" id="profile_picture" class="form-control form-control-sm mb-2"
               accept=".jpg,.jpeg,.png" required>
        <div class="form-text mb-2">JPG, JPEG or PNG only. Maximum 2MB.</div>
        <button type="submit" class="btn btn-sm btn-primary">Upload Picture</button>
      </form>
    </div>

    <table class="table table-borderless mb-3">
      <tbody>
        <tr>
          <th style="width:180px;">Full Name</th>
          <td><?php echo htmlspecialchars($student['name']); ?></td>
        </tr>
        <tr>
          <th>NRIC / IC Number</th>
          <td><?php echo htmlspecialchars($student['ic']); ?></td>
        </tr>
        <tr>
          <th>Program</th>
          <td><?php echo htmlspecialchars($student['program']); ?></td>
        </tr>
        <tr>
          <th>Latest Marks</th>
          <td>
            <span class="badge bg-<?php echo $student['marks'] >= 50 ? 'success' : 'danger'; ?>">
              <?php echo htmlspecialchars($student['marks']); ?>
            </span>
          </td>
        </tr>
      </tbody>
    </table>
    <a href="change_password.php" class="btn btn-warning">
      Change Password
    </a>
  </div>
</div>

<?php include 'views/layout/footer.php'; ?>
