<?php
session_start();
include '../../config/database.php';
mysqli_query($kon, "START TRANSACTION");

$id_santri = $_GET['id_santri'];
$kode_santri = $_GET['kode_santri']; // Pastikan variabel ini digunakan

$hapus_admin = mysqli_query($kon, "DELETE FROM tbl_santri WHERE id_santri='$id_santri'");
$hapus_pengguna = mysqli_query($kon, "DELETE FROM tbl_user WHERE kode_pengguna='$kode_santri'"); // Perbaikan di sini

if ($hapus_admin && $hapus_pengguna) {
    mysqli_query($kon, "COMMIT");
    header("Location:../../index.php?page=santri&hapus=berhasil");
} else {
    mysqli_query($kon, "ROLLBACK");
    header("Location:../../index.php?page=santri&hapus=gagal");
}
?>
