<?php
function h($v){return htmlspecialchars($v,ENT_QUOTES);}
$clockedIn = (bool)$active;
$hours     = round($secondsToday/3600, 2);
?>
<?php ob_start(); ?>

<h3 class="mb-4">Clock‑In / Clock‑Out</h3>

<div class="card shadow-sm mb-4">
  <div class="card-body text-center">
      <?php if($clockedIn): ?>
          <h4 class="text-success mb-3">You are currently CLOCKED IN</h4>
          <form method="post" action="/clock/out" class="mb-3">
              <input type="text" name="note" class="form-control mb-2" placeholder="Add note (optional)">
              <button class="btn btn-lg btn-danger w-100">Clock OUT</button>
          </form>
      <?php else: ?>
          <h4 class="text-secondary mb-3">You are CLOCKED OUT</h4>
          <form method="post" action="/clock/in" class="mb-3">
              <input type="text" name="note" class="form-control mb-2" placeholder="Add note (optional)">
              <button class="btn btn-lg btn-primary w-100">Clock IN</button>
          </form>
      <?php endif; ?>
  </div>
</div>

<div class="card">
  <div class="card-body">
      <h5 class="mb-2">Today’s total:</h5>
      <p class="display-6"><?= $hours ?> hrs</p>
  </div>
</div>

<?php $slot = ob_get_clean(); require __DIR__.'/../layouts/base.php'; ?>
