<?php require '../includes/db.php'; $base = '../'; $err = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (hash_equals(ADMIN_USER, $_POST['u'] ?? '') && hash_equals(ADMIN_PASS, $_POST['p'] ?? '')) { $_SESSION['admin'] = 1; header('Location: products.php'); exit; }
  $err = 'Username atau password salah.';
}
$title = 'Login Admin'; include '../includes/header.php'; ?>
<form method="post" class="col-md-4"><h3>Login admin</h3>
<?php if ($err): ?><div class="alert alert-danger"><?= e($err) ?></div><?php endif; ?>
<input class="form-control mb-2" name="u" placeholder="Username" required><input class="form-control mb-3" type="password" name="p" placeholder="Password" required>
<button class="btn btn-brand">Masuk</button></form><?php include '../includes/footer.php'; ?>
