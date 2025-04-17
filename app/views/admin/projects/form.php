<?php ob_start(); $p=$row??[]; ?>
<form method="post" action="/admin/project/save" class="card shadow-sm p-4">
    <input type="hidden" name="id" value="<?= $p['id']??'' ?>">
    <div class="mb-3">
        <label class="form-label">Title</label>
        <input class="form-control" name="title" value="<?= htmlspecialchars($p['title']??'') ?>" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Department</label>
        <select class="form-select" name="department_id">
            <?php foreach($depts as $d): ?>
                <option value="<?= $d['id'] ?>" <?= ($p['department_id']??0)==$d['id']?'selected':'' ?>>
                    <?= htmlspecialchars($d['name']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="mb-3">
        <label class="form-label">Deadline</label>
        <input type="date" name="deadline" class="form-control" value="<?= $p['deadline']??'' ?>">
    </div>
    <div class="mb-3">
        <label class="form-label">Pay modifier ×</label>
        <input type="number" step="0.01" min="0" name="pay_modifier" class="form-control" value="<?= $p['pay_modifier']??1 ?>">
    </div>
    <div class="mb-3">
        <label class="form-label">Description</label>
        <textarea name="description" rows="4" class="form-control"><?= htmlspecialchars($p['description']??'') ?></textarea>
    </div>
    <div class="form-check mb-3">
        <input class="form-check-input" type="checkbox" name="active" value="1" <?= ($p['active']??1)?'checked':'' ?>>
        <label class="form-check-label">Active</label>
    </div>
    <button class="btn btn-primary w-100">Save</button>
</form>
<?php $slot=ob_get_clean(); require __DIR__.'/../layouts/base.php'; ?>
