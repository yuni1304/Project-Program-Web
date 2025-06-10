<?php 
require '../adminpanel/koneksi.php';
$queryKategori = mysqli_query($con,"SELECT * FROM kategori");

if(isset($_GET['keyword'])) { 
  $queryProduk = mysqli_query($con, "SELECT * FROM produk WHERE nama LIKE '%$_GET[keyword]%'");
} else if(isset($_GET['kategori'])) { 
  $queryGetKategoriID = mysqli_query($con, "SELECT id FROM kategori WHERE nama='$_GET[kategori]'");
  $kategoriID = mysqli_fetch_array($queryGetKategoriID);
  $queryProduk = mysqli_query($con,"SELECT * FROM produk WHERE kategori_id='$kategoriID[id]'");
} else {
  $queryProduk = mysqli_query($con,"SELECT * FROM produk");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
  <title>Toko Online | Produk</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="../css/style.css"> 
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
<?php require "navbar.php"; ?>

<div class="container-fluid banner-produk d-flex align-items-center text-center text-white">
  <div class="container">
    <h1 class="display-5 fw-bold">Nikmati Kelezatan Kue & Camilan Kami</h1>
    <p class="lead">Temukan pilihan terbaik untuk teman santaimu</p>
  </div>
</div>

<div class="container py-5">
  <div class="row">
    <div class="col-lg-3 mb-5">
      <h3>Kategori</h3>
      <div class="list-group">
        <?php while($kategori = mysqli_fetch_array($queryKategori)) { ?>
        <a class="no-decoration" href="produk.php?kategori=<?php echo urlencode($kategori['nama']); ?>">
          <li class="list-group-item"><?php echo htmlspecialchars($kategori['nama']); ?></li>
        </a> 
        <?php } ?>
      </div>
    </div>

    <div class="col-lg-9">
      <h3 class="text-center mb-4">Produk</h3>
      <div class="row">
        <?php if(mysqli_num_rows($queryProduk) > 0) { ?>
          <?php while($produk = mysqli_fetch_array($queryProduk)){ ?>
          <div class="col-md-4 mb-4">
            <div class="card h-100 shadow-sm border-0">
              <div class="image-box position-relative">
                <img src="/image/<?php echo htmlspecialchars($produk['foto']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($produk['nama']); ?>">
              </div>
              <div class="card-body d-flex flex-column">
                <h5 class="card-title fw-semibold"><?php echo htmlspecialchars($produk['nama']); ?></h5>
                <p class="card-text text-truncate small"><?php echo htmlspecialchars($produk['detail']); ?></p>
                <p class="card-text text-harga mt-auto mb-3">Rp <?php echo number_format($produk['harga'], 0, ',', '.'); ?></p>
                <a href="produk-detail.php?nama=<?php echo urlencode($produk['nama']); ?>" class="btn warna2 text-white w-100 mb-2">
                  <i class="fas fa-eye me-2"></i> Lihat Detail
                </a>
                <a href="checkout_langsung.php?id=<?= $produk['id'] ?>&qty=1" class="btn btn-success w-100">
                  <i class="fas fa-shopping-cart me-2"></i> Beli Sekarang
                </a>
                <form action="keranjang_action.php?action=tambah&id=<?php echo $produk['id']; ?>" method="POST" class="mt-2">
                  <input type="hidden" name="jumlah" value="1">
                  <button type="submit" class="btn btn-warning text-white w-100">
                    <i class="fas fa-cart-plus me-2"></i> + Keranjang
                  </button>
                </form>
              </div>
            </div>
          </div>
          <?php } ?>
        <?php } else { ?>
          <div class="col-12">
            <div class="alert alert-warning text-center" role="alert">
              Data yang dicari tidak ditemukan.
            </div>
          </div>
        <?php } ?>
      </div>
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
