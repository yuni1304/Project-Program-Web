<?php
session_start();
require '../adminpanel/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data dari POST (untuk dua metode)
    $nama_pembeli = $_POST['nama_pembeli'] ?? $_POST['nama'] ?? '';
    $no_hp = $_POST['no_hp'] ?? '';
    $alamat = $_POST['alamat'] ?? '';
    $kota = $_POST['kota'] ?? '';
    $ongkir = (int)($_POST['ongkir'] ?? 0);
    $tanggal_pesan = date('Y-m-d');

    // Validasi data
    if (empty($nama_pembeli) || empty($no_hp) || empty($alamat) || empty($kota)) {
        echo "Data tidak lengkap!";
        exit;
    }

    // ===============================
    // === METODE: Checkout Keranjang
    // ===============================
    if (isset($_POST['produk_id']) && is_array($_POST['produk_id'])) {
        $total = 0;
        foreach ($_POST['produk_id'] as $index => $produk_id) {
            $produk_id = (int)$produk_id;
            $jumlah = (int)$_POST['jumlah'][$index];

            $queryProduk = mysqli_query($con, "SELECT id, nama, harga FROM produk WHERE id = '$produk_id'");
            if (!$queryProduk || mysqli_num_rows($queryProduk) == 0) {
                echo "Produk tidak ditemukan.";
                exit;
            }

            $produk = mysqli_fetch_assoc($queryProduk);
            $subtotal = $produk['harga'] * $jumlah;
            $total += $subtotal;

            $insert = mysqli_query($con, "INSERT INTO pesanan 
                (produk_id, nama_pembeli, no_hp, alamat, jumlah, kota, tanggal_pesan, ongkir, total, metode_pembayaran, status_pengiriman)
                VALUES 
                ('$produk_id', '$nama_pembeli', '$no_hp', '$alamat', '$jumlah', '$kota', '$tanggal_pesan', '$ongkir', '$subtotal', 'cod', 'Diproses')");

            if (!$insert) {
                echo "Gagal menyimpan pesanan: " . mysqli_error($con);
                exit;
            }
        }

        // Kosongkan keranjang
        unset($_SESSION['keranjang']);

        // Simpan id salah satu pesanan terakhir
        $_SESSION['pesanan_terakhir'] = mysqli_insert_id($con);
        header("Location: sukses.php");
        exit;
    }

    // ===============================
    // === METODE: Checkout Langsung
    // ===============================
    elseif (isset($_POST['produk_id'])) {
        $produk_id = (int)$_POST['produk_id'];
        $jumlah = (int)$_POST['jumlah'];

        $queryProduk = mysqli_query($con, "SELECT id, nama, harga FROM produk WHERE id = '$produk_id'");
        if (!$queryProduk || mysqli_num_rows($queryProduk) == 0) {
            echo "Produk tidak ditemukan.";
            exit;
        }

        $produk = mysqli_fetch_assoc($queryProduk);
        $total = ($produk['harga'] * $jumlah) + $ongkir;

        $insert = mysqli_query($con, "INSERT INTO pesanan 
            (produk_id, nama_pembeli, no_hp, alamat, jumlah, kota, tanggal_pesan, ongkir, total, metode_pembayaran, status_pengiriman)
            VALUES 
            ('$produk_id', '$nama_pembeli', '$no_hp', '$alamat', '$jumlah', '$kota', '$tanggal_pesan', '$ongkir', '$total', 'cod', 'Diproses')");

        if (!$insert) {
            echo "Gagal menyimpan pesanan: " . mysqli_error($con);
            exit;
        }

        $_SESSION['pesanan_terakhir'] = mysqli_insert_id($con);
        header("Location: sukses.php");
        exit;
    }

    // ===============================
    // === Data tidak valid
    // ===============================
    else {
        echo "Data pesanan tidak valid.";
        exit;
    }
} else {
    echo "Akses tidak valid.";
    exit;
}
?>
