<?php include 'views/layout/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
  <h2 class="mb-0"> Grade Management</h2>
  <a href="students_create.php" class="btn btn-success">
    <i class="bi bi-plus-circle"></i> Add New Student
  </a>
</div>

<?php if (isset($_GET['deleted'])): ?>
  <div class="alert alert-success py-2 small">Student record deleted successfully.</div>
<?php endif; ?>
<?php if (isset($_GET['saved'])): ?>
  <div class="alert alert-success py-2 small">Student record saved successfully.</div>
<?php endif; ?>

<div class="card shadow-sm border-0">
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-hover align-middle">
        <thead class="table-light">
          <tr>
            <th>#</th>
            <th>Name</th>
            <th>IC Number</th>
            <th>Program</th>
            <th>Marks</th>
            <th class="text-end">Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php if (empty($students)): ?>
            <tr><td colspan="6" class="text-center text-muted py-4">No student records found.</td></tr>
          <?php else: ?>
            <?php foreach ($students as $s): ?>
              <tr>
                <td><?php echo (int) $s['id']; ?></td>
                <td><?php echo htmlspecialchars($s['name']); ?></td>
                <td><?php echo htmlspecialchars($s['ic']); ?></td>
                <td><?php echo htmlspecialchars($s['program']); ?></td>
                <td>
                  <span class="badge bg-<?php echo $s['marks'] >= 50 ? 'success' : 'danger'; ?>">
                    <?php echo htmlspecialchars($s['marks']); ?>
                  </span>
                </td>
                <td class="text-end">
                  <a href="students_edit.php?id=<?php echo (int) $s['id']; ?>" class="btn btn-sm btn-outline-primary">
                     Edit
                  </a>
                  <a href="students_delete.php?id=<?php echo (int) $s['id']; ?>" class="btn btn-sm btn-outline-danger btn-delete">
                     Delete
                  </a>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<?php include 'views/layout/footer.php'; ?>
