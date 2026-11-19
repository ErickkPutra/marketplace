<?php require 'includes/db.php';
$st = $db->prepare("SELECT p.*, c.name AS cat FROM products p JOIN categories c ON c.id=p.category_id WHERE p.id=?");
$id = (int)($_GET['id'] ?? 0); $st->bind_param('i', $id); $st->execute();
$p = $st->get_result()->fetch_assoc();
if (!$p) { http_response_code(404); exit('Produk tidak ditemukan.'); }
$title = $p['name']; include 'includes/header.php'; ?>
<div class="row g-4"><div class="col-md-6"><img class="img-fluid rounded" src="<?= e($p['image_url'] ?: 'https://picsum.photos/seed/x/600/400') ?>" alt=""></div>
<div class="col-md-6"><small class="text-muted"><?= e($p['cat']) ?></small><h2><?= e($p['name']) ?></h2>
<div class="price fs-4 mb-2"><?= rp($p['price']) ?></div>
<p><?= nl2br(e($p['description'])) ?></p><p>Stok: <strong><?= (int)$p['stock'] ?></strong></p>
<?php if ($p['stock'] > 0): ?>
<form method="post" action="cart.php" class="d-flex gap-2"><input type="hidden" name="action" value="add"><input type="hidden" name="id" value="<?= $p['id'] ?>">
<input type="number" name="qty" value="1" min="1" max="<?= (int)$p['stock'] ?>" class="form-control" style="width:90px">
<button class="btn btn-brand">Tambah ke keranjang</button></form>
<?php else: ?><div class="alert alert-warning">Stok habis.</div><?php endif; ?></div></div>
<?php include 'includes/footer.php'; ?>
