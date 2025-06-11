<?php
require '../adminpanel/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_pembeli = isset($_POST['nama_pembeli']) ? htmlspecialchars($_POST['nama_pembeli']) : '';
    $no_hp = isset($_POST['no_hp']) ? htmlspecialchars($_POST['no_hp']) : '';
    $alamat = isset($_POST['alamat']) ? htmlspecialchars($_POST['alamat']) : '';
    $kota = isset($_POST['kota']) ? htmlspecialchars($_POST['kota']) : '';
    $ongkir = isset($_POST['ongkir']) ? (int)$_POST['ongkir'] : 0;
    $tanggal_pesan = date('Y-m-d');

    // Jika checkout dari keranjang
    if (isset($_POST['produk_id']) && is_array($_POST['produk_id'])) {
        $total = 0;
        foreach ($_POST['produk_id'] as $index => $produk_id) {
            $produk_id = (int)$produk_id;
            $jumlah = (int)$_POST['jumlah'][$index];

            $queryProduk = mysqli_query($con, "SELECT id, nama, harga FROM produk WHERE id = '$produk_id'");
            $produk = mysqli_fetch_assoc($queryProduk);

            if (!$produk) {
                die("Produk tidak ditemukan.");
            }

            $subtotal = ($produk['harga'] * $jumlah);
            $total += $subtotal;

            mysqli_query($con, "INSERT INTO pesanan (produk_id, nama_pembeli, no_hp, alamat, jumlah, kota, tanggal_pesan, ongkir, total, metode_pembayaran)
                                VALUES ('$produk_id', '$nama_pembeli', '$no_hp', '$alamat', '$jumlah', '$kota', '$tanggal_pesan', '$ongkir', '$subtotal', 'cod')");
        }
        $total += $ongkir;
    } else {
        // Jika checkout langsung
        $produk_id = isset($_POST['produk_id']) ? (int)$_POST['produk_id'] : 0;
        $jumlah = isset($_POST['jumlah']) ? (int)$_POST['jumlah'] : 0;

        $queryProduk = mysqli_query($con, "SELECT id, nama, harga FROM produk WHERE id = '$produk_id'");
        $produk = mysqli_fetch_assoc($queryProduk);

        if (!$produk) {
            die("Produk tidak ditemukan.");
        }

        $total = ($produk['harga'] * $jumlah) + $ongkir;

        mysqli_query($con, "INSERT INTO pesanan (produk_id, nama_pembeli, no_hp, alamat, jumlah, kota, tanggal_pesan, ongkir, total, metode_pembayaran)
                            VALUES ('$produk_id', '$nama_pembeli', '$no_hp', '$alamat', '$jumlah', '$kota', '$tanggal_pesan', '$ongkir', '$total', 'cod')");
    }

    // Redirect ke halaman sukses setelah pemesanan selesai
    header("Location: sukses.php");
    exit;
}
?>
