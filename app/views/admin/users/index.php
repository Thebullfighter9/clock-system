<?php ob_start(); ?>
<a href="/admin/user/new" class="btn btn-primary mb-3">New Employee</a>
<table class="table table-striped">
<thead><tr><th>ID</th><th>Name</th><th>Role</th><th>Rate</th><th></th></tr></thead>
<tbody>
<?php foreach($rows as $r): ?>
<tr>
 <td><?= $r['employee_id'] ?></td>
 <td><?= htmlspecialchars($r['first_name'].' '.$r['last_name']) ?></td>
 <td><?= $r['role'] ?></td>
 <td>$<?= $r['hourly_rate'] ?></td>
 <td class="text-end">
    <a href="/admin/user/edit?id=<?= $r['id'] ?>" class="btn btn-sm btn-secondary">Edit</a>
    <a href="/admin/user/delete?id=<?= $r['id'] ?>" class="btn btn-sm btn-danger"
       onclick="return confirm('Delete employee?')">Del</a>
 </td>
</tr>
<?php endforeach;?>
</tbody></table>
<?php $slot=ob_get_clean(); require __DIR__.'/../layouts/base.php'; ?>
