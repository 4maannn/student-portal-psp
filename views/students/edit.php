<?php include 'views/layout/header.php'; ?>

<h2 class="mb-4"> Edit Student</h2>

<div class="card shadow-sm border-0" style="max-width:560px;">
  <div class="card-body">

    <?php if (!empty($error)): ?>
      <div class="alert alert-danger py-2 small"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>
    <div id="clientError" class="alert alert-danger py-2 small d-none"></div>

    <form method="POST" action="students_edit.php?id=<?php echo (int) $student['id']; ?>" id="studentForm" novalidate>
      <div class="mb-3">
        <label class="form-label">Full Name</label>
        <input type="text" name="name" class="form-control" required
               value="<?php echo htmlspecialchars($student['name']); ?>">
      </div>
      <div class="mb-3">
        <label class="form-label">IC Number</label>
        <input type="text" name="ic" class="form-control" required
               value="<?php echo htmlspecialchars($student['ic']); ?>">
      </div>
      <div class="mb-3">
        <label class="form-label">Program</label>
        <input type="text" name="program" class="form-control" required
               value="<?php echo htmlspecialchars($student['program']); ?>">
      </div>
      <div class="mb-3">
        <label class="form-label">Marks</label>
        <input type="number" step="0.01" min="0" max="100" name="marks" id="marks" class="form-control" required
               value="<?php echo htmlspecialchars($student['marks']); ?>">
      </div>
      <button type="submit" class="btn btn-primary"> Update Student</button>
      <a href="students_list.php" class="btn btn-link">Cancel</a>
    </form>
  </div>
</div>

<?php include 'views/layout/footer.php'; ?>
