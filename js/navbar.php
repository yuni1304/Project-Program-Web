<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$jumlahItem = 0;
if (isset($_SESSION['keranjang']) && is_array($_SESSION['keranjang'])) {
    foreach ($_SESSION['keranjang'] as $qty) {
        $jumlahItem += $qty;
    }
}
?>

<nav class="navbar navbar-expand-lg navbar-light warna1">
  <div class="container">
    <a class="navbar-brand" href="index.php">KueCamilan.ID</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
      data-bs-target="#navbarNav" aria-controls="navbarNav"
      aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
        <li class="nav-item me-4"><a class="nav-link" href="index.php">Home</a></li>
        <li class="nav-item me-4"><a class="nav-link" href="tentang-kami.php">Tentang Kami</a></li>
        <li class="nav-item me-4"><a class="nav-link" href="produk.php">Produk</a></li>
        <li class="nav-item me-4">
          <a class="nav-link" href="status_pengiriman.php"><i class="bi bi-truck"></i> Cek Pengiriman</a>
        </li>
        <li class="nav-item position-relative">
          <a class="nav-link" href="keranjang.php">
            <i class="fa fa-shopping-cart"></i> Keranjang
            <?php if ($jumlahItem > 0): ?>
              <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                <?= $jumlahItem; ?>
              </span>
            <?php endif; ?>
          </a>
        </li>
      </ul>
    </div>
  </div>
</nav>
