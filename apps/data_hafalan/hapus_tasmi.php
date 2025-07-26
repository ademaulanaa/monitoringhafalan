<?php
session_start();
// Cek apakah user sudah login
if (!isset($_SESSION['level'])) {
    header("Location: ../../index.php");
    exit();
}

// Ambil ID tasmi dari URL
$id_tasmi = isset($_GET['id_tasmi']) ? intval($_GET['id_tasmi']) : null;

if (!$id_tasmi) {
    echo "<div class='alert alert-danger'>Data tasmi tidak ditemukan.</div>";
    exit;
}

include '../../config/database.php';

// Mulai transaksi
mysqli_begin_transaction($kon);

try {
    // Ambil id_santri untuk redirect setelah hapus
    $query_santri = "SELECT id_santri FROM tbl_tasmi WHERE id_tasmi = ?";
    $stmt = mysqli_prepare($kon, $query_santri);
    
    if (!$stmt) {
        throw new Exception("Error dalam persiapan query: " . mysqli_error($kon));
    }

    mysqli_stmt_bind_param($stmt, "i", $id_tasmi);
    mysqli_stmt_execute($stmt);
    $result_santri = mysqli_stmt_get_result($stmt);
    $data_santri = mysqli_fetch_assoc($result_santri);
    mysqli_stmt_close($stmt);

    if (!$data_santri) {
        throw new Exception("Data tasmi tidak ditemukan.");
    }

    $id_santri = $data_santri['id_santri'];

    // Query hapus data tasmi menggunakan prepared statement
    $sql = "DELETE FROM tbl_tasmi WHERE id_tasmi = ?";
    $stmt = mysqli_prepare($kon, $sql);
    
    if (!$stmt) {
        throw new Exception("Error dalam persiapan query: " . mysqli_error($kon));
    }

    mysqli_stmt_bind_param($stmt, "i", $id_tasmi);

    if (mysqli_stmt_execute($stmt)) {
        mysqli_commit($kon);
        header("Location: ../../index.php?page=riwayat_hafalan_santri&id_santri=$id_santri&hapus=berhasil");
        echo "<div class='alert alert-danger'>Riwayat tasmi berhasil dihapus.</div>";
        exit();
    } else {
        throw new Exception("Gagal menghapus data: " . mysqli_error($kon));
    }
    mysqli_stmt_close($stmt);

} catch (Exception $e) {
    mysqli_rollback($kon);
    echo "<div class='alert alert-danger'>" . $e->getMessage() . "</div>";
}
?>
