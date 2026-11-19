<?php $base = $base ?? ''; ?>
<!doctype html><html lang="id"><head><meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title><?= e($title ?? 'Pasar Nusa') ?> - Pasar Nusa</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="<?= $base ?>assets/style.css"></head><body>
<nav class="navbar navbar-expand navbar-dark bg-brand"><div class="container">
<a class="navbar-brand fw-bold" href="<?= $base ?>index.php">Pasar Nusa</a>
<div class="navbar-nav ms-auto">
<a class="nav-link" href="<?= $base ?>cart.php">Keranjang <span class="badge text-bg-light"><?= cart_count() ?></span></a>
<a class="nav-link" href="<?= $base ?>admin/products.php">Admin</a></div></div></nav>
<main class="container py-4">
