<?php
// Ambil ID hafalan dari URL
$id_hafalan = isset($_GET['id_hafalan']) ? intval($_GET['id_hafalan']) : null;

if (!$id_hafalan) {
    echo "<div class='alert alert-danger'>Hafalan tidak ditemukan.</div>";
    exit;
}

include '../../config/database.php';

// Ambil id_santri untuk redirect setelah hapus
$query_santri = "SELECT id_santri FROM tbl_hafalan WHERE id_hafalan = ?";
$stmt = mysqli_prepare($kon, $query_santri);
mysqli_stmt_bind_param($stmt, "i", $id_hafalan);
mysqli_stmt_execute($stmt);
$result_santri = mysqli_stmt_get_result($stmt);
$data_santri = mysqli_fetch_assoc($result_santri);
mysqli_stmt_close($stmt);

if (!$data_santri) {
    echo "<div class='alert alert-danger'>Data hafalan tidak ditemukan.</div>";
    exit;
}

$id_santri = $data_santri['id_santri'];

// Query hapus data hafalan menggunakan prepared statement
$sql = "DELETE FROM tbl_hafalan WHERE id_hafalan = ?";
$stmt = mysqli_prepare($kon, $sql);
mysqli_stmt_bind_param($stmt, "i", $id_hafalan);

if (mysqli_stmt_execute($stmt)) {
    mysqli_stmt_close($stmt);
    header("Location: ../../index.php?page=riwayat_hafalan_santri&id_santri=$id_santri&hapus=berhasil");
} else {
    mysqli_stmt_close($stmt);
    header("Location: ../../index.php?page=riwayat_hafalan_santri&id_santri=$id_santri&hapus=gagal");
}
?>
