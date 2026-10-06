
document.addEventListener('DOMContentLoaded', function () {

    // ---- Change Password form ----
    const pwForm = document.getElementById('changePasswordForm');
    if (pwForm) {
        pwForm.addEventListener('submit', function (e) {
            const newPass     = document.getElementById('new_password').value;
            const confirmPass = document.getElementById('confirm_password').value;
            const errorBox    = document.getElementById('clientError');

            errorBox.classList.add('d-none');
            errorBox.textContent = '';

            if (newPass.length < 6) {
                e.preventDefault();
                errorBox.textContent = 'New password must be at least 6 characters.';
                errorBox.classList.remove('d-none');
                return;
            }
            if (newPass !== confirmPass) {
                e.preventDefault();
                errorBox.textContent = 'New password and confirmation do not match.';
                errorBox.classList.remove('d-none');
            }
        });
    }

    // ---- Create / Edit Student form ----
    const studentForm = document.getElementById('studentForm');
    if (studentForm) {
        studentForm.addEventListener('submit', function (e) {
            const marksField = document.getElementById('marks');
            const marks      = parseFloat(marksField.value);
            const errorBox   = document.getElementById('clientError');

            errorBox.classList.add('d-none');
            errorBox.textContent = '';

            if (isNaN(marks) || marks < 0 || marks > 100) {
                e.preventDefault();
                errorBox.textContent = 'Marks must be a number between 0 and 100.';
                errorBox.classList.remove('d-none');
            }
        });
    }

    // ---- Delete confirmation prompt ----
    document.querySelectorAll('.btn-delete').forEach(function (btn) {
        btn.addEventListener('click', function (e) {
            const ok = confirm('Are you sure you want to delete this student record? This action cannot be undone.');
            if (!ok) {
                e.preventDefault();
            }
        });
    });
});
