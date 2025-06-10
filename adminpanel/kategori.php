<?php
require "session.php";
require "koneksi.php";

$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['new_category'])) {
    $newCategory = mysqli_real_escape_string($con, $_POST['new_category']);

    $checkCategory = mysqli_query($con, "SELECT * FROM kategori WHERE nama = '$newCategory'");
    if (mysqli_num_rows($checkCategory) > 0) {
        $message = "Kategori sudah ada!";
    } else {

        $insertCategory = mysqli_query($con, "INSERT INTO kategori (nama) VALUES ('$newCategory')");
        if ($insertCategory) {
            $message = "Kategori baru berhasil ditambahkan!";
        } else {
            $message = "Gagal menambahkan kategori. Coba lagi.";
        }
    }
}


$queryKategori = mysqli_query($con, "SELECT * FROM kategori");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kategori</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <style>
        .kategori-card {
            border-radius: 15px;
            transition: transform 0.2s ease-in-out;
        }
        .kategori-card:hover {
            transform: scale(1.03);
        }
        .image-wrapper img {
            width: 60px;
            height: 60px;
            object-fit: contain;
            border-radius: 10px;
            background-color: rgba(255, 255, 255, 0.4);
            padding: 5px;
        }
    </style>
</head>
<body>
    <?php require "navbar.php"; ?>

    <div class="container mt-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php" class="text-decoration-none">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Kategori</li>
            </ol>
        </nav>

        <h2 class="mb-4">Kategori Produk</h2>

        
        <?php if ($message) { ?>
            <div class="alert alert-info"><?= $message; ?></div>
        <?php } ?>

        
        <form class="mb-4" method="POST">
            <div class="input-group">
                <input type="text" class="form-control" placeholder="Nama kategori baru" name="new_category" required>
                <button class="btn btn-primary" type="submit"><i class="bi bi-plus-circle"></i> Tambah Kategori</button>
            </div>
        </form>

        
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Nama</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $no = 1;
                    if (mysqli_num_rows($queryKategori) > 0) {
                        while ($kategori = mysqli_fetch_array($queryKategori)) {
                    ?>
                    <tr>
                        <td><?= $no++; ?></td>
                        <td><?= $kategori['nama']; ?></td>
                        <td>
                           
                            <a href="edit_kategori.php?id=<?= $kategori['id']; ?>" class="btn btn-warning btn-sm"><i class="bi bi-pencil"></i> Edit</a>
                            <a href="hapus_kategori.php?id=<?= $kategori['id']; ?>" class="btn btn-danger btn-sm"><i class="bi bi-trash"></i> Hapus</a>
                        </td>
                    </tr>
                    <?php 
                        }
                    } else {
                        echo "<tr><td colspan='3' class='text-center'>Kategori tidak ditemukan.</td></tr>";
                    } 
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
