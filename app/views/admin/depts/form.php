<?php ob_start(); ?>
<form method="post" action="/admin/dept/save" class="card shadow-sm p-4">
    <input type="hidden" name="id" value="<?= $row['id']??'' ?>">
    <div class="mb-3">
        <label class="form-label">Name</label>
        <input class="form-control" name="name" value="<?= htmlspecialchars($row['name']??'') ?>" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Pay&nbsp;modifier ×</label>
        <input type="number" step="0.01" min="0" class="form-control" name="pay_modifier"
               value="<?= $row['pay_modifier']??1 ?>">
    </div>
    <button class="btn btn-primary w-100">Save</button>
</form>
<?php $slot=ob_get_clean(); require __DIR__.'/../layouts/base.php'; ?>
