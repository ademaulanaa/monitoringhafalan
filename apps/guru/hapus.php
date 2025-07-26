\<?php
session_start();
include '../../config/database.php';
mysqli_query($kon, "START TRANSACTION");

$id_guru = $_GET['id_guru'];
$kode_guru = $_GET['kode_guru']; // Pastikan variabel ini digunakan

$hapus_admin = mysqli_query($kon, "DELETE FROM tbl_guru WHERE id_guru='$id_guru'");
$hapus_pengguna = mysqli_query($kon, "DELETE FROM tbl_user WHERE kode_pengguna='$kode_guru'"); // Perbaikan di sini

if ($hapus_admin && $hapus_pengguna) {
    mysqli_query($kon, "COMMIT");
    header("Location:../../index.php?page=guru&hapus=berhasil");
} else {
    mysqli_query($kon, "ROLLBACK");
    header("Location:../../index.php?page=guru&hapus=gagal");
}
?>
