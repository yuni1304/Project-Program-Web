<?php 
session_start();
require '../adminpanel/koneksi.php';
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Keranjang Belanja | KueCamilan.ID</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="../css/style.css"> 
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
<?php require "navbar.php"; ?>

<!-- Banner -->
<div class="container-fluid banner-produk d-flex align-items-center text-center text-white">
  <div class="container">
    <h1 class="display-5 fw-bold">Keranjang Belanja</h1>
    <p class="lead">Cek kembali pesananmu sebelum checkout</p>
  </div>
</div>

<!-- Keranjang Body -->
<div class="container py-5">
  <?php if (!empty($_SESSION['keranjang'])) { ?>
    <div class="table-responsive mb-5">
      <table class="table table-bordered text-center align-middle shadow-sm">
        <thead class="table-warning text-dark">
          <tr>
            <th>No</th>
            <th>Produk</th>
            <th>Harga</th>
            <th>Jumlah</th>
            <th>Total</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php 
          $no = 1;
          $totalBelanja = 0;
          foreach ($_SESSION['keranjang'] as $id => $jumlah) {
            $queryProduk = mysqli_query($con, "SELECT * FROM produk WHERE id='$id'");
            $produk = mysqli_fetch_assoc($queryProduk);
            $total = $produk['harga'] * $jumlah;
            $totalBelanja += $total;
          ?>
          <tr>
            <td><?php echo $no++; ?></td>
            <td><?php echo htmlspecialchars($produk['nama']); ?></td>
            <td>Rp <?php echo number_format($produk['harga'], 0, ',', '.'); ?></td>
            <td><?php echo $jumlah; ?></td>
            <td>Rp <?php echo number_format($total, 0, ',', '.'); ?></td>
            <td>
              <a href="keranjang_action.php?action=hapus&id=<?php echo $id; ?>" class="btn btn-sm btn-danger">
                <i class="fas fa-trash-alt"></i>
              </a>
            </td>
          </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>

    <!-- Total dan Checkout -->
    <div class="row justify-content-end">
      <div class="col-md-5">
        <div class="card border-0 shadow-sm p-4" style="background-color: #fff8e1;">
          <h5 class="fw-bold text-center mb-3">Total Belanja</h5>
          <h3 class="text-success text-center mb-4">Rp <?php echo number_format($totalBelanja, 0, ',', '.'); ?></h3>
          <a href="checkout.php" class="btn warna2 text-white w-100">
            <i class="fas fa-credit-card me-2"></i> Checkout Sekarang
          </a>
        </div>
      </div>
    </div>
  <?php } else { ?>
    <div class="alert alert-warning text-center">
      Keranjang kamu masih kosong.
    </div>
  <?php } ?>
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
