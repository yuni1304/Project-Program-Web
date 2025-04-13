<?php
require 'vendor/autoload.php';
require 'adminpanel/koneksi.php';

// Set Midtrans configuration
\Midtrans\Config::$serverKey = 'SB-Mid-server-E52g-bes6FS0dOQ-H_M_cD6z';
\Midtrans\Config::$isProduction = false;
\Midtrans\Config::$isSanitized = true;
\Midtrans\Config::$is3ds = true;

// Ambil data dari form
$nama = $_POST['nama_pembeli'];
$email = $_POST['email'];
$no_hp = $_POST['no_hp'];
$alamat = $_POST['alamat'];
$produk_id = $_POST['produk_id'];
$nama_produk = $_POST['nama'];
$harga = (int)$_POST['harga'];

// Buat ID pesanan unik
$order_id = 'TRX-' . time();

// Simpan ke database (tabel `pesanan`)
mysqli_query($con, "INSERT INTO pesanan (order_id, nama_pembeli, email, no_hp, alamat, produk_id, nama_produk, harga, status)
    VALUES ('$order_id', '$nama', '$email', '$no_hp', '$alamat', '$produk_id', '$nama_produk', '$harga', 'pending')");

// Detail transaksi
$transaction_details = [
    'order_id' => $order_id,
    'gross_amount' => $harga
];

// Detail produk
$item_details = [
    [
        'id' => $produk_id,
        'price' => $harga,
        'quantity' => 1,
        'name' => $nama_produk
    ]
];

// Data pembeli
$customer_details = [
    'first_name' => $nama,
    'email' => $email,
    'phone' => $no_hp,
    'shipping_address' => [
        'first_name' => $nama,
        'address' => $alamat,
        'phone' => $no_hp
    ]
];

// Gabungkan semua
$transaction = [
    'transaction_details' => $transaction_details,
    'customer_details' => $customer_details,
    'item_details' => $item_details
];

// Dapatkan Snap Token
$snapToken = \Midtrans\Snap::getSnapToken($transaction);
echo $snapToken;
?>
