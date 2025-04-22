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
            <h4 class="mb-3">KueCamilan.ID</h4>
            <p class="fs-5">
                Camilan enak, gak ribet, langsung sampai rumah.
            </p>
            <p class="fs-5">
                Di sini kamu bisa nemuin macam-macam camilan dari kue kering buat teman ngeteh, kue basah yang lembut banget, sampai kue ulang tahun dan hampers cantik buat ngasih kejutan ke orang tersayang.
            </p>
            <p class="fs-5">
                Kami pilih semua produk dari pembuat lokal yang jago bikin camilan enak dan tampilannya pun gak kalah keren. Jadi, selain nikmat di mulut, juga enak dilihat.
            </p>
            <p class="fs-5">
                Karena menurut kami, camilan itu lebih dari sekadar makanan.
            </p>
            <p class="fs-5">
                <strong>Camilan bisa jadi hadiah, penghilang stres, teman ngobrol, atau sekadar pengingat kalau hari ini gak seburuk itu.</strong>
            </p>
        </div>
    </div>
</div>

  <!-- Visi Misi -->
<div class="container-fluid warna3 py-5 text-center">
    <div class="container px-4 px-md-5">
        <h3 class="mb-4 fw-bold">Visi & Misi Kami</h3>
        <div class="mx-auto" style="max-width: 800px; line-height: 1.6;">
            <p class="fs-5 mb-2">
                Di <strong>KueCamilan.ID</strong>, semua camilan dibuat sendiri dengan hati, rasa, dan niat yang serius,
                tapi tetap dibungkus dengan suasana santai dan penuh kehangatan. Dari kue kering, basah, sampai hampers, 
                semuanya aku bikin sendiri supaya kamu bisa dapet rasa homemade yang bener-bener ngangenin.
            </p>
            <p class="fs-5 mb-2"><strong>Visinya</strong> simpel: pengin bikin orang senyum lewat camilan enak.</p>
            <p class="fs-5 mb-2">
                <strong>Misinya</strong>? Ya bikin yang enak, layak dikasih ke orang tersayang, gampang dipesen,
                dan langsung sampai ke rumah tanpa drama.
            </p>
            <p class="fs-5 mb-0">
                Karena buat aku, bikin kue itu bukan cuma jualan. Ini tentang berbagi rasa, cerita, dan momen kecil 
                yang bisa bikin hari siapa pun jadi lebih baik.
            </p>
        </div>
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
