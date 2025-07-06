<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();
require '../adminpanel/koneksi.php';

$pesanan = null;
if (isset($_SESSION['pesanan_terakhir'])) {
    $idPesanan = $_SESSION['pesanan_terakhir'];
    $result = mysqli_query($con, "SELECT * FROM pesanan WHERE id = $idPesanan");

    if ($result && mysqli_num_rows($result) > 0) {
        $pesanan = mysqli_fetch_assoc($result);
    }

    unset($_SESSION['pesanan_terakhir']);
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Pesanan Berhasil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="text-center py-5">
    <h2>🎉 Pesanan Berhasil!</h2>
    <p>Terima kasih telah melakukan pemesanan. Pesanan kamu akan segera diproses.</p>

    <?php if ($pesanan): ?>
    <div class="container mt-4">
        <h5>Detail Pesanan:</h5>
        <ul class="list-unstyled">
            <li><strong>Produk ID:</strong> <?= $pesanan['produk_id']; ?></li>
            <li><strong>Nama:</strong> <?= htmlspecialchars($pesanan['nama_pembeli']); ?></li>
            <li><strong>Total:</strong> Rp <?= number_format($pesanan['total'], 0, ',', '.'); ?></li>
            <li><strong>Status Pengiriman:</strong> <?= $pesanan['status_pengiriman']; ?></li>
        </ul>
    </div>
    <?php else: ?>
    <p class="text-danger">Data pesanan tidak ditemukan atau sesi sudah habis.</p>
    <?php endif; ?>

    <a href="index.php" class="btn btn-primary mt-3">Kembali ke Beranda</a>
</body>
</html>
