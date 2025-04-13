<?php
require '../adminpanel/koneksi.php';

if (!isset($_GET['id'])) {
    echo "Produk tidak ditemukan.";
    exit;
}

$idProduk = (int) $_GET['id'];
$queryProduk = mysqli_query($con, "SELECT * FROM produk WHERE id = $idProduk");
$produk = mysqli_fetch_array($queryProduk);

if (!$produk) {
    echo "Produk tidak ditemukan.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Checkout Produk | KueCamilan.ID</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="../css/style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
  <?php require 'navbar.php'; ?>

  <div class="container py-5">
    <h2 class="fw-bold text-center mb-5">Form Pembelian</h2>
    <div class="row">
      <div class="col-md-5">
        <div class="card shadow-sm">
          <img src="/image/<?php echo htmlspecialchars($produk['foto']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($produk['nama']); ?>">
          <div class="card-body">
            <h4 class="card-title"><?php echo htmlspecialchars($produk['nama']); ?></h4>
            <p class="card-text"><?php echo nl2br(htmlspecialchars($produk['detail'])); ?></p>
            <p class="card-text"><strong>Harga:</strong> Rp <?php echo number_format($produk['harga'], 0, ',', '.'); ?></p>
            <p class="card-text"><strong>Stok tersedia:</strong> <?php echo $produk['stok']; ?></p>
          </div>
        </div>
      </div>

      <div class="col-md-7">
        <div class="card shadow-sm p-4">
          <form action="snap-checkout.php" method="POST">
            <input type="hidden" name="produk_id" value="<?php echo $produk['id']; ?>">
            <input type="hidden" name="nama_produk" value="<?php echo htmlspecialchars($produk['nama']); ?>">
            <input type="hidden" name="harga" value="<?php echo $produk['harga']; ?>">

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
              <label for="jumlah" class="form-label">Jumlah Beli</label>
              <input type="number" name="jumlah" id="jumlah" class="form-control" value="1" min="1" max="<?php echo $produk['stok']; ?>" required>
            </div>

            <div class="mb-3">
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

            <button type="submit" class="btn warna2 text-white">Bayar Sekarang</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Footer -->
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
</body>
</html>
