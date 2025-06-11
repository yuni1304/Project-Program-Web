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
                        <input type="text" name="nama" id="nama" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="nohp" class="form-label">No HP</label>
                        <input type="text" name="nohp" id="nohp" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="alamat" class="form-label">Alamat</label>
                        <textarea name="alamat" id="alamat" class="form-control" rows="3" required></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="kota" class="form-label">Kota</label>
                        <select name="kota" id="kota" class="form-select" onchange="hitungOngkir()" required>
                            <option value="">-- Pilih Kota --</option>
                            <option value="Batam">Batam</option>
                            <option value="Tanjung Pinang">Tanjung Pinang</option>
                            <option value="Tanjung Balai Karimun">Tanjung Balai Karimun</option>
                            <option value="Lainnya">Lainnya</option>
                        </select>
                    </div>

                    <input type="hidden" name="ongkir" id="ongkir" value="0" />
                    <p class="mt-2 fw-semibold">Ongkir: Rp <span id="ongkirDisplay">0</span></p>

                    <div class="mb-3 mt-3">
                        <label class="form-label">Metode Pembayaran</label><br>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="metode_pembayaran" id="cod" value="cod" checked>
                            <label class="form-check-label" for="cod">COD (Bayar di Tempat)</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="metode_pembayaran" id="midtrans" value="midtrans">
                            <label class="form-check-label" for="midtrans">Transfer Otomatis (Midtrans)</label>
                        </div>
                    </div>
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
                                $totalBelanja = 0; // Inisialisasi total belanja di sini
                                foreach ($_SESSION['keranjang'] as $id => $jumlah) {
                                    $queryProduk = mysqli_query($con, "SELECT * FROM produk WHERE id = '$id'");
                                    $produk = mysqli_fetch_assoc($queryProduk); // $produk sekarang didefinisikan di dalam loop
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
                                    <td><?php echo htmlspecialchars($produk['nama']); ?></td>
                                    <td>Rp <?php echo number_format($produk['harga'], 0, ',', '.'); ?></td>
                                    <td><?php echo $jumlah; ?></td>
                                    <td>Rp <?php echo number_format($subtotal, 0, ',', '.'); ?></td>
                                </tr>
                                <?php } ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="3" class="fw-bold">Total Belanja</td>
                                    <td>Rp <?php echo number_format($totalBelanja, 0, ',', '.'); ?></td>
                                </tr>
                                <tr>
                                    <td colspan="3" class="fw-bold">Ongkir</td>
                                    <td>Rp <span id="ongkirTabel">0</span></td>
                                </tr>
                                <tr class="table-success fw-bold">
                                    <td colspan="3">Total Pembayaran</td>
                                    <td>Rp <span id="totalAkhir"><?php echo number_format($totalBelanja, 0, ',', '.'); ?></span></td>
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


<hr>
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

<script>
    document.addEventListener('DOMContentLoaded', function() {
        hitungOngkir();
    });

    function hitungOngkir() {
        const kota = document.getElementById('kota').value;
        const ongkirInput = document.getElementById('ongkir');
        const ongkirDisplay = document.getElementById('ongkirDisplay');
        const ongkirTabel = document.getElementById('ongkirTabel');
        const totalAkhir = document.getElementById('totalAkhir');

        let ongkir = 0;
        if (kota === "Batam") {
            ongkir = 10000;
        } else if (kota !== "") {
            ongkir = 30000;
        }

        const totalBelanja = <?php echo $totalBelanja; ?>;
        const totalSemua = totalBelanja + ongkir;

        ongkirInput.value = ongkir;
        ongkirDisplay.innerText = ongkir.toLocaleString('id-ID');
        if (ongkirTabel) ongkirTabel.innerText = ongkir.toLocaleString('id-ID');
        if (totalAkhir) totalAkhir.innerText = totalSemua.toLocaleString('id-ID');
    }
</script>
</body>
</html>