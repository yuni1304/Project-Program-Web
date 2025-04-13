<?php
// Menghubungkan dengan session dan koneksi database
require "session.php";
require "koneksi.php";

// Mengambil ID kategori dari URL
$id = isset($_GET['id']) ? $_GET['id'] : '';

// Jika tidak ada ID, arahkan kembali ke halaman kategori
if (empty($id)) {
    header("Location: kategori.php");
    exit();
}

// Mengambil data kategori berdasarkan ID
$query = mysqli_query($con, "SELECT * FROM kategori WHERE id = '$id'");
$kategori = mysqli_fetch_assoc($query);

// Jika kategori tidak ditemukan
if (!$kategori) {
    echo "Kategori tidak ditemukan.";
    exit();
}

// Menangani form submission untuk update kategori
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['nama'])) {
    $nama = mysqli_real_escape_string($con, $_POST['nama']);

    // Update nama kategori dalam database
    $updateQuery = mysqli_query($con, "UPDATE kategori SET nama = '$nama' WHERE id = '$id'");

    // Jika berhasil, beri pesan sukses dan redirect
    if ($updateQuery) {
        header("Location: kategori.php"); // Mengarahkan ke halaman kategori setelah sukses
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

        <!-- Form Edit Kategori -->
        <form method="POST">
            <div class="mb-3">
                <label for="nama" class="form-label">Nama Kategori</label>
                <input type="text" class="form-control" id="nama" name="nama" value="<?= htmlspecialchars($kategori['nama']) ?>" required>
            </div>

            <button type="submit" class="btn btn-primary">Update Kategori</button>
        </form>

        <!-- Kembali ke halaman kategori -->
        <a href="kategori.php" class="btn btn-secondary mt-3">Kembali ke Daftar Kategori</a>
    </div>
</body>
</html>
