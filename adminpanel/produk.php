<?php
require "session.php";
require "koneksi.php";

// Initialize a message variable
$message = '';

// Process form submission to add a new product
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['new_product'])) {
    $namaProduk = mysqli_real_escape_string($con, $_POST['nama_produk']);
    $hargaProduk = mysqli_real_escape_string($con, $_POST['harga_produk']);
    $detailProduk = mysqli_real_escape_string($con, $_POST['detail_produk']);
    $kategoriId = mysqli_real_escape_string($con, $_POST['kategori_id']);
    $ketersediaanStok = mysqli_real_escape_string($con, $_POST['ketersediaan_stok']);
    $stok = (int) $_POST['stok_produk'];

    // Handle file upload
    $fotoProduk = '';
    if (isset($_FILES['foto_produk']) && $_FILES['foto_produk']['error'] == 0) {
        $fotoProduk = '../image/' . $_FILES['foto_produk']['name'];
        move_uploaded_file($_FILES['foto_produk']['tmp_name'], $fotoProduk);
    }

    // Insert the new product into the database
    $insertProduct = mysqli_query($con, "INSERT INTO produk (kategori_id, nama, harga, detail, foto, ketersediaan_stok, stok) 
    VALUES ('$kategoriId', '$namaProduk', '$hargaProduk', '$detailProduk', '$fotoProduk', '$ketersediaanStok', '$stok')");

    if ($insertProduct) {
        $message = "Produk baru berhasil ditambahkan!";
    } else {
        $message = "Gagal menambahkan produk. Coba lagi.";
    }
}

// Handle Edit Product
if (isset($_GET['edit'])) {
    $productId = $_GET['edit'];
    $queryEdit = mysqli_query($con, "SELECT * FROM produk WHERE id = '$productId'");
    $product = mysqli_fetch_array($queryEdit);

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['edit_product'])) {
        $namaProduk = mysqli_real_escape_string($con, $_POST['nama_produk']);
        $hargaProduk = mysqli_real_escape_string($con, $_POST['harga_produk']);
        $detailProduk = mysqli_real_escape_string($con, $_POST['detail_produk']);
        $kategoriId = mysqli_real_escape_string($con, $_POST['kategori_id']);
        $ketersediaanStok = mysqli_real_escape_string($con, $_POST['ketersediaan_stok']);
        $stok = (int) $_POST['stok_produk'];

        $fotoProduk = $product['foto'];
        if (isset($_FILES['foto_produk']) && $_FILES['foto_produk']['error'] == 0) {
            $fotoProduk = '../image/' . $_FILES['foto_produk']['name'];
            move_uploaded_file($_FILES['foto_produk']['tmp_name'], $fotoProduk);
        }

        $updateProduct = mysqli_query($con, "UPDATE produk SET kategori_id = '$kategoriId', nama = '$namaProduk', harga = '$hargaProduk', detail = '$detailProduk', foto = '$fotoProduk', ketersediaan_stok = '$ketersediaanStok', stok = '$stok' WHERE id = '$productId'");

        if ($updateProduct) {
            $message = "Produk berhasil diperbarui!";
            header("Location: produk.php");
        } else {
            $message = "Gagal memperbarui produk. Coba lagi.";
        }
    }
}

