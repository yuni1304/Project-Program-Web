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
    <title>Checkout Produk - <?= htmlspecialchars($produk['nama']); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="../css/style.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
</head>
<body>
    <?php require "navbar.php"; ?>

    <div class="container py-5">
        <div class="row align-items-center">
            <div class="col-md-6 mb-4 mb-md-0">
                <div class="text-center">
                    <img src="/image/<?= htmlspecialchars($produk['foto']); ?>" alt="<?= htmlspecialchars($produk['nama']); ?>" class="img-fluid rounded shadow" />
                </div>
            </div>
            <div class="col-md-6">
                <h4 class="mb-3"><?= htmlspecialchars($produk['nama']); ?></h4>
                <h5 class="text-danger mb-3">Rp <span id="hargaProdukDisplay"><?= number_format($produk['harga'], 0, ',', '.'); ?></span></h5>
                <p class="fs-5"><?= nl2br(htmlspecialchars($produk['detail'])); ?></p>

                <form action="snap-checkout.php" method="POST">
                    <input type="hidden" name="produk_id" value="<?= $produk['id']; ?>" />
                    <input type="hidden" name="harga_satuan" id="hargaSatuan" value="<?= $produk['harga']; ?>" />

                    <label for="nama">Nama Pembeli:</label>
                    <input type="text" name="nama" id="nama" class="form-control" required />

                    <label for="no_hp">Nomor HP:</label>
                    <input type="text" name="no_hp" id="no_hp" class="form-control" maxlength="20" required />

                    <label for="alamat">Alamat Lengkap:</label>
                    <textarea name="alamat" id="alamat" class="form-control" rows="3" required></textarea>

                    <label for="jumlah">Jumlah:</label>
                    <input type="number" name="jumlah" id="jumlah" class="form-control" value="1" min="1" required oninput="hitungTotalPembayaran()" />

                    <label for="kota">Kota Pengiriman:</label>
                    <select name="kota" id="kota" class="form-select" required onchange="hitungOngkirDanTotal()">
                        <option value="">-- Pilih Kota --</option>
                        <option value="Batam">Batam</option>
                        <option value="Tanjung Pinang">Tanjung Pinang</option>
                        <option value="Tanjung Balai Karimun">Tanjung Balai Karimun</option>
                        <option value="Lainnya">Lainnya</option>
                    </select>

                    <input type="hidden" name="ongkir" id="ongkir" value="0" />
                    <p class="mt-2">Ongkir: Rp <span id="ongkirDisplay">0</span></p>

                    <label for="totalPembayaranInput">Total Pembayaran:</label>
                    <div class="form-control bg-light fw-bold">
                        <span>Rp</span> <span id="totalPembayaranDisplay"></span>
                    </div>
                    <input type="hidden" name="total" id="totalPembayaranInput" value="0" />

                    <input type="hidden" name="metode_pembayaran" value="cod" />
                    <p class="fw-bold">Bayar di tempat (COD)</p>

                    <button type="submit" class="btn btn-primary mt-4 w-100">Bayar Sekarang</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        function hitungOngkir() {
            const kota = document.getElementById('kota').value;
            let ongkir = 0;
            if (kota === "Batam") ongkir = 10000;
            else if (["Tanjung Pinang", "Tanjung Balai Karimun"].includes(kota)) ongkir = 30000;
            else if (kota === "Lainnya") ongkir = 50000;
            return ongkir;
        }

        function hitungTotalPembayaran() {
            const hargaSatuan = parseFloat(document.getElementById('hargaSatuan').value);
            const jumlah = parseInt(document.getElementById('jumlah').value);
            const ongkir = parseInt(document.getElementById('ongkir').value);
            const totalPembayaran = (hargaSatuan * jumlah) + ongkir;
            document.getElementById('totalPembayaranInput').value = totalPembayaran;
            document.getElementById('totalPembayaranDisplay').innerText = totalPembayaran.toLocaleString('id-ID');
        }

        function hitungOngkirDanTotal() {
            const ongkir = hitungOngkir();
            document.getElementById('ongkir').value = ongkir;
            document.getElementById('ongkirDisplay').innerText = ongkir.toLocaleString('id-ID');
            hitungTotalPembayaran();
        }

        document.addEventListener('DOMContentLoaded', hitungOngkirDanTotal);
    </script>
</body>
</html>
