<?php
session_start();
require __DIR__ . '/../config.php';
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$db = new mysqli($DB['host'], $DB['user'], $DB['pass'], $DB['name']);
$db->set_charset('utf8mb4');
function e($s) { return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8'); }
function rp($n) { return 'Rp ' . number_format((float)$n, 0, ',', '.'); }
function need_admin() { if (empty($_SESSION['admin'])) { header('Location: login.php'); exit; } }
function cart_count() { return array_sum($_SESSION['cart'] ?? []); }
