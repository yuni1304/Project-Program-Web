<?php
require '../adminpanel/koneksi.php';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Status Pengiriman | KueCamilan.ID</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css"> 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body class="bg-soft">

<?php require 'navbar.php'; ?>

<div class="container-fluid banner d-flex align-items-center justify-content-center" style="height: 300px;">
    <div class="text-center text-white px-3">
        <h1 class="fw-bold">Status Pengiriman</h1>
        <p class="fs-5">Lacak status pengiriman pesanan kamu di sini</p>
    </div>
</div>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="form-box mb-4">
                <h4 class="mb-3">Masukkan Nomor ID Pemesanan Anda</h4>
                <form method="get">
                    <div class="mb-3">
                        <input type="number" class="form-control" id="id" name="id" placeholder="Contoh: 125" required>
                    </div>
                    <div class="d-grid">
                        <button class="btn btn-warning fw-bold" type="submit">
                            <i class="fas fa-search me-1"></i> Cek Status
                        </button>
                    </div>
                </form>
            </div>

            <?php
            if (isset($_GET['id']) && is_numeric($_GET['id'])) {
                $id = (int)$_GET['id'];
                $cek = mysqli_query($con, "SELECT * FROM pesanan WHERE id = $id");

                if (mysqli_num_rows($cek) > 0) {
                    $data = mysqli_fetch_assoc($cek);
                    ?>
                    <div class="card status-card mb-4">
                        <div class="card-header bg-light">
                            <h5 class="mb-0">Status Pemesanan ID: <strong><?= htmlspecialchars($id); ?></strong></h5>
                        </div>
                        <div class="card-body">
                            <p><strong>Nama Pembeli:</strong> <?= htmlspecialchars($data['nama_pembeli']); ?></p>
                            <p><strong>Alamat:</strong> <?= htmlspecialchars($data['alamat']); ?></p>
                            <p><strong>No HP:</strong> <?= htmlspecialchars($data['no_hp']); ?></p>
                            <p><strong>Tanggal Pemesanan:</strong> <?= date('d M Y', strtotime($data['tanggal_pesan'])); ?></p>
                            <p><strong>Jumlah Produk:</strong> <?= $data['jumlah']; ?></p>
                            <p><strong>Total Pembayaran:</strong> Rp <?= number_format($data['total'], 0, ',', '.'); ?></p>
                            <p><strong>Status Pengiriman:</strong>
                                <span class="badge bg-<?= 
                                    $data['status_pengiriman'] === 'Sampai' ? 'success' : (
                                    $data['status_pengiriman'] === 'Dikirim' ? 'primary' : 'warning'); ?>">
                                    <?= $data['status_pengiriman']; ?>
                                </span>
                            </p>
                        </div>
                    </div>
                    <?php
                } else {
                    echo "<div class='alert alert-danger text-center'>ID pemesanan <strong>" . htmlspecialchars($id) . "</strong> tidak ditemukan.</div>";
                }
            }
            ?>
        </div>
    </div>
</div>

<footer class="footer-kue text-white mt-5 py-4">
    <div class="container text-center">
        <p class="mb-2 fw-semibold text-dark">Hubungi Kami</p>
        <a href="https://wa.me/qr/75SJHWDGP3FED1" target="_blank" class="text-dark text-decoration-none fw-semibold">
            <i class="fab fa-whatsapp fa-2x me-2"></i> Chat via WhatsApp
        </a>
        <p class="mt-3 mb-0 text-dark">&copy; 2025 <strong>KueCamilan.ID</strong>. All Rights Reserved.</p>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/js/all.min.js"></script>
</body>
</html>
