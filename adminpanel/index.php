<?php
session_start();
$_SESSION['username'] = 'admin';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Home</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        body {
            background-color: #f4f6f9;
        }
        .summary-card {
            border-radius: 15px;
            background-color: white;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
            transition: transform 0.2s;
        }
        .summary-card:hover {
            transform: translateY(-5px);
        }
        .summary-icon {
            font-size: 4rem;
            color: #6c757d;
        }
        .no-decoration {
            text-decoration: none;
        }
    </style>
</head>
<body>
    <?php require "navbar.php"; ?>

    <div class="container mt-5">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page">
                    <i class="bi bi-house-door-fill"></i> Home
                </li>
            </ol>
        </nav>

        <h2 class="mb-4">Halo, <?= $_SESSION['username']; ?> 👋</h2>

        <div class="row g-4">
            <div class="col-md-6">
                <div class="p-4 summary-card d-flex align-items-center justify-content-between">
                    <div>
                        <i class="fas fa-align-justify summary-icon"></i>
                    </div>
                    <div class="text-end">
                        <h4 class="fw-bold">Kategori</h4>
                        <p class="fs-5 mb-1">4 Kategori</p>
                        <a href="kategori.php" class="text-primary no-decoration">Lihat Detail</a>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="p-4 summary-card d-flex align-items-center justify-content-between">
                    <div>
                        <i class="fas fa-box summary-icon"></i>
                    </div>
                    <div class="text-end">
                        <h4 class="fw-bold">Produk</h4>
                        <p class="fs-5 mb-1">20 Produk</p>
                        <a href="produk.php" class="text-primary no-decoration">Lihat Detail</a>
                    </div>
                </div>
            </div>
            <div class="col-md-7">
                    <div class="p-4 summary-card d-flex align-items-center justify-content-between">
                        <div>
                            <i class="fas fa-shopping-cart summary-icon"></i>
                    </div>
                    <div class="text-end">
                        <h4 class="fw-bold">Pesanan</h4>
                        <p class="fs-5 mb-1">Lihat semua pesanan</p>
                        <a href="pesanan.php" class="text-primary no-decoration">Lihat Detail</a>
                    </div>
                </div>
             </div>
        </div>
    </div>
</body>
</html>
