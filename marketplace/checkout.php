<?php require 'includes/db.php';
$cart = $_SESSION['cart'] ?? []; if (!$cart) { header('Location: cart.php'); exit; }
$err = ''; $f = ['name'=>'','email'=>'','phone'=>'','address'=>''];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  foreach ($f as $k => $_) $f[$k] = trim($_POST[$k] ?? '');
  if (!$f['name'] || !filter_var($f['email'], FILTER_VALIDATE_EMAIL) || !$f['phone'] || !$f['address']) $err = 'Lengkapi semua data dengan benar.';
  else try {
    $db->begin_transaction();
    $total = 0; $lines = [];
    foreach ($cart as $pid => $qty) { $qty = max(1, (int)$qty);
      $st = $db->prepare("SELECT id,name,price,stock FROM products WHERE id=? FOR UPDATE");
      $st->bind_param('i', $pid); $st->execute(); $p = $st->get_result()->fetch_assoc();
      if (!$p || $p['stock'] < $qty) throw new Exception('Stok "' . ($p['name'] ?? 'produk') . '" tidak mencukupi.');
      $lines[] = [$p, $qty]; $total += $p['price'] * $qty;
    }
    $st = $db->prepare("INSERT INTO customers (name,email,phone,address) VALUES (?,?,?,?)");
    $st->bind_param('ssss', $f['name'], $f['email'], $f['phone'], $f['address']); $st->execute(); $cid = $db->insert_id;
    $code = 'ORD' . date('ymd') . strtoupper(substr(bin2hex(random_bytes(3)), 0, 5));
    $st = $db->prepare("INSERT INTO orders (order_code,customer_id,total) VALUES (?,?,?)");
    $st->bind_param('sid', $code, $cid, $total); $st->execute(); $oid = $db->insert_id;
    foreach ($lines as [$p, $qty]) {
      $st = $db->prepare("INSERT INTO order_items (order_id,product_id,qty,price) VALUES (?,?,?,?)");
      $st->bind_param('iiid', $oid, $p['id'], $qty, $p['price']); $st->execute();
      $st = $db->prepare("UPDATE products SET stock=stock-? WHERE id=?");
      $st->bind_param('ii', $qty, $p['id']); $st->execute();
    }
    $db->commit(); $_SESSION['cart'] = [];
    header('Location: order.php?code=' . $code); exit;
  } catch (Exception $ex) { $db->rollback(); $err = $ex->getMessage(); }
}
$title = 'Checkout'; include 'includes/header.php'; ?>
<h3>Data pemesan</h3>
<?php if ($err): ?><div class="alert alert-danger"><?= e($err) ?></div><?php endif; ?>
<form method="post" class="col-md-6">
<?php foreach (['name'=>'Nama lengkap','email'=>'Email','phone'=>'No. telepon'] as $k => $l): ?>
<div class="mb-3"><label class="form-label"><?= $l ?></label><input class="form-control" name="<?= $k ?>" value="<?= e($f[$k]) ?>" required></div><?php endforeach; ?>
<div class="mb-3"><label class="form-label">Alamat pengiriman</label><textarea class="form-control" name="address" rows="3" required><?= e($f['address']) ?></textarea></div>
<button class="btn btn-brand">Buat pesanan</button></form>
<?php include 'includes/footer.php'; ?>
