<?php
session_start();

$action = $_GET['action'] ?? '';
$id = $_GET['id'] ?? '';

if (!isset($_SESSION['keranjang'])) {
    $_SESSION['keranjang'] = [];
}

switch ($action) {
    case 'tambah':
        $qty = isset($_POST['jumlah']) ? (int)$_POST['jumlah'] : 1;
        if ($qty < 1) $qty = 1;
        if ($id != '') {
            if (isset($_SESSION['keranjang'][$id])) {
                $_SESSION['keranjang'][$id] += $qty;
            } else {
                $_SESSION['keranjang'][$id] = $qty;
            }
        }
        header('Location: keranjang.php');
        break;

    case 'hapus':
        if ($id != '' && isset($_SESSION['keranjang'][$id])) {
            unset($_SESSION['keranjang'][$id]);
        }
        header('Location: keranjang.php');
        break;

    case 'clear':
        $_SESSION['keranjang'] = [];
        header('Location: keranjang.php');
        break;

    default:
        header('Location: produk.php');
        break;
}
