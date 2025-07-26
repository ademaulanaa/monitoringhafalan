<?php
if ($_SESSION["level"] != 'Admin' && $_SESSION["level"] != 'admin' && 
    $_SESSION["level"] != 'guru' && $_SESSION["level"] != 'Guru') {
    echo "<br><div class='alert alert-danger'>Tidak memiliki Hak Akses</div>";
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Hafalan</title>
    <link rel="stylesheet" href="../../template/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../template/css/font-awesome.min.css">
    <link rel="stylesheet" href="../../template/css/data-hafalan.css">
</head>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                Pilih Kelas
            </div>
            <div class="panel-body">
                <div class="row">
                    <?php
                    include 'config/database.php';

                    $sql_kelas = "SELECT * FROM tbl_kelas";
                    $hasil_kelas = mysqli_query($kon, $sql_kelas);

                    if (!$hasil_kelas) {
                        echo "<div class='col-md-12'><div class='alert alert-danger'>Gagal mengambil data kelas: " . mysqli_error($kon) . "</div></div>";
                    } else {
                        while ($data_kelas = mysqli_fetch_array($hasil_kelas)) :
                            $id_kelas = $data_kelas['id_kelas'];
                            $sql_santri = "SELECT COUNT(*) AS jumlah_santri FROM tbl_santri WHERE id_kelas = ?";
                            $stmt = mysqli_prepare($kon, $sql_santri);
                            mysqli_stmt_bind_param($stmt, "i", $id_kelas);
                            mysqli_stmt_execute($stmt);
                            $hasil_santri = mysqli_stmt_get_result($stmt);
                            $data_santri = mysqli_fetch_assoc($hasil_santri);
                            $jumlah_santri = $data_santri['jumlah_santri'];
                    ?>
                            <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                                <div class="card kelas-card">
                                    <div class="card-body text-center">
                                        <h5 class="card-title"><?php echo htmlspecialchars($data_kelas['nama_kelas']); ?></h5>
                                        <p class="card-text"><?php echo $jumlah_santri; ?> Santri</p>
                                        <a href="index.php?page=hafalan_santri&id_kelas=<?php echo $data_kelas['id_kelas']; ?>" class="btn btn-primary btn-sm">
                                            Lihat Santri
                                        </a>
                                    </div>
                                </div>
                            </div>
                    <?php endwhile;
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .kelas-card {
        border: 3px rgb(17, 85, 156);
        border-radius: 0px;
        background-color: #f8f9fa;
        box-shadow: 3px 3px 12px rgb(177, 68, 77);
        padding: 15px;
    }

    .kelas-card:hover {
        background-color: #d1ecf1;
        box-shadow: 4px 4px 15px rgba(0, 0, 0, 0.25);
    }

    .col-lg-3, .col-md-4, .col-sm-6 {
        margin-bottom: 20px;
    }
</style>
