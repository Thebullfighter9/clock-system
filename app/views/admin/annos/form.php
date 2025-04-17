<?php ob_start(); ?>
<form method="post" action="/admin/announcement/save" class="card shadow-sm p-4">
  <div class="mb-3">
    <label class="form-label">Title</label>
    <input class="form-control" name="title" required>
  </div>
  <div class="mb-3">
    <label class="form-label">Body (markdown ok)</label>
    <textarea name="body" rows="6" class="form-control" required></textarea>
  </div>
  <button class="btn btn-primary w-100">Publish</button>
</form>
<?php $slot=ob_get_clean(); require __DIR__.'/../layouts/base.php'; ?>
