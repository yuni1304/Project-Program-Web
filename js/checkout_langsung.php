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
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="../css/style.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
</head>
<body>
  <?php require "navbar.php"; ?>

  <!-- Banner -->
  <div class="container-fluid banner d-flex align-items-center justify-content-center" style="height: 300px;">
    <div class="text-center text-white">
      <h1 class="fw-bold">Checkout Produk</h1>
      <p class="fs-5">Selesaikan pembelian produk favoritmu dengan mudah dan cepat</p>
    </div>
  </div>

  <!-- Konten Utama -->
  <div class="container py-5">
    <div class="row align-items-center">
      <div class="col-md-6 mb-4 mb-md-0 text-center">
        <img src="/image/<?php echo htmlspecialchars($produk['foto']); ?>" alt="<?php echo htmlspecialchars($produk['nama']); ?>" class="img-fluid rounded shadow" style="max-height: 400px; object-fit: cover; width: 100%;" />
      </div>
      <div class="col-md-6">
        <h4 class="mb-3"><?php echo htmlspecialchars($produk['nama']); ?></h4>
        <h5 class="text-danger mb-3">Rp <?php echo number_format($produk['harga'], 0, ',', '.'); ?></h5>
        <p class="fs-5"><?php echo nl2br(htmlspecialchars($produk['detail'])); ?></p>

        <!-- Form beli langsung -->
        <form action="snap-checkout.php" method="POST" class="mt-4">
          <input type="hidden" name="produk_id" value="<?php echo $produk['id']; ?>" />
          <input type="hidden" name="harga" value="<?php echo $produk['harga']; ?>" />

          <label for="nama" class="form-label">Nama Pembeli:</label>
          <input type="text" name="nama" id="nama" class="form-control" required />

          <label for="alamat" class="form-label mt-3">Alamat:</label>
          <textarea name="alamat" id="alamat" class="form-control" rows="3" required></textarea>

          <label for="jumlah" class="form-label mt-3">Jumlah:</label>
          <input type="number" name="jumlah" id="jumlah" class="form-control" value="1" min="1" required />

          <label for="kota" class="form-label mt-3">Kota:</label>
          <select name="kota" id="kota" class="form-select" required onchange="hitungOngkir()">
            <option value="">-- Pilih Kota --</option>
            <option value="Batam">Batam</option>
            <option value="Tanjung Pinang">Tanjung Pinang</option>
            <option value="Tanjung Balai Karimun">Tanjung Balai Karimun</option>
            <option value="Tanjung Pinang Kota">Tanjung Pinang Kota</option>
            <option value="Lainnya">Lainnya</option>
          </select>

          <input type="hidden" name="ongkir" id="ongkir" value="0" />
          <p class="mt-2 fw-semibold">Ongkir: Rp <span id="ongkirDisplay">0</span></p>

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

  <!-- footer -->
  <footer style="background: linear-gradient(to right, #DAB894, #FFD966);" class="text-white py-4">
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
    function hitungOngkir() {
      const kota = document.getElementById('kota').value;
      const ongkirInput = document.getElementById('ongkir');
      const ongkirDisplay = document.getElementById('ongkirDisplay');

      let ongkir = 0;
      if (kota === "Batam") {
        ongkir = 10000;
      } else if (kota !== "") {
        ongkir = 30000;
      }

      ongkirInput.value = ongkir;
      ongkirDisplay.innerText = ongkir.toLocaleString('id-ID');
    }
  </script>
</body>
</html>
