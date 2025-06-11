<?php
session_start(); // Pastikan session dimulai untuk akses keranjang
require '../adminpanel/koneksi.php'; // Koneksi ke database
require '../vendor/autoload.php';   // Autoload Midtrans library

// --- 1. Ambil dan Sanitasi Data POST dari Formulir ---
$nama_pembeli        = isset($_POST['nama']) ? htmlspecialchars(trim($_POST['nama'])) : '';
$no_hp               = isset($_POST['nohp']) ? htmlspecialchars(trim($_POST['nohp'])) : ''; // Dari checkout.php
// Jika dari snap-checkout-langsung.php, mungkin 'no_hp' bukan 'nohp'
if (empty($no_hp) && isset($_POST['no_hp'])) {
    $no_hp           = htmlspecialchars(trim($_POST['no_hp']));
}
$alamat              = isset($_POST['alamat']) ? htmlspecialchars(trim($_POST['alamat'])) : '';
$kota                = isset($_POST['kota']) ? htmlspecialchars(trim($_POST['kota'])) : '';
$metode_pembayaran   = isset($_POST['metode_pembayaran']) ? htmlspecialchars(trim($_POST['metode_pembayaran'])) : '';
$tanggal_pesan       = date('Y-m-d H:i:s'); // Menyimpan waktu juga
$status_pembayaran   = 'pending'; // Status awal

$total_gross_amount  = 0;
$ongkir_final        = isset($_POST['ongkir']) ? (float)$_POST['ongkir'] : 0; // Ongkir dari formulir
$item_details_midtrans = [];
$produk_data_for_db = []; // Untuk menyimpan data produk yang akan dimasukkan ke tabel detail_pesanan

// --- 2. Logika Penanganan Data Berdasarkan Asal Formulir (Keranjang atau Langsung) ---

// KASUS 1: Data datang dari checkout.php (keranjang)
if (isset($_POST['produk_id']) && is_array($_POST['produk_id']) && !empty($_POST['produk_id'])) {
    $produk_ids_keranjang = $_POST['produk_id'];
    $nama_produks_keranjang = $_POST['nama_produk'];
    $hargas_keranjang = $_POST['harga'];
    $jumlahs_keranjang = $_POST['jumlah'];

    // Validasi dasar dan loop untuk setiap item di keranjang
    for ($i = 0; $i < count($produk_ids_keranjang); $i++) {
        $id_produk_item   = (int)$produk_ids_keranjang[$i];
        $nama_produk_item = htmlspecialchars($nama_produks_keranjang[$i]);
        $harga_item       = (float)$hargas_keranjang[$i];
        $jumlah_item      = (int)$jumlahs_keranjang[$i];

        // Validasi data item
        if ($id_produk_item <= 0 || $harga_item <= 0 || $jumlah_item <= 0) {
            die("Error: Data produk dalam keranjang tidak valid (ID, harga, atau jumlah).");
        }

        // Cek stok produk di database
        $stmt_stok_check = $con->prepare("SELECT stok FROM produk WHERE id = ?");
        $stmt_stok_check->bind_param("i", $id_produk_item);
        $stmt_stok_check->execute();
        $res_stok = $stmt_stok_check->get_result();
        $produk_stok_db = $res_stok->fetch_assoc();

        if (!$produk_stok_db || $produk_stok_db['stok'] < $jumlah_item) {
            die("Error: Stok untuk produk '{$nama_produk_item}' tidak mencukupi atau produk tidak ditemukan.");
        }

        $subtotal_item_produk = $harga_item * $jumlah_item;
        $total_gross_amount += $subtotal_item_produk;

        // Tambahkan ke item_details untuk Midtrans
        $item_details_midtrans[] = [
            'id'       => $id_produk_item,
            'price'    => $harga_item,
            'quantity' => $jumlah_item,
            'name'     => $nama_produk_item
        ];

        // Simpan data untuk dimasukkan ke tabel detail_pesanan
        $produk_data_for_db[] = [
            'produk_id'   => $id_produk_item,
            'nama_produk' => $nama_produk_item,
            'harga_satuan'=> $harga_item,
            'jumlah'      => $jumlah_item,
            'subtotal'    => $subtotal_item_produk
        ];
    }
    // Tambahkan ongkir ke total keseluruhan dari keranjang
    $total_gross_amount += $ongkir_final;

}
// KASUS 2: Data datang dari snap-checkout-langsung.php (satu produk)
else if (isset($_POST['produk_id']) && !empty($_POST['produk_id'])) {
    $produk_id_single = (int)$_POST['produk_id'];
    $jumlah_single    = isset($_POST['jumlah']) ? (int)$_POST['jumlah'] : 0;

    if ($produk_id_single <= 0 || $jumlah_single <= 0) {
        die("Error: Data produk tidak valid (ID atau jumlah).");
    }

    // Ambil detail produk dari database
    $stmt_produk = $con->prepare("SELECT id, nama, harga, stok FROM produk WHERE id = ?");
    $stmt_produk->bind_param("i", $produk_id_single);
    $stmt_produk->execute();
    $result_produk = $stmt_produk->get_result();
    $produk_data = $result_produk->fetch_assoc();

    if (!$produk_data) {
        die("Error: Produk tidak ditemukan.");
    }
    if ($produk_data['stok'] < $jumlah_single) {
        die("Error: Stok untuk produk '{$produk_data['nama']}' tidak mencukupi.");
    }

    $harga_single = (float)$produk_data['harga'];
    $subtotal_single_produk = $harga_single * $jumlah_single;
    $total_gross_amount = $subtotal_single_produk + $ongkir_final;

    // Tambahkan ke item_details untuk Midtrans
    $item_details_midtrans[] = [
        'id'       => $produk_data['id'],
        'price'    => $harga_single,
        'quantity' => $jumlah_single,
        'name'     => $produk_data['nama']
    ];

    // Simpan data untuk dimasukkan ke tabel detail_pesanan
    $produk_data_for_db[] = [
        'produk_id'   => $produk_data['id'],
        'nama_produk' => $produk_data['nama'],
        'harga_satuan'=> $harga_single,
        'jumlah'      => $jumlah_single,
        'subtotal'    => $subtotal_single_produk
    ];
} else {
    // Jika tidak ada data produk yang valid dari kedua kasus
    die("Error: Data produk tidak ditemukan atau tidak valid dari formulir.");
}

