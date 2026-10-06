<?php include 'views/layout/header.php'; ?>

<div class="row justify-content-center">
  <div class="col-md-5 col-lg-4">
    <div class="card shadow-sm border-0 mt-5">
      <div class="card-body p-4">
        <div class="text-center mb-4">
          
          <h4 class="mt-2 mb-0">PSP Student Portal</h4>
          <small class="text-muted">Please sign in to continue</small>
        </div>

        <?php if ($timeout): ?>
          <div class="alert alert-warning py-2 small">Your session has expired. Please login again.</div>
        <?php endif; ?>

        <?php if (!empty($error)): ?>
          <div class="alert alert-danger py-2 small"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <form method="POST" action="login.php" novalidate id="loginForm">
          <div class="mb-3">
            <label class="form-label">IC Number</label>
            <input type="text" name="ic" class="form-control" placeholder="e.g. 900101015566" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control" required>
          </div>
          <button type="submit" class="btn btn-primary w-100">
             Login
          </button>
        </form>

        <hr>
        
      </div>
    </div>
  </div>
</div>

<?php include 'views/layout/footer.php'; ?>
