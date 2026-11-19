<?php require 'includes/db.php';
$st = $db->prepare("SELECT o.*, c.name, c.email, c.address FROM orders o JOIN customers c ON c.id=o.customer_id WHERE order_code=?");
$code = $_GET['code'] ?? ''; $st->bind_param('s', $code); $st->execute(); $o = $st->get_result()->fetch_assoc();
if (!$o) { http_response_code(404); exit('Pesanan tidak ditemukan.'); }
$st = $db->prepare("SELECT oi.*, p.name FROM order_items oi JOIN products p ON p.id=oi.product_id WHERE order_id=?");
$st->bind_param('i', $o['id']); $st->execute(); $items = $st->get_result();
$title = 'Pesanan ' . $code; include 'includes/header.php'; ?>
<div class="alert alert-success">Pesanan berhasil dibuat. Kode pesanan: <strong><?= e($code) ?></strong></div>
<p>Atas nama <strong><?= e($o['name']) ?></strong> (<?= e($o['email']) ?>)<br>Dikirim ke: <?= e($o['address']) ?><br>Status: <?= e($o['status']) ?></p>
<table class="table bg-white"><tr><th>Produk</th><th>Qty</th><th>Harga</th></tr>
<?php foreach ($items as $i): ?><tr><td><?= e($i['name']) ?></td><td><?= $i['qty'] ?></td><td><?= rp($i['price']) ?></td></tr><?php endforeach; ?>
<tr><th colspan="2" class="text-end">Total</th><th class="price"><?= rp($o['total']) ?></th></tr></table>
<?php include 'includes/footer.php'; ?>
