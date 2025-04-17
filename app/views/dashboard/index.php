<?php ob_start(); ?>
<h1 class="h3 mb-4">Welcome, <?= htmlspecialchars($user['first_name']) ?>!</h1>
<p>This is the placeholder dashboard. Clock‑in/out UI goes here next.</p>
<?php $slot = ob_get_clean(); require __DIR__ . '/../layouts/base.php'; ?>
