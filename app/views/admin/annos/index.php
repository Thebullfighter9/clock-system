<?php ob_start(); ?>
<a href="/admin/announcement/new" class="btn btn-primary mb-3">New Announcement</a>
<ul class="list-group">
  <?php foreach($rows as $r): ?>
  <li class="list-group-item">
     <h5 class="mb-1"><?= htmlspecialchars($r['title']) ?></h5>
     <small class="text-muted"><?= $r['published_at'] ?> &middot; <?= htmlspecialchars($r['author']) ?></small>
     <p class="mb-0"><?= nl2br(htmlspecialchars($r['body'])) ?></p>
  </li>
  <?php endforeach;?>
</ul>
<?php $slot=ob_get_clean(); require __DIR__.'/../layouts/base.php'; ?>
