<?php require '../includes/db.php'; need_admin(); $base = '../';
$id = (int)($_GET['id'] ?? 0);
$p = ['category_id'=>1,'name'=>'','description'=>'','price'=>'','stock'=>0,'image_url'=>''];
if ($id) { $st = $db->prepare("SELECT * FROM products WHERE id=?"); $st->bind_param('i', $id); $st->execute(); $p = $st->get_result()->fetch_assoc() ?: exit('Tidak ditemukan.'); }
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $cat = (int)$_POST['category_id']; $n = trim($_POST['name']); $d = trim($_POST['description']);
  $pr = (float)$_POST['price']; $s = max(0, (int)$_POST['stock']); $img = trim($_POST['image_url']);
  if ($id) { $st = $db->prepare("UPDATE products SET category_id=?,name=?,description=?,price=?,stock=?,image_url=? WHERE id=?"); $st->bind_param('issdisi', $cat, $n, $d, $pr, $s, $img, $id); }
  else { $st = $db->prepare("INSERT INTO products (category_id,name,description,price,stock,image_url) VALUES (?,?,?,?,?,?)"); $st->bind_param('issdis', $cat, $n, $d, $pr, $s, $img); }
  $st->execute(); header('Location: products.php'); exit;
}
$cats = $db->query("SELECT * FROM categories ORDER BY name");
$title = $id ? 'Edit Produk' : 'Tambah Produk'; include '../includes/header.php'; ?>
<h3><?= e($title) ?></h3>
<form method="post" class="col-md-6">
<div class="mb-2"><label class="form-label">Kategori</label><select name="category_id" class="form-select"><?php foreach ($cats as $c): ?><option value="<?= $c['id'] ?>" <?= $c['id'] == $p['category_id'] ? 'selected' : '' ?>><?= e($c['name']) ?></option><?php endforeach; ?></select></div>
<div class="mb-2"><label class="form-label">Nama produk</label><input name="name" class="form-control" value="<?= e($p['name']) ?>" required></div>
<div class="mb-2"><label class="form-label">Deskripsi</label><textarea name="description" class="form-control" rows="3"><?= e($p['description']) ?></textarea></div>
<div class="row"><div class="col mb-2"><label class="form-label">Harga (Rp)</label><input type="number" min="0" step="100" name="price" class="form-control" value="<?= e($p['price']) ?>" required></div>
<div class="col mb-2"><label class="form-label">Stok</label><input type="number" min="0" name="stock" class="form-control" value="<?= e($p['stock']) ?>" required></div></div>
<div class="mb-3"><label class="form-label">URL gambar</label><input name="image_url" class="form-control" value="<?= e($p['image_url']) ?>"></div>
<button class="btn btn-brand">Simpan produk</button> <a href="products.php" class="btn btn-outline-secondary">Batal</a></form>
<?php include '../includes/footer.php'; ?>
