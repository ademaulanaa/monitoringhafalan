<?php
include '../../config/database.php';

$id_tahsin = isset($_GET['id_tahsin']) ? intval($_GET['id_tahsin']) : 0;

if (!$id_tahsin) {
    echo "<div class='alert alert-danger'>Data tahsin tidak ditemukan.</div>";
    exit;
}

// Ambil id_santri untuk redirect
$sql_get_santri = "SELECT id_santri FROM tbl_tahsin WHERE id_tahsin = ?";
$stmt = mysqli_prepare($kon, $sql_get_santri);
mysqli_stmt_bind_param($stmt, "i", $id_tahsin);
mysqli_stmt_execute($stmt);
$hasil = mysqli_stmt_get_result($stmt);
$data = mysqli_fetch_assoc($hasil);

if (!$data) {
    echo "<div class='alert alert-danger'>Data tasmi tidak ditemukan.</div>";
    exit;
}

$id_santri = $data['id_santri'];

// Hapus data tahsin
$sql_delete = "DELETE FROM tbl_tahsin WHERE id_tahsin = ?";
$stmt = mysqli_prepare($kon, $sql_delete);
if ($stmt) {
    mysqli_stmt_bind_param($stmt, "i", $id_tahsin);
    if (mysqli_stmt_execute($stmt)) {
        mysqli_commit($kon);
        header("Location: ../../index.php?page=riwayat_hafalan_santri&id_santri=$id_santri&hapus=berhasil");
        echo "<div class='alert alert-danger'>Riwayat tasmi berhasil dihapus.</div>";
        exit();
    } else {
        throw new Exception("Gagal menghapus data: " . mysqli_error($kon));
    }
    mysqli_stmt_close($stmt);

} 
?>
