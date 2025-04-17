<?php ob_start(); $u=$row??[];?>
<form method="post" action="/admin/user/save" class="card shadow-sm p-4">
<input type="hidden" name="id" value="<?= $u['id']??'' ?>">
<div class="row g-3">
  <div class="col-md-6">
    <label class="form-label">First name</label>
    <input class="form-control" name="first_name" value="<?= $u['first_name']??'' ?>" required>
  </div>
  <div class="col-md-6">
    <label class="form-label">Last name</label>
    <input class="form-control" name="last_name" value="<?= $u['last_name']??'' ?>" required>
  </div>
</div>
<div class="mb-3 mt-3">
  <label class="form-label">Email</label>
  <input type="email" class="form-control" name="email" value="<?= $u['email']??'' ?>" required>
</div>
<div class="mb-3">
  <label class="form-label">Role</label>
  <select class="form-select" name="role">
    <?php foreach(['employee','head','admin','founder'] as $r): ?>
      <option value="<?= $r ?>" <?= ($u['role']??'employee')==$r?'selected':'' ?>><?= ucfirst($r) ?></option>
    <?php endforeach; ?>
  </select>
</div>
<div class="mb-3">
  <label class="form-label">Hourly rate ($)</label>
  <input type="number" step="0.01" min="0" name="hourly_rate" class="form-control" value="<?= $u['hourly_rate']??0 ?>">
</div>
<div class="mb-3">
  <label class="form-label">Password (leave blank to keep)</label>
  <input type="password" class="form-control" name="password">
</div>
<button class="btn btn-primary w-100">Save</button>
</form>
<?php $slot=ob_get_clean(); require __DIR__.'/../layouts/base.php'; ?>
