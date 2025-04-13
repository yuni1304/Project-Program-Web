<?php
require '../adminpanel/koneksi.php';
require '../vendor/autoload.php';

// Ambil data dari form
$produk_id = $_POST['produk_id'];
$nama_pembeli = $_POST['nama'];
$alamat = $_POST['alamat'];
$jumlah = $_POST['jumlah'];
$harga = $_POST['harga'];
$metode_pembayaran = $_POST['metode_pembayaran']; // COD atau midtrans
$tanggal_pesan = date('Y-m-d');

// Ambil detail produk
$queryProduk = mysqli_query($con, "SELECT * FROM produk WHERE id = '$produk_id'");
$produk = mysqli_fetch_assoc($queryProduk);

// Simpan ke database (tabel pesanan)
mysqli_query($con, "INSERT INTO pesanan (produk_id, nama_pembeli, alamat, jumlah, tanggal_pesan, metode_pembayaran)
                    VALUES ('$produk_id', '$nama_pembeli', '$alamat', '$jumlah', '$tanggal_pesan', '$metode_pembayaran')");

// Jika metode pembayaran adalah COD
if ($metode_pembayaran == 'cod') {
    header("Location: sukses.php");
    exit;
}

// Jika metode pembayaran adalah midtrans
$order_id = "ORDER-" . rand(1000,9999) . "-" . time();

// Konfigurasi Midtrans
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
            'price' => $harga,
            'quantity' => $jumlah,
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

$snapToken = \Midtrans\Snap::getSnapToken($params);
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Proses Pembayaran</title>
  <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="YOUR_CLIENT_KEY"></script>
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
      }
    });
  </script>
</body>
</html>
