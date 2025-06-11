<?php
session_start();
require '../adminpanel/koneksi.php';

$action = isset($_GET['action']) ? $_GET['action'] : '';
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if (!isset($_SESSION['keranjang'])) {
    $_SESSION['keranjang'] = [];
}

switch ($action) {
    case 'tambah':
        $qty = isset($_POST['jumlah']) ? (int)$_POST['jumlah'] : 1;
        if ($qty < 1) $qty = 1;

        // Validasi apakah produk tersedia di database
        $queryProduk = mysqli_query($con, "SELECT stok FROM produk WHERE id='$id'");
        $produk = mysqli_fetch_assoc($queryProduk);

        if (!$produk) {
            header('Location: keranjang.php?error=Produk tidak ditemukan');
            exit;
        }

        if ($qty > $produk['stok']) {
            $qty = $produk['stok']; // Pastikan tidak melebihi stok
        }

        if ($id != '') {
            if (isset($_SESSION['keranjang'][$id])) {
                $_SESSION['keranjang'][$id] += $qty;
            } else {
                $_SESSION['keranjang'][$id] = $qty;
            }
        }
        header('Location: keranjang.php');
        exit;

    case 'hapus':
        if ($id != '' && isset($_SESSION['keranjang'][$id])) {
            unset($_SESSION['keranjang'][$id]);
        }
        header('Location: keranjang.php');
        exit;

    case 'clear':
        $_SESSION['keranjang'] = [];
        header('Location: keranjang.php');
        exit;

    default:
        header('Location: produk.php');
        exit;
}
?>
