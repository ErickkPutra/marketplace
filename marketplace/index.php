<?php require 'includes/db.php'; $title = 'Daftar Produk';
$q = trim($_GET['q'] ?? ''); $cat = (int)($_GET['cat'] ?? 0);
$like = "%$q%";
$st = $db->prepare("SELECT p.*, c.name AS cat FROM products p JOIN categories c ON c.id=p.category_id
  WHERE p.name LIKE ? AND (?=0 OR p.category_id=?) ORDER BY p.id DESC");
$st->bind_param('sii', $like, $cat, $cat); $st->execute(); $rows = $st->get_result();
$cats = $db->query("SELECT * FROM categories ORDER BY name");
include 'includes/header.php'; ?>
<form class="row g-2 mb-4" method="get">
  <div class="col-md-5"><input class="form-control" name="q" placeholder="Cari produk" value="<?= e($q) ?>"></div>
  <div class="col-md-4"><select class="form-select" name="cat"><option value="0">Semua kategori</option>
  <?php foreach ($cats as $c): ?><option value="<?= $c['id'] ?>" <?= $cat == $c['id'] ? 'selected' : '' ?>><?= e($c['name']) ?></option><?php endforeach; ?></select></div>
  <div class="col-md-3"><button class="btn btn-brand w-100">Cari</button></div>
</form>
<div class="row g-3">
<?php foreach ($rows as $p): ?>
  <div class="col-6 col-md-4 col-lg-3"><div class="card h-100">
    <img src="<?= e($p['image_url'] ?: 'https://picsum.photos/seed/x/600/400') ?>" class="card-img-top" alt="<?= e($p['name']) ?>">
    <div class="card-body d-flex flex-column"><small class="text-muted"><?= e($p['cat']) ?></small>
      <h6><?= e($p['name']) ?></h6><div class="price mb-3"><?= rp($p['price']) ?></div>
      <a class="btn btn-outline-secondary btn-sm mt-auto" href="product.php?id=<?= $p['id'] ?>">Lihat detail</a></div></div></div>
<?php endforeach; if (!$rows->num_rows) echo '<p class="text-muted">Produk tidak ditemukan. Coba kata kunci lain.</p>'; ?>
</div><?php include 'includes/footer.php'; ?>
