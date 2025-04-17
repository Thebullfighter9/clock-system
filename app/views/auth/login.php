<?php ob_start(); ?>
<div class="row justify-content-center">
    <div class="col-md-4">
        <?php if (!empty($error)): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        <div class="card shadow-sm">
            <div class="card-body">
                <h4 class="mb-3">Staff Login</h4>
                <form method="post" action="/login">
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" value="<?= htmlspecialchars($email ?? '') ?>" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password / PIN</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <button class="btn btn-primary w‑100">Log in</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php $slot = ob_get_clean(); require __DIR__ . '/../layouts/base.php'; ?>
