<?php
require '../adminpanel/koneksi.php';

$nama      = $_POST['nama_pembeli'];
$alamat    = $_POST['alamat'];
$jumlah    = $_POST['jumlah'];
$produk_id = $_POST['produk_id'];
$metode    = $_POST['metode_pembayaran'];

// Simpan ke tabel transaksi
$query = mysqli_query($con, "INSERT INTO transaksi (produk_id, nama_pembeli, alamat, jumlah, metode_pembayaran) 
                             VALUES ('$produk_id', '$nama', '$alamat', '$jumlah', '$metode')");

if ($query) {
    echo "<script>alert('Terima kasih $nama, pesanan kamu berhasil diproses dengan metode $metode!'); window.location='produk.php';</script>";
} else {
    echo "<script>alert('Terjadi kesalahan saat memproses pesanan.'); window.location='checkout.php';</script>";
}
?>
