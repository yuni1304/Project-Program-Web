<?php
$con = mysqli_connect("localhost", "root", "", "toko_online");

if (!$con) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>
