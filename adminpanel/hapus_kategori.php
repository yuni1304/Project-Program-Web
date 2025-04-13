<?php
require "session.php";
require "koneksi.php";

// Ambil ID dari URL
$id = isset($_GET['id']) ? $_GET['id'] : '';

// Jika ID tidak ada, kembali ke halaman kategori
if (empty($id)) {
    header("Location: kategori.php");
    exit();
}

// Amankan ID dari SQL injection
$id = mysqli_real_escape_string($con, $id);

// Eksekusi query hapus
$hapus = mysqli_query($con, "DELETE FROM kategori WHERE id = '$id'");

// Redirect kembali ke halaman kategori
header("Location: kategori.php");
exit();
?>
