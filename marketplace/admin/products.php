<?php require '../includes/db.php'; need_admin(); $base = '../'; $msg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  try { $st = $db->prepare("DELETE FROM products WHERE id=?"); $id = (int)$_POST['id']; $st->bind_param('i', $id); $st->execute(); $msg = 'Produk dihapus.'; }
  catch (mysqli_sql_exception $x) { $msg = 'Produk tidak bisa dihapus karena sudah ada di pesanan.'; }
}
$rows = $db->query("SELECT p.*, c.name cat FROM products p JOIN categories c ON c.id=p.category_id ORDER BY p.id DESC");
$title = 'Kelola Produk'; include '../includes/header.php'; ?>
<div class="d-flex justify-content-between mb-3"><h3>Kelola produk</h3>
<div><a class="btn btn-brand" href="product_form.php">Tambah produk</a> <a class="btn btn-outline-secondary" href="orders.php">Pesanan</a> <a class="btn btn-outline-secondary" href="logout.php">Keluar</a></div></div>
<?php if ($msg): ?><div class="alert alert-info"><?= e($msg) ?></div><?php endif; ?>
<table class="table bg-white align-middle"><tr><th>Nama</th><th>Kategori</th><th>Harga</th><th>Stok</th><th></th></tr>
<?php foreach ($rows as $p): ?><tr><td><?= e($p['name']) ?></td><td><?= e($p['cat']) ?></td><td><?= rp($p['price']) ?></td><td><?= $p['stock'] ?></td>
<td class="d-flex gap-1"><a class="btn btn-sm btn-outline-primary" href="product_form.php?id=<?= $p['id'] ?>">Edit</a>
<form method="post" onsubmit="return confirm('Hapus produk ini?')"><input type="hidden" name="id" value="<?= $p['id'] ?>"><button class="btn btn-sm btn-outline-danger">Hapus</button></form></td></tr><?php endforeach; ?></table>
<?php include '../includes/footer.php'; ?>
