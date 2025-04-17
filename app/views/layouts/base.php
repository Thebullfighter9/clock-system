<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width,initial-scale=1"/>
  <title><?= $title ?? 'Clock‑System'; ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container">
    <a class="navbar-brand" href="/">CircuitDreamStudios</a>
    <?php if (!empty($_SESSION['uid'])): ?>
      <a class="nav-link text-white ms-3" href="/clock">Clock</a>
      <a class="nav-link text-white ms-3" href="/admin/projects">Admin</a>
      <a class="nav-link text-white ms-3" href="/report/daily" target="_blank">Today PDF</a>
      <a class="nav-link text-white ms-3" href="/payroll/weekly">Payroll (Week)</a>  <!-- ← NEW -->
      <form class="ms-auto" method="post" action="/logout">
        <button class="btn btn-sm btn-outline-light">Logout</button>
      </form>
    <?php endif; ?>
  </div>
</nav>
<main class="container py-4">
  <?= $slot ?? '' ?>
</main>
</body>
</html>
