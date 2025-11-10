<?php
$profileUser = $data['user'] ?? $user ?? null;
?>
<div class="row g-4">
    <div class="col-lg-6">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-body">
                <h2 class="h5 mb-3">Update password</h2>
                <p class="text-muted small">Use a strong password with at least 8 characters. After updating you will continue in the current session.</p>
                <form method="post" class="needs-validation" novalidate>
                    <?php echo Csrf::field(); ?>
                    <div class="mb-3">
                        <label for="current_password" class="form-label">Current password</label>
                        <input type="password" name="current_password" id="current_password" class="form-control" required minlength="8">
                        <div class="invalid-feedback">Please enter your current password.</div>
                    </div>
                    <div class="mb-3">
                        <label for="new_password" class="form-label">New password</label>
                        <input type="password" name="new_password" id="new_password" class="form-control" required minlength="8">
                        <div class="invalid-feedback">Enter a new password with at least 8 characters.</div>
                    </div>
                    <div class="mb-3">
                        <label for="confirm_password" class="form-label">Confirm new password</label>
                        <input type="password" name="confirm_password" id="confirm_password" class="form-control" required minlength="8">
                        <div class="invalid-feedback">Confirm the new password.</div>
                    </div>
                    <button type="submit" class="btn btn-primary">Save password</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-body">
                <h2 class="h5 mb-3">Account details</h2>
                <?php if ($profileUser): ?>
                    <dl class="row mb-0">
                        <dt class="col-sm-4 text-muted">Name</dt>
                        <dd class="col-sm-8"><?php echo e($profileUser['name'] ?? ''); ?></dd>
                        <dt class="col-sm-4 text-muted">Email</dt>
                        <dd class="col-sm-8"><?php echo e($profileUser['email'] ?? ''); ?></dd>
                        <dt class="col-sm-4 text-muted">Role</dt>
                        <dd class="col-sm-8 text-uppercase small"><?php echo e($profileUser['role'] ?? 'admin'); ?></dd>
                    </dl>
                <?php else: ?>
                    <p class="text-muted mb-0">Account information unavailable.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

