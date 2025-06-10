<?php
require "session.php";
require "koneksi.php";


$query = mysqli_query($con, "SELECT pesanan.*, produk.nama AS nama_produk 
                             FROM pesanan 
                             JOIN produk ON pesanan.produk_id = produk.id 
                             ORDER BY pesanan.id DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Pesanan</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>
<?php require "navbar.php"; ?>

<div class="container mt-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php" class="text-decoration-none">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Data Pesanan</li>
        </ol>
    </nav>

    <h2 class="mb-4">Daftar Pesanan</h2>

    <div class="table-responsive">
        <table class="table table-striped">
            <thead class="table-light">
                <tr>
                    <th>No.</th>
                    <th>Produk</th>
                    <th>Nama Pembeli</th>
                    <th>Alamat</th>
                    <th>Jumlah</th>
                    <th>Tanggal Pesan</th>
                    <th>Metode Pembayaran</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                while($row = mysqli_fetch_assoc($query)):
                ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td><?= htmlspecialchars($row['nama_produk']); ?></td>
                    <td><?= htmlspecialchars($row['nama_pembeli']); ?></td>
                    <td><?= htmlspecialchars($row['alamat']); ?></td>
                    <td><?= (int)$row['jumlah']; ?></td>
                    <td><?= $row['tanggal_pesan']; ?></td>
                    <td><?= strtoupper($row['metode_pembayaran']); ?></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>
