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
    <title>Pesanan Berhasil | KueCamilan.ID</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body class="py-5 custom-bg">

    <div class="container">
        <div class="success-box text-center">
            <div class="checkmark mb-3">
                <i class="fas fa-check-circle"></i>
            </div>
            <h2 class="mb-3">Pesanan Berhasil!</h2>
            <p class="lead mb-4">Terima kasih telah melakukan pemesanan. Pesanan kamu akan segera kami proses.</p>

            <?php if ($pesanan): ?>
                <div class="text-start mb-4">
                    <h5 class="fw-bold">Detail Pesanan:</h5>
                    <ul class="list-unstyled ms-2">
                        <li><strong>ID Pesanan:</strong> <?= $pesanan['id']; ?></li>
                        <li><strong>Produk ID:</strong> <?= $pesanan['produk_id']; ?></li>
                        <li><strong>Nama Pembeli:</strong> <?= htmlspecialchars($pesanan['nama_pembeli']); ?></li>
                        <li><strong>Total:</strong> Rp <?= number_format($pesanan['total'], 0, ',', '.'); ?></li>
                        <li><strong>Status Pengiriman:</strong> 
                            <span class="badge bg-<?= 
                                $pesanan['status_pengiriman'] === 'Sampai' ? 'success' : (
                                $pesanan['status_pengiriman'] === 'Dikirim' ? 'primary' : 'warning'); ?>">
                                <?= $pesanan['status_pengiriman']; ?>
                            </span>
                        </li>
                    </ul>
                </div>

                <div class="d-flex justify-content-center gap-3">
                    <a href="index.php" class="btn btn-outline-secondary btn-custom">
                        <i class="fas fa-home me-1"></i> Beranda
                    </a>
                    <a href="http://localhost:3000/js/status_pengiriman.php?id=<?= $pesanan['id']; ?>" class="btn btn-success btn-custom">
                        <i class="fas fa-truck me-1"></i> Lihat Status Pengiriman
                    </a>
                </div>
            <?php else: ?>
                <p class="text-danger">Data pesanan tidak ditemukan atau sesi sudah habis.</p>
                <a href="index.php" class="btn btn-primary mt-3 btn-custom">Kembali ke Beranda</a>
            <?php endif; ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
