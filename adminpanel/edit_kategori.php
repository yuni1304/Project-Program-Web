<?php

require "session.php";
require "koneksi.php";


$id = isset($_GET['id']) ? $_GET['id'] : '';


if (empty($id)) {
    header("Location: kategori.php");
    exit();
}


$query = mysqli_query($con, "SELECT * FROM kategori WHERE id = '$id'");
$kategori = mysqli_fetch_assoc($query);


if (!$kategori) {
    echo "Kategori tidak ditemukan.";
    exit();
}


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['nama'])) {
    $nama = mysqli_real_escape_string($con, $_POST['nama']);

    
    $updateQuery = mysqli_query($con, "UPDATE kategori SET nama = '$nama' WHERE id = '$id'");

    
    if ($updateQuery) {
        header("Location: kategori.php"); 
        exit();
    } else {
        echo "<script>alert('Gagal memperbarui kategori. Coba lagi.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Kategori</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php require "navbar.php"; ?>

    <div class="container mt-5">
        <h2>Edit Kategori</h2>

        
        <form method="POST">
            <div class="mb-3">
                <label for="nama" class="form-label">Nama Kategori</label>
                <input type="text" class="form-control" id="nama" name="nama" value="<?= htmlspecialchars($kategori['nama']) ?>" required>
            </div>

            <button type="submit" class="btn btn-primary">Update Kategori</button>
        </form>

        
        <a href="kategori.php" class="btn btn-secondary mt-3">Kembali ke Daftar Kategori</a>
    </div>
</body>
</html>
