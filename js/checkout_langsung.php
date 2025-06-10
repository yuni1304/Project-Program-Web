<?php
require '../adminpanel/koneksi.php';

if (!isset($_GET['id'])) {
    echo "Produk tidak ditemukan.";
    exit;
}

$idProduk = (int)$_GET['id'];
$queryProduk = mysqli_query($con, "SELECT * FROM produk WHERE id = $idProduk");
$produk = mysqli_fetch_assoc($queryProduk);

if (!$produk) {
    echo "Produk tidak ditemukan.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <title>Checkout Produk - <?php echo htmlspecialchars($produk['nama']); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="../css/style.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
</head>
<body>
    <?php require "navbar.php"; ?>

    <div class="container-fluid banner d-flex align-items-center justify-content-center">
        <div class="text-center text-white px-3">
            <h1 class="fw-bold">Checkout Produk</h1>
            <p class="fs-5">Selesaikan pembelian produk favoritmu dengan mudah dan cepat</p>
        </div>
    </div>

    <div class="container py-5">
        <div class="row align-items-center">
            <div class="col-md-6 mb-4 mb-md-0">
                <div class="text-center">
                    <img src="/image/<?php echo htmlspecialchars($produk['foto']); ?>" alt="<?php echo htmlspecialchars($produk['nama']); ?>" class="img-fluid rounded shadow" style="max-height: 400px; object-fit: cover; width: 100%;" />
                </div>
            </div>
            <div class="col-md-6">
                <h4 class="mb-3"><?php echo htmlspecialchars($produk['nama']); ?></h4>
                <h5 class="text-danger mb-3">Rp <span id="hargaProdukDisplay"><?php echo number_format($produk['harga'], 0, ',', '.'); ?></span></h5>
                <p class="fs-5"><?php echo nl2br(htmlspecialchars($produk['detail'])); ?></p>

                <form action="snap-checkout.php" method="POST" class="mt-4">
                    <input type="hidden" name="produk_id" value="<?php echo $produk['id']; ?>" />
                    <input type="hidden" name="harga_satuan" id="hargaSatuan" value="<?php echo $produk['harga']; ?>" />

                    <label for="nama" class="form-label">Nama Pembeli:</label>
                    <input type="text" name="nama" id="nama" class="form-control" required />

                    <label for="no_hp" class="form-label mt-3">Nomor HP:</label>
                    <input type="text" name="no_hp" id="no_hp" class="form-control" placeholder="Contoh: 081234567890" maxlength="20" required />

                    <label for="alamat" class="form-label mt-3">Alamat Lengkap:</label>
                    <textarea name="alamat" id="alamat" class="form-control" rows="3" required></textarea>

                    <label for="jumlah" class="form-label mt-3">Jumlah:</label>
                    <input type="number" name="jumlah" id="jumlah" class="form-control" value="1" min="1" required oninput="hitungTotalPembayaran()" />

                    <label for="kota" class="form-label mt-3">Kota Pengiriman:</label>
                    <select name="kota" id="kota" class="form-select" required onchange="hitungOngkirDanTotal()">
                        <option value="">-- Pilih Kota --</option>
                        <option value="Batam">Batam</option>
                        <option value="Tanjung Pinang">Tanjung Pinang</option>
                        <option value="Tanjung Balai Karimun">Tanjung Balai Karimun</option>
                        <option value="Tanjung Pinang Kota">Tanjung Pinang Kota</option>
                        <option value="Lainnya">Lainnya</option>
                    </select>

                    <input type="hidden" name="ongkir" id="ongkir" value="0" />
                    <p class="mt-2 fw-semibold">Ongkir: Rp <span id="ongkirDisplay">0</span></p>

                    <label for="totalPembayaranInput" class="form-label mt-3">Total Pembayaran:</label>
                    <div class="form-control d-flex justify-content-between align-items-center bg-light fw-bold text-dark">
                        <span>Rp</span> <span id="totalPembayaranDisplay" class="ms-1"></span>
                    </div>
                    <input type="hidden" name="total_pembayaran" id="totalPembayaranInput" value="0" />
                    <label for="metode_pembayaran" class="form-label mt-3">Metode Pembayaran:</label>
                    <select name="metode_pembayaran" id="metode_pembayaran" class="form-select" required>
                        <option value="cod">COD (Bayar di tempat)</option>
                        <option value="midtrans">Midtrans (Online Payment)</option>
                    </select>

                    <button type="submit" class="btn btn-primary mt-4 w-100">Bayar Sekarang</button>
                </form>
            </div>
        </div>
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
            hitungOngkirDanTotal();
        });

        function hitungOngkir() {
            const kota = document.getElementById('kota').value;
            let ongkir = 0;
            if (kota === "Batam") {
                ongkir = 10000;
            } else if (kota === "Tanjung Pinang" || kota === "Tanjung Balai Karimun" || kota === "Tanjung Pinang Kota") {
                ongkir = 30000;
            } else if (kota === "Lainnya") {
                ongkir = 50000;
            }
            return ongkir;
        }

        function hitungTotalPembayaran() {
            const hargaSatuan = parseFloat(document.getElementById('hargaSatuan').value);
            const jumlah = parseInt(document.getElementById('jumlah').value);
            const ongkir = parseInt(document.getElementById('ongkir').value);

            if (isNaN(hargaSatuan) || isNaN(jumlah) || jumlah < 1) {
                document.getElementById('totalPembayaranDisplay').innerText = '0';
                document.getElementById('totalPembayaranInput').value = '0';
                return;
            }

            const subtotalProduk = hargaSatuan * jumlah;
            const totalPembayaran = subtotalProduk + ongkir;

            document.getElementById('totalPembayaranInput').value = totalPembayaran;
            document.getElementById('totalPembayaranDisplay').innerText = totalPembayaran.toLocaleString('id-ID');
        }

        function hitungOngkirDanTotal() {
            const ongkir = hitungOngkir();
            document.getElementById('ongkir').value = ongkir;
            document.getElementById('ongkirDisplay').innerText = ongkir.toLocaleString('id-ID');
            hitungTotalPembayaran();
        }
    </script>
</body>
</html>