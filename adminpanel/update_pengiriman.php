<?php
require "session.php";
require "koneksi.php";

if (isset($_POST['pesanan_id'], $_POST['status_pengiriman'])) {
    $id = intval($_POST['pesanan_id']);
    $status = trim($_POST['status_pengiriman']);

    $allowed = ['Diproses', 'Dikirim', 'Sampai'];
    if (!in_array($status, $allowed)) {
        die("Status tidak valid.");
    }

    $cek = mysqli_query($con, "SELECT * FROM pesanan WHERE id = $id");
    if (mysqli_num_rows($cek) === 0) {
        die("ID pesanan tidak ditemukan.");
    }

    $update = mysqli_query($con, "UPDATE pesanan SET status_pengiriman = '$status' WHERE id = $id");

    if ($update) {
        if (mysqli_affected_rows($con) > 0) {
            
            header("Location: pesanan.php?status_updated=1");
            exit;
        } else {
         
            echo "Status pengiriman tidak berubah karena nilai yang dikirim sama dengan sebelumnya.";
        }
    } else {
       
        echo "Gagal memperbarui status: " . mysqli_error($con);
    }
} else {
    header("Location: pesanan.php");
    exit;
}