// Validasi data pelanggan akhir
if (empty($nama_pembeli) || empty($no_hp) || empty($alamat) || empty($kota) || empty($metode_pembayaran)) {
    die("Error: Informasi pembeli tidak lengkap.");
}
if (empty($item_details_midtrans) || $total_gross_amount <= 0) {
    die("Error: Tidak ada item yang dapat diproses atau total pembayaran tidak valid.");
}

// --- 3. Generate Order ID dan Mulai Transaksi Database ---
$order_id = "ORDER-" . rand(1000, 9999) . "-" . time();

// Mulai transaksi database untuk menjaga konsistensi
$con->begin_transaction();

try {
    // --- 4. Insert ke Tabel `pesanan` ---
    $stmt_insert_pesanan = $con->prepare("INSERT INTO pesanan (order_id, nama_pembeli, no_hp, alamat, kota, tanggal_pesan, metode_pembayaran, total_bayar, ongkir, status_pembayaran)
                                          VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt_insert_pesanan->bind_param("sssssssdss", $order_id, $nama_pembeli, $no_hp, $alamat, $kota, $tanggal_pesan, $metode_pembayaran, $total_gross_amount, $ongkir_final, $status_pembayaran);
    $stmt_insert_pesanan->execute();
    $id_pesanan_utama = $con->insert_id; // Ambil ID pesanan yang baru dibuat

    // --- 5. Insert ke Tabel `detail_pesanan` dan Kurangi Stok Produk ---
    $stmt_insert_detail_pesanan = $con->prepare("INSERT INTO detail_pesanan (id_pesanan, produk_id, nama_produk, harga_satuan, jumlah, subtotal_item) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt_update_stok = $con->prepare("UPDATE produk SET stok = stok - ? WHERE id = ?");

    foreach ($produk_data_for_db as $item) {
        // Insert ke detail_pesanan
        $stmt_insert_detail_pesanan->bind_param("iisidd",
            $id_pesanan_utama,
            $item['produk_id'],
            $item['nama_produk'],
            $item['harga_satuan'],
            $item['jumlah'],
            $item['subtotal']
        );
        $stmt_insert_detail_pesanan->execute();

        // Kurangi stok produk
        $stmt_update_stok->bind_param("ii", $item['jumlah'], $item['produk_id']);
        $stmt_update_stok->execute();
    }

    // Jika semua berhasil, commit transaksi
    $con->commit();

} catch (mysqli_sql_exception $e) {
    // Jika ada error, rollback transaksi dan tampilkan pesan error
    $con->rollback();
    error_log("Database Error during checkout: " . $e->getMessage()); // Log error untuk debugging
    die("Terjadi kesalahan database saat memproses pesanan. Silakan coba lagi.");
}

// --- 6. Logika Pembayaran COD atau Midtrans ---

// Jika metode pembayaran COD, redirect langsung ke halaman sukses
if ($metode_pembayaran == 'cod') {
    // Kosongkan keranjang setelah pesanan COD berhasil (jika ini dari keranjang)
    unset($_SESSION['keranjang']);
    header("Location: sukses.php?order_id=" . $order_id);
    exit;
}

// --- 7. Konfigurasi dan Dapatkan Snap Token Midtrans ---
\Midtrans\Config::$serverKey = 'SB-Mid-server-E52g-bes6FS0dOQ-H_M_cD6z'; // Gunakan Server Key Anda
\Midtrans\Config::$isProduction = false; // Ganti jadi true jika sudah production
\Midtrans\Config::$isSanitized = true;
\Midtrans\Config::$is3ds = true;

$params = [
    'transaction_details' => [
        'order_id'     => $order_id,
        'gross_amount' => $total_gross_amount,
    ],
    'item_details' => $item_details_midtrans, // Ini sudah berisi semua item dari keranjang atau 1 item langsung
    'customer_details' => [
        'first_name'       => $nama_pembeli,
        'phone'            => $no_hp,
        'shipping_address' => [
            'first_name' => $nama_pembeli, // Bisa juga last_name jika nama_pembeli dipecah
            'address'    => $alamat,
            'city'       => $kota,
            'phone'      => $no_hp
        ]
    ]
];

try {
    $snapToken = \Midtrans\Snap::getSnapToken($params);
} catch (Exception $e) {
    error_log("Midtrans Snap Token Error for order ID {$order_id}: " . $e->getMessage());
    // Rollback DB transaction jika Midtrans gagal membuat token
    $con->rollback(); // Pastikan rollback jika token gagal dibuat
    die("Terjadi kesalahan saat membuat token pembayaran. Silakan coba lagi nanti. (" . $e->getMessage() . ")");
}

// --- 8. Tampilkan Halaman Pembayaran Midtrans ---
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Proses Pembayaran - KueCamilan.ID</title>
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="SB-Mid-client-W2W017lYwX0B0kYf"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background-color: #f0f2f5;
            margin: 0;
            color: #333;
            text-align: center;
        }
        h3 {
            color: #555;
            animation: pulse 1.5s infinite;
        }
        @keyframes pulse {
            0% { transform: scale(1); opacity: 1; }
            50% { transform: scale(1.05); opacity: 0.8; }
            100% { transform: scale(1); opacity: 1; }
        }
    </style>
</head>
<body>
    <h3>Mohon tunggu, sedang mengarahkan ke halaman pembayaran...</h3>

    <script type="text/javascript">
        // Panggil Snap.js
        snap.pay('<?php echo $snapToken; ?>', {
            onSuccess: function(result) {
                /* You may add your own implementation here */
                alert("✅ Pembayaran berhasil! Silakan periksa status pesanan Anda.");
                // Setelah berhasil, kosongkan keranjang dari session
                <?php if (isset($_SESSION['keranjang'])) { unset($_SESSION['keranjang']); } ?>
                window.location.href = "sukses.php?order_id=<?php echo $order_id; ?>";
            },
            onPending: function(result) {
                /* You may add your own implementation here */
                alert("⌛ Pembayaran Anda menunggu verifikasi. Mohon selesaikan pembayaran Anda.");
                window.location.href = "pending.php?order_id=<?php echo $order_id; ?>";
            },
            onError: function(result) {
                /* You may add your own implementation here */
                alert("❌ Pembayaran gagal. Silakan coba lagi.");
                window.location.href = "gagal.php?order_id=<?php echo $order_id; ?>";
            },
            onClose: function() {
                /* You may add your own implementation here */
                alert('Anda menutup jendela pembayaran. Pesanan Anda mungkin belum terbayar.');
                window.location.href = "keranjang.php"; // Atau halaman lain yang sesuai
            }
        });
    </script>
</body>
</html>