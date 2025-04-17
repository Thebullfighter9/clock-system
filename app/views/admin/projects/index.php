<?php ob_start(); ?>
<a href="/admin/project/new" class="btn btn-primary mb-3">New Project</a>
<table class="table table-striped">
<thead><tr><th>Title</th><th>Dept</th><th>Deadline</th><th>Active</th><th></th></tr></thead>
<tbody>
<?php foreach($rows as $r): ?>
<tr>
  <td><?= htmlspecialchars($r['title']) ?></td>
  <td><?= htmlspecialchars($r['dept']) ?></td>
  <td><?= $r['deadline']??'—' ?></td>
  <td><?= $r['active']?'✅':'❌' ?></td>
  <td class="text-end">
      <a href="/admin/project/edit?id=<?= $r['id'] ?>" class="btn btn-sm btn-secondary">Edit</a>
      <a href="/admin/project/delete?id=<?= $r['id'] ?>" class="btn btn-sm btn-danger"
         onclick="return confirm('Delete project?')">Del</a>
  </td>
</tr>
<?php endforeach; ?>
</tbody></table>
<?php $slot=ob_get_clean(); require __DIR__.'/../layouts/base.php'; ?>
