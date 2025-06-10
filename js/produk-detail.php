<?php
require '../adminpanel/koneksi.php';

if (!isset($_GET['nama'])) {
    echo "Produk tidak ditemukan.";
    exit;
}

$namaProduk = mysqli_real_escape_string($con, $_GET['nama']);
$queryProduk = mysqli_query($con, "SELECT * FROM produk WHERE nama='$namaProduk'");
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
  <title><?php echo htmlspecialchars($produk['nama']); ?> | KueCamilan.ID</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="../css/style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
  <?php require "navbar.php"; ?>

  <div class="container-fluid banner-produk d-flex align-items-center justify-content-center">
    <h1 class="text-white fw-bold"><?php echo htmlspecialchars($produk['nama']); ?></h1>
  </div>

  <div class="container py-5">
    <div class="row">
      <div class="col-md-5">
        <div class="image-box">
          <img src="/image/<?php echo htmlspecialchars($produk['foto']); ?>" class="img-fluid rounded shadow" alt="<?php echo htmlspecialchars($produk['nama']); ?>">
        </div>
      </div>
      <div class="col-md-7">
        <h2 class="fw-bold mb-3"><?php echo htmlspecialchars($produk['nama']); ?></h2>
        <h4 class="text-harga mb-3">Rp <?php echo number_format($produk['harga'], 0, ',', '.'); ?></h4>

        <p class="mb-2"><strong>Ketersediaan:</strong> <?php echo htmlspecialchars($produk['ketersediaan_stok']); ?></p>
        <p class="mb-2"><strong>Stok Tersedia:</strong> <?php echo (int)$produk['stok']; ?></p>

        <p class="mb-4"><strong>Deskripsi:</strong><br><?php echo nl2br(htmlspecialchars($produk['detail'])); ?></p>

        <a href="checkout_langsung.php?id=<?php echo $produk['id']; ?>&qty=1" class="btn warna2 text-white me-2">Beli Sekarang</a>
        <a href="produk.php" class="btn btn-outline-secondary">Kembali ke Produk</a>
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
</body>
</html>
