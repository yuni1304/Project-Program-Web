<?php
session_start();
require '../adminpanel/koneksi.php';

$query = mysqli_query($con, "SELECT * FROM pesanan WHERE dibatalkan = 0 ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Status Pengiriman</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css"> 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
<?php require 'navbar.php'; ?>

<div class="container-fluid banner d-flex align-items-center justify-content-center" style="height: 300px;">
    <div class="text-center text-white px-3">
        <h1 class="fw-bold">Status Pengiriman</h1>
        <p class="fs-5">Lacak status pengiriman pesanan kamu di sini</p>
    </div>
</div>

<div class="container py-5">
    <h2 class="mb-4 text-center">Daftar Pesanan</h2>
    <div class="table-responsive">
        <table class="table table-bordered table-striped align-middle text-center">
            <thead class="table-warning">
                <tr>
                    <th>Nama Pembeli</th>
                    <th>Produk ID</th>
                    <th>Alamat</th>
                    <th>Tanggal</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($query)) : ?>
                    <tr>
                        <td><?= htmlspecialchars($row['nama_pembeli']); ?></td>
                        <td><?= $row['produk_id']; ?></td>
                        <td><?= $row['alamat']; ?></td>
                        <td><?= $row['tanggal_pesan']; ?></td>
                        <td>
                            <?php
                                if ($row['dibatalkan']) {
                                    echo '<span class="text-danger">Dibatalkan</span>';
                                } else {
                                    echo $row['status_pengiriman'] ? htmlspecialchars($row['status_pengiriman']) : '<span class="text-muted">Belum dikirim</span>';
                                }
                            ?>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

<footer style="background: linear-gradient(to right, #DAB894, #FFD966);" class="text-white mt-5 py-4">
    <div class="container text-center">
        <p class="mb-2 fw-semibold text-dark">Hubungi Kami</p>
        <a href="https://wa.me/qr/75SJHWDGP3FED1" target="_blank" class="text-dark text-decoration-none fw-semibold">
            <i class="fab fa-whatsapp fa-2x me-2"></i> Chat via WhatsApp
        </a>
        <p class="mt-3 mb-0 text-dark">&copy; 2025 <strong>KueCamilan.ID</strong>. All Rights Reserved.</p>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
