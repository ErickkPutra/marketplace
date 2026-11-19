<?php require '../includes/db.php'; need_admin(); $base = '../'; $title = 'Pesanan';
$rows = $db->query("SELECT o.*, c.name FROM orders o JOIN customers c ON c.id=o.customer_id ORDER BY o.id DESC");
include '../includes/header.php'; ?>
<h3>Daftar pesanan</h3><a href="products.php">Kembali ke produk</a>
<table class="table bg-white mt-3"><tr><th>Kode</th><th>Pembeli</th><th>Total</th><th>Status</th><th>Waktu</th></tr>
<?php foreach ($rows as $o): ?><tr><td><a href="../order.php?code=<?= e($o['order_code']) ?>"><?= e($o['order_code']) ?></a></td><td><?= e($o['name']) ?></td><td><?= rp($o['total']) ?></td><td><?= e($o['status']) ?></td><td><?= e($o['created_at']) ?></td></tr><?php endforeach; ?></table>
<?php include '../includes/footer.php'; ?>
