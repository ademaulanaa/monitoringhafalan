<?php
session_start();
include '../../config/database.php'; // Pastikan path ini benar
mysqli_query($kon, "START TRANSACTION");

$id_kelas = $_GET['id_kelas'];

// Update siswa agar id_kelas menjadi NULL sebelum kelas dihapus
$update_siswa = mysqli_query($kon, "UPDATE tbl_santri SET id_kelas=NULL WHERE id_kelas='$id_kelas'");

// Hapus kelas setelah update siswa berhasil
$hapus_kelas = mysqli_query($kon, "DELETE FROM tbl_kelas WHERE id_kelas='$id_kelas'");

if ($hapus_kelas) {
    mysqli_query($kon, "COMMIT");
    header("Location:../../index.php?page=kelas&hapus=berhasil");
} else {
    mysqli_query($kon, "ROLLBACK");
    header("Location:../../index.php?page=kelas&hapus=gagal");
}
?>
