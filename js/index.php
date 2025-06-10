<?php
require '../adminpanel/koneksi.php';
$queryProduk = mysqli_query($con, "SELECT id, nama, harga, foto, detail FROM produk LIMIT 3");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
  <title>KueCamilan.ID | Home</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="../css/style.css"> 
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
  <?php require "navbar.php"; ?>
  
  <div class="container-fluid banner d-flex align-items-center">
    <div class="container text-center text-white">
      <h1 class="fw-bold display-4">KueCamilan.ID</h1>
      <h3 class="mb-4">Temukan Kue & Camilan Favoritmu 🍪</h3>
      <div class="col-md-8 offset-md-2">
        <form method="get" action="produk.php">
          <div class="input-group input-group-lg my-4">
            <input type="text" class="form-control" placeholder="Cari produk kue atau camilan..." name="keyword" aria-label="Search" aria-describedby="basic-addon2">
            <button type="submit" class="btn warna2 text-white">Telusuri</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <div class="container-fluid warna3 py-5">
    <div class="container text-center">
      <h3 class="fw-bold">Tentang Kami</h3>
      <p class="fs-5 mt-3">
        <strong>KueCamilan.ID</strong> KueCamilan.ID adalah toko online yang menghadirkan berbagai pilihan kue dan camilan lezat khas 
        Nusantara, langsung dari para UMKM dan pembuat lokal. Kami percaya bahwa setiap gigitan menyimpan 
        cerita rasa yang tak terlupakan dari dapur rumahan hingga tangan-tangan terampil pembuatnya.<br><br>
        Kami menyediakan aneka kue kering, kue basah, snack tradisional, hingga camilan kekinian dengan kualitas terbaik. 
        Dengan berbelanja di KueCamilan.ID, kamu turut mendukung usaha kecil dan menjaga cita rasa khas 
        Indonesia tetap hidup di setiap kesempatan ngemilmu.
      </p>
    </div>
  </div>

  <div class="container-fluid py-5 warna1">
    <div class="container text-center">
      <h3 class="fw-bold text-dark">Produk Pilihan Kami</h3>
      <div class="row mt-5">
        <?php while($data = mysqli_fetch_array($queryProduk)) { ?>
        <div class="col-sm-6 col-md-4 mb-3">
          <div class="card h-100 shadow-sm">
            <div class="image-box">
              <img src="/image/<?php echo $data['foto']; ?>" class="card-img-top" alt="<?php echo $data['nama']; ?>">
            </div>
            <div class="card-body">
              <h4 class="card-title text-dark"><?php echo $data['nama']; ?></h4>
              <p class="card-text text-truncate"><?php echo $data['detail']; ?></p>
              <p class="card-text text-harga fw-semibold">Rp <?php echo number_format($data['harga'], 0, ',', '.'); ?></p>
              <a href="produk-detail.php?nama=<?php echo $data['nama']; ?>" class="btn warna2 text-white">Lihat Detail</a>
            </div>
          </div>
        </div>
        <?php } ?>
      </div>
      <a class="btn btn-outline-warning mt-4 p-3 fs-5 fw-semibold" href="produk.php">Lihat Semua Produk</a>
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
