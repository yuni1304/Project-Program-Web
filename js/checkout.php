<?php
session_start();
require '../adminpanel/koneksi.php';

if (empty($_SESSION['keranjang'])) {
    echo "Keranjang belanja kosong.";
    exit;
}

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Checkout Keranjang | KueCamilan.ID</title> 
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
<?php require 'navbar.php'; ?>

<div class="container py-5">
    <h2 class="fw-bold text-center mb-5">Form Pembelian</h2>

    <form action="snap-checkout.php" method="POST">
        <div class="row">
            <div class="col-md-6 mb-4">
                <div class="card shadow-sm p-4">
                    <h5 class="mb-3 fw-semibold">Informasi Pembeli</h5>
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama Pembeli</label>
                        <input type="text" name="nama_pembeli" id="nama" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="no_hp" class="form-label">Nomor HP</label>
                        <input type="text" name="no_hp" id="no_hp" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="alamat" class="form-label">Alamat Lengkap</label>
                        <textarea name="alamat" id="alamat" class="form-control" rows="3" required></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="kota" class="form-label">Kota Pengiriman</label>
                        <select name="kota" id="kota" class="form-select" required onchange="hitungOngkirDanTotal()">
                            <option value="">-- Pilih Kota --</option>
                            <option value="Batam">Batam</option>
                            <option value="Tanjung Pinang">Tanjung Pinang</option>
                            <option value="Tanjung Balai Karimun">Tanjung Balai Karimun</option>
                            <option value="Lainnya">Lainnya</option>
                        </select>
                    </div>

                    <input type="hidden" name="ongkir" id="ongkir" value="0" />
                    <p class="mt-2 fw-semibold">Ongkir: Rp <span id="ongkirDisplay">0</span></p>

                    <input type="hidden" name="metode_pembayaran" value="cod" />
                    <p class="fw-bold">Bayar di tempat (COD)</p>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card shadow-sm p-4">
                    <h5 class="mb-3 fw-semibold">Detail Pesanan</h5>
                    <div class="table-responsive">
                        <table class="table table-bordered text-center align-middle">
                            <thead class="table-warning text-dark">
                                <tr>
                                    <th>Produk</th>
                                    <th>Harga</th>
                                    <th>Jumlah</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $totalBelanja = 0;
                                foreach ($_SESSION['keranjang'] as $id => $jumlah) {
                                    $queryProduk = mysqli_query($con, "SELECT * FROM produk WHERE id = '$id'");
                                    $produk = mysqli_fetch_assoc($queryProduk);
                                    $subtotal = $produk['harga'] * $jumlah;
                                    $totalBelanja += $subtotal;

                                    echo '
                                    <input type="hidden" name="produk_id[]" value="'. $produk['id'] .'">
                                    <input type="hidden" name="nama_produk[]" value="'. htmlspecialchars($produk['nama']) .'">
                                    <input type="hidden" name="harga[]" value="'. $produk['harga'] .'">
                                    <input type="hidden" name="jumlah[]" value="'. $jumlah .'">
                                    ';
                                ?>
                                <tr>
                                    <td><?= htmlspecialchars($produk['nama']); ?></td>
                                    <td>Rp <?= number_format($produk['harga'], 0, ',', '.'); ?></td>
                                    <td><?= $jumlah; ?></td>
                                    <td>Rp <?= number_format($subtotal, 0, ',', '.'); ?></td>
                                </tr>
                                <?php } ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="3" class="fw-bold">Total Belanja</td>
                                    <td>Rp <?= number_format($totalBelanja, 0, ',', '.'); ?></td>
                                </tr>
                                <tr>
                                    <td colspan="3" class="fw-bold">Ongkir</td>
                                    <td>Rp <span id="ongkirTabel">0</span></td>
                                </tr>
                                <tr class="table-success fw-bold">
                                    <td colspan="3">Total Pembayaran</td>
                                    <td>Rp <span id="totalAkhir"><?= number_format($totalBelanja, 0, ',', '.'); ?></span></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <button type="submit" class="btn warna2 text-white w-100 mt-3">Bayar Sekarang</button>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
    function hitungOngkirDanTotal() {
        const kota = document.getElementById('kota').value;
        let ongkir = kota === "Batam" ? 10000 : (kota ? 30000 : 0);

        const totalBelanja = <?= $totalBelanja; ?>;
        const totalPembayaran = totalBelanja + ongkir;

        document.getElementById('ongkir').value = ongkir;
        document.getElementById('ongkirDisplay').innerText = ongkir.toLocaleString('id-ID');
        document.getElementById('ongkirTabel').innerText = ongkir.toLocaleString('id-ID');
        document.getElementById('totalAkhir').innerText = totalPembayaran.toLocaleString('id-ID');
    }

    document.addEventListener('DOMContentLoaded', hitungOngkirDanTotal);
</script>
</body>
</html>
