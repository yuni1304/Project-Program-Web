<?php
require "session.php";
require "koneksi.php";


$id = isset($_GET['id']) ? $_GET['id'] : '';


if (empty($id)) {
    header("Location: kategori.php");
    exit();
}


$id = mysqli_real_escape_string($con, $id);


$hapus = mysqli_query($con, "DELETE FROM kategori WHERE id = '$id'");


header("Location: kategori.php");
exit();
?>
