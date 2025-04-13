<?php
session_start();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tentang Kami</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css"> 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
    <?php require "navbar.php"; ?>

    <!-- Banner -->
    <div class="container-fluid banner d-flex align-items-center justify-content-center" style="height: 300px;">
        <div class="text-center text-white">
            <h1 class="fw-bold">Tentang Kami</h1>
            <p class="fs-5">Kenali lebih dekat misi kami dalam menghadirkan kue dan camilan terbaik untuk Anda</p>
        </div>
    </div>

    <!-- Konten Utama -->
    <div class="container py-5">
    <div class="row align-items-center">
        <div class="col-md-6 mb-4 mb-md-0">
            <div class="text-center">
                <img src="../image/bgkue.jpg" alt="KueCamilan.ID" class="img-fluid rounded shadow" style="max-height: 400px; object-fit: cover; width: 100%;">
            </div>
        </div>
        <div class="col-md-6">
            <h3 class="mb-3">KueCamilan.ID</h3>
            <p class="fs-5">
                adalah toko online yang menghadirkan beragam kue dan camilan khas Nusantara, 
                langsung dari para pembuat lokal ke rumah Anda. Kami percaya bahwa setiap gigitan menyimpan kenangan, 
                kehangatan, dan cita rasa yang layak dinikmati oleh semua orang, dari Sabang hingga Merauke.
            </p>
            <p class="fs-5">
                Di KueCamilan.ID, kami menyediakan berbagai pilihan kue basah, kue kering, snack tradisional, 
                hingga camilan kekinian—semuanya melalui proses kurasi agar kualitas dan rasa tetap terjaga. 
                Kami bekerja sama dengan UMKM dan pembuat rumahan yang terampil dan berdedikasi.
            </p>
            <p class="fs-5">
                Lebih dari sekadar tempat belanja camilan, kami hadir untuk menghubungkan penikmat jajanan dengan para pelaku 
                usaha lokal, memberdayakan komunitas, dan melestarikan kekayaan kuliner Indonesia. Setiap pembelian Anda adalah bentuk dukungan nyata bagi pelaku usaha kecil di tanah air.
            </p>
            <p class="fs-5">
                Temukan camilan favorit Anda bersama <strong>KueCamilan.ID</strong> — karena setiap rasa punya cerita.
            </p>
        </div>
    </div>
</div>

    <!-- Visi Misi -->
    <div class="container-fluid warna3 py-5 text-center">
        <div class="container">
            <h3 class="mb-4">Visi & Misi Kami</h3>
            <p class="fs-5">Menjadi toko camilan online terpercaya yang membawa cita rasa lokal ke seluruh penjuru negeri.</p>
            <p class="fs-5">Kami berkomitmen menyediakan produk berkualitas tinggi, layanan ramah, dan pengalaman belanja yang memuaskan sekaligus mendukung UMKM lokal agar terus berkembang.</p>
        </div>
    </div>

 <!-- footer -->
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
