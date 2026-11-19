<?php require 'includes/db.php';
$cart = &$_SESSION['cart']; $cart = $cart ?? [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $id = (int)($_POST['id'] ?? 0); $qty = max(0, (int)($_POST['qty'] ?? 1));
  $act = $_POST['action'] ?? '';
  if ($act === 'add') $cart[$id] = ($cart[$id] ?? 0) + max(1, $qty);
  elseif ($act === 'update') { if ($qty > 0) $cart[$id] = $qty; else unset($cart[$id]); }
  elseif ($act === 'remove') unset($cart[$id]);
  header('Location: cart.php'); exit;
}
$items = []; $total = 0;
if ($cart) {
  $ids = implode(',', array_map('intval', array_keys($cart)));
  foreach ($db->query("SELECT * FROM products WHERE id IN ($ids)") as $p) {
    $p['qty'] = min($cart[$p['id']], max(1, $p['stock'])); $p['sub'] = $p['qty'] * $p['price'];
    $total += $p['sub']; $items[] = $p;
  }
}
$title = 'Keranjang'; include 'includes/header.php'; ?>
<h3 class="mb-3">Keranjang belanja</h3>
<?php if (!$items): ?><p class="text-muted">Keranjang masih kosong. <a href="index.php">Cari produk</a></p><?php else: ?>
<table class="table align-middle bg-white"><thead><tr><th>Produk</th><th>Harga</th><th style="width:150px">Jumlah</th><th>Subtotal</th><th></th></tr></thead><tbody>
<?php foreach ($items as $p): ?><tr><td><?= e($p['name']) ?></td><td><?= rp($p['price']) ?></td>
<td><form method="post" class="d-flex gap-1"><input type="hidden" name="action" value="update"><input type="hidden" name="id" value="<?= $p['id'] ?>">
<input type="number" name="qty" value="<?= $p['qty'] ?>" min="0" max="<?= (int)$p['stock'] ?>" class="form-control form-control-sm"><button class="btn btn-sm btn-outline-secondary">Ubah</button></form></td>
<td><?= rp($p['sub']) ?></td>
<td><form method="post"><input type="hidden" name="action" value="remove"><input type="hidden" name="id" value="<?= $p['id'] ?>"><button class="btn btn-sm btn-outline-danger">Hapus</button></form></td></tr><?php endforeach; ?>
</tbody><tfoot><tr><th colspan="3" class="text-end">Total</th><th class="price"><?= rp($total) ?></th><th></th></tr></tfoot></table>
<a class="btn btn-brand" href="checkout.php">Lanjut ke checkout</a><?php endif; ?>
<?php include 'includes/footer.php'; ?>
