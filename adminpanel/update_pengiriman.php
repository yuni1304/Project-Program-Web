<?php
require "session.php";
require "koneksi.php";

// Tangani pembatalan
if (isset($_POST['batal_pesanan'])) {
    $id = intval($_POST['pesanan_id']);
    mysqli_query($con, "UPDATE pesanan SET dibatalkan = 1 WHERE id = $id");
}

// Ambil semua pesanan
$query = mysqli_query($con, "SELECT * FROM pesanan ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Pesanan</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>
<?php require "navbar.php"; ?>

<div class="container mt-4">
    <h2 class="mb-4">Daftar Pesanan</h2>

    <div class="table-responsive">
        <table class="table table-striped">
            <thead class="table-light">
                <tr>
                    <th>No.</th>
                    <th>Produk ID</th>
                    <th>Nama Pembeli</th>
                    <th>No. HP</th>
                    <th>Kota</th>
                    <th>Alamat</th>
                    <th>Tanggal</th>
                    <th>Metode</th>
                    <th>Total</th>
                    <th>Ongkir</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; ?>
                <?php while ($row = mysqli_fetch_assoc($query)): ?>
                    <tr>
                        <td><?= $no++; ?></td>
                        <td><?= $row['produk_id']; ?></td>
                        <td><?= $row['nama_pembeli']; ?></td>
                        <td><?= $row['no_hp']; ?></td>
                        <td><?= $row['kota']; ?></td>
                        <td><?= $row['alamat']; ?></td>
                        <td><?= $row['tanggal_pesan']; ?></td>
                        <td><?= strtoupper($row['metode_pembayaran']); ?></td>
                        <td>Rp<?= number_format($row['total'], 0, ',', '.'); ?></td>
                        <td>Rp<?= number_format($row['ongkir'], 0, ',', '.'); ?></td>
                        <td>
                            <?php if ($row['dibatalkan']): ?>
                                <span class="badge bg-danger">Dibatalkan</span>
                            <?php else: ?>
                                <span class="badge 
                                    <?= $row['status_pengiriman'] == 'Sampai' ? 'bg-success' : ($row['status_pengiriman'] == 'Dikirim' ? 'bg-warning text-dark' : 'bg-secondary'); ?>">
                                    <?= $row['status_pengiriman'] ?? 'Diproses'; ?>
                                </span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if (!$row['dibatalkan'] && $row['status_pengiriman'] != 'Sampai'): ?>
                                <form method="post" class="d-flex gap-1">
                                    <input type="hidden" name="pesanan_id" value="<?= $row['id']; ?>">
                                    <select name="status_pengiriman" class="form-select form-select-sm">
                                        <option selected disabled>Ubah status</option>
                                        <option value="Dikirim">Dikirim</option>
                                        <option value="Sampai">Sampai</option>
                                    </select>
                                    <button type="submit" formaction="update_pengiriman.php" class="btn btn-sm btn-primary">Update</button>
                                    <button type="submit" name="batal_pesanan" class="btn btn-sm btn-danger" onclick="return confirm('Yakin batalkan pesanan ini?')">Batalkan</button>
                                </form>
                            <?php else: ?>
                                <i class="bi bi-check-circle-fill text-muted"></i>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