// Handle Delete Product
if (isset($_GET['delete'])) {
    $productId = $_GET['delete'];
    $deleteProduct = mysqli_query($con, "DELETE FROM produk WHERE id = '$productId'");

    if ($deleteProduct) {
        $message = "Produk berhasil dihapus!";
    } else {
        $message = "Gagal menghapus produk. Coba lagi.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Produk</title>
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
            <li class="breadcrumb-item active" aria-current="page">Tambah Produk</li>
        </ol>
    </nav>

    <h2 class="mb-4">Tambah Produk Baru</h2>

    <?php if ($message) { ?>
        <div class="alert alert-info"><?= $message; ?></div>
    <?php } ?>

    <form method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="nama_produk" class="form-label">Nama Produk</label>
            <input type="text" class="form-control" id="nama_produk" name="nama_produk" value="<?= isset($product) ? $product['nama'] : ''; ?>" required>
        </div>

        <div class="mb-3">
            <label for="harga_produk" class="form-label">Harga Produk</label>
            <input type="number" class="form-control" id="harga_produk" name="harga_produk" value="<?= isset($product) ? $product['harga'] : ''; ?>" required>
        </div>

        <div class="mb-3">
            <label for="detail_produk" class="form-label">Detail Produk</label>
            <textarea class="form-control" id="detail_produk" name="detail_produk" rows="3" required><?= isset($product) ? $product['detail'] : ''; ?></textarea>
        </div>

        <div class="mb-3">
            <label for="kategori_id" class="form-label">Kategori Produk</label>
            <select class="form-select" id="kategori_id" name="kategori_id" required>
                <?php
                $queryKategori = mysqli_query($con, "SELECT * FROM kategori");
                while ($kategori = mysqli_fetch_array($queryKategori)) {
                    $selected = (isset($product) && $product['kategori_id'] == $kategori['id']) ? 'selected' : '';
                    echo "<option value='{$kategori['id']}' {$selected}>{$kategori['nama']}</option>";
                }
                ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="foto_produk" class="form-label">Foto Produk</label>
            <input type="file" class="form-control" id="foto_produk" name="foto_produk" accept="image/*">
            <?php if (isset($product) && $product['foto'] != '') { ?>
                <img src="<?= $product['foto']; ?>" alt="Foto Produk" width="100" class="mt-2">
            <?php } ?>
        </div>

        <div class="mb-3">
            <label for="ketersediaan_stok" class="form-label">Ketersediaan Stok</label>
            <select class="form-select" id="ketersediaan_stok" name="ketersediaan_stok" required>
                <option value="tersedia" <?= isset($product) && $product['ketersediaan_stok'] == 'tersedia' ? 'selected' : ''; ?>>Tersedia</option>
                <option value="habis" <?= isset($product) && $product['ketersediaan_stok'] == 'habis' ? 'selected' : ''; ?>>Habis</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="stok_produk" class="form-label">Jumlah Stok</label>
            <input type="number" class="form-control" id="stok_produk" name="stok_produk" value="<?= isset($product) ? $product['stok'] : '0'; ?>" min="0" required>
        </div>

        <?php if (isset($product)) { ?>
            <button type="submit" class="btn btn-warning" name="edit_product">Perbarui Produk</button>
        <?php } else { ?>
            <button type="submit" class="btn btn-primary" name="new_product">Tambah Produk</button>
        <?php } ?>
    </form>

    <hr>

    <h3 class="mt-4">Produk yang Sudah Ditambahkan</h3>
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Nama Produk</th>
                    <th>Harga</th>
                    <th>Kategori</th>
                    <th>Foto</th>
                    <th>Stok</th>
                    <th>Ketersediaan Stok</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $queryProduk = mysqli_query($con, "SELECT produk.*, kategori.nama as kategori_name FROM produk INNER JOIN kategori ON produk.kategori_id = kategori.id");
                $no = 1;
                while ($produk = mysqli_fetch_array($queryProduk)) {
                ?>
                    <tr>
                        <td><?= $no++; ?></td>
                        <td><?= $produk['nama']; ?></td>
                        <td><?= number_format($produk['harga'], 0, ',', '.'); ?></td>
                        <td><?= $produk['kategori_name']; ?></td>
                        <td>
                            <img src="<?= $produk['foto']; ?>" alt="Foto Produk" width="100">
                        </td>
                        <td><?= $produk['stok']; ?></td>
                        <td><?= ucfirst($produk['ketersediaan_stok']); ?></td>
                        <td>
                            <a href="produk.php?edit=<?= $produk['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                            <a href="produk.php?delete=<?= $produk['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus produk ini?')">Hapus</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>
