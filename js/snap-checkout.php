<?php
require '../adminpanel/koneksi.php';
require '../vendor/autoload.php';

$produk_id = isset($_POST['produk_id']) ? (int)$_POST['produk_id'] : 0; 
$nama_pembeli = isset($_POST['nama']) ? htmlspecialchars($_POST['nama']) : '';
$alamat = isset($_POST['alamat']) ? htmlspecialchars($_POST['alamat']) : '';
$jumlah = isset($_POST['jumlah']) ? (int)$_POST['jumlah'] : 0; 
$metode_pembayaran = isset($_POST['metode_pembayaran']) ? htmlspecialchars($_POST['metode_pembayaran']) : '';
$tanggal_pesan = date('Y-m-d');


$queryProduk = mysqli_query($con, "SELECT id, nama, harga FROM produk WHERE id = '$produk_id'"); // Select 'harga' column
$produk = mysqli_fetch_assoc($queryProduk);

if (!$produk) {
    
    die("Produk tidak ditemukan.");
}


$harga = $produk['harga']; 


if ($harga <= 0 || $jumlah <= 0) {
    die("Harga atau jumlah tidak valid. Harap periksa kembali.");
}


mysqli_query($con, "INSERT INTO pesanan (produk_id, nama_pembeli, alamat, jumlah, tanggal_pesan, metode_pembayaran)
                     VALUES ('$produk_id', '$nama_pembeli', '$alamat', '$jumlah', '$tanggal_pesan', '$metode_pembayaran')");


if ($metode_pembayaran == 'cod') {
    header("Location: sukses.php");
    exit;
}


$order_id = "ORDER-" . rand(1000,9999) . "-" . time();

\Midtrans\Config::$serverKey = 'SB-Mid-server-E52g-bes6FS0dOQ-H_M_cD6z'; 
\Midtrans\Config::$isProduction = false;
\Midtrans\Config::$isSanitized = true;
\Midtrans\Config::$is3ds = true;

$params = [
    'transaction_details' => [
        'order_id' => $order_id,
        'gross_amount' => $harga * $jumlah, 
    ],
    'item_details' => [
        [
            'id' => $produk_id,
            'price' => (float)$harga,      
            'quantity' => (int)$jumlah,     
            'name' => $produk['nama']
        ]
    ],
    'customer_details' => [
        'first_name' => $nama_pembeli,
        'shipping_address' => [
            'first_name' => $nama_pembeli,
            'address' => $alamat,
        ]
    ]
];

try {
    $snapToken = \Midtrans\Snap::getSnapToken($params);
} catch (Exception $e) {
    // Log the error for debugging (e.g., to a file)
    error_log("Midtrans Snap Token Error: " . $e->getMessage());
    die("Terjadi kesalahan saat membuat token pembayaran. Silakan coba lagi.");
}

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Proses Pembayaran</title>
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="SB-Mid-client-W2W017lYwX0B0kYf"></script>
</head>
<body>
    <h3>Mohon tunggu, sedang mengarahkan ke pembayaran...</h3>

    <script type="text/javascript">
        snap.pay('<?php echo $snapToken; ?>', {
            onSuccess: function(result) {
                alert("✅ Pembayaran berhasil!");
                window.location.href = "sukses.php";
            },
            onPending: function(result) {
                alert("⌛ Menunggu pembayaran.");
                window.location.href = "pending.php";
            },
            onError: function(result) {
                alert("❌ Pembayaran gagal.");
                window.location.href = "gagal.php";
            },
            onClose: function() {
                alert('Anda menutup jendela pembayaran.');
            }
        });
    </script>
</body>
</html>