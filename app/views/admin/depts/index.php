<?php ob_start(); ?>
<a href="/admin/dept/new" class="btn btn-primary mb-3">New Department</a>

<table class="table table-striped">
<thead><tr><th>Name</th><th>Pay&nbsp;×</th><th></th></tr></thead>
<tbody>
<?php foreach($rows as $r): ?>
<tr>
  <td><?= htmlspecialchars($r['name']) ?></td>
  <td><?= $r['pay_modifier'] ?></td>
  <td class="text-end">
      <a href="/admin/dept/edit?id=<?= $r['id'] ?>" class="btn btn-sm btn-secondary">Edit</a>
      <a href="/admin/dept/delete?id=<?= $r['id'] ?>" class="btn btn-sm btn-danger" 
         onclick="return confirm('Delete department?')">Del</a>
  </td>
</tr>
<?php endforeach; ?>
</tbody></table>
<?php $slot=ob_get_clean(); require __DIR__.'/../layouts/base.php'; ?>
