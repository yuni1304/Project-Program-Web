<?php
require '../adminpanel/koneksi.php';
require '../vendor/autoload.php';

\Midtrans\Config::$serverKey = 'SB-Mid-server-E52g-bes6FS0dOQ-H_M_cD6z'; // Ganti sesuai server key kamu
\Midtrans\Config::$isProduction = false;
\Midtrans\Config::$isSanitized = true;
\Midtrans\Config::$is3ds = true;

// Validasi input
$nama_pembeli = mysqli_real_escape_string($con, $_POST['nama_pembeli']);
$alamat = mysqli_real_escape_string($con, $_POST['alamat']);
$jumlah = (int) $_POST['jumlah'];
$harga = (int) $_POST['harga'];
$produk_id = (int) $_POST['produk_id'];
$no_hp = mysqli_real_escape_string($con, $_POST['no_hp']);

// Validasi input yang diterima
if ($jumlah <= 0 || $harga <= 0 || empty($produk_id) || empty($nama_pembeli) || empty($no_hp)) {
    echo json_encode(['error' => 'Data yang dimasukkan tidak lengkap atau tidak valid']);
    exit;
}

// Ambil data produk dengan prepared statement untuk mencegah SQL Injection
$queryProduk = $con->prepare("SELECT * FROM produk WHERE id = ?");
$queryProduk->bind_param("i", $produk_id);
$queryProduk->execute();
$result = $queryProduk->get_result();
$produk = $result->fetch_assoc();

if (!$produk) {
    echo json_encode(['error' => 'Produk tidak ditemukan']);
    exit;
}

// Buat order_id unik
$order_id = "ORDER-" . rand(1000,9999) . "-" . time();

// Simpan pesanan ke database dengan prepared statement
$tanggal_pesan = date('Y-m-d');
$stmt = $con->prepare("INSERT INTO pesanan (order_id, produk_id, nama_pembeli, alamat, jumlah, tanggal_pesan, metode_pembayaran, status)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("sissssss", $order_id, $produk_id, $nama_pembeli, $alamat, $jumlah, $tanggal_pesan, $metode_pembayaran = 'midtrans', $status = 'pending');
$stmt->execute();

// Kurangi stok dengan prepared statement
$stmtStok = $con->prepare("UPDATE produk SET stok = stok - ? WHERE id = ?");
$stmtStok->bind_param("ii", $jumlah, $produk_id);
$stmtStok->execute();

// Persiapkan data Snap Token
$transaction_details = [
    'order_id' => $order_id,
    'gross_amount' => $harga * $jumlah,
];

$item_details = [[
    'id' => $produk_id,
    'price' => $harga,
    'quantity' => $jumlah,
    'name' => $produk['nama']
]];

$customer_details = [
    'first_name' => $nama_pembeli,
    'phone' => $no_hp,
    'shipping_address' => [
        'first_name' => $nama_pembeli,
        'address' => $alamat,
        'phone' => $no_hp
    ]
];

$params = [
    'transaction_details' => $transaction_details,
    'item_details' => $item_details,
    'customer_details' => $customer_details
];

try {
    $snapToken = \Midtrans\Snap::getSnapToken($params);
    echo json_encode(['snapToken' => $snapToken]);
} catch (Exception $e) {
    echo json_encode(['error' => 'Gagal mendapatkan token Midtrans: ' . $e->getMessage()]);
}
