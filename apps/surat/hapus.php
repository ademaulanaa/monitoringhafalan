<?php
session_start();
include '../../config/database.php';

// Ambil ID surat dari URL
$id_surat = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Cek apakah data surat ada
$check_query = "SELECT * FROM tbl_surat WHERE id_surat = $id_surat";
$check_result = mysqli_query($kon, $check_query);

if (mysqli_num_rows($check_result) > 0) {
    // Hapus data surat
    $delete_query = "DELETE FROM tbl_surat WHERE id_surat = $id_surat";
    $delete_result = mysqli_query($kon, $delete_query);
    
    if ($delete_result) {
        header("Location: ../../index.php?page=surat&hapus=berhasil");
    } else {
        header("Location: ../../index.php?page=surat&hapus=gagal");
    }
} else {
    header("Location: ../../index.php?page=surat&error=notfound");
}

exit();
?> 