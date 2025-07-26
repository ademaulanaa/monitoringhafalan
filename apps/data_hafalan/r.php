<?php
// Pastikan santri sudah login
if (!isset($_SESSION['id_santri'])) {
    echo "<div class='alert alert-danger'>Anda belum login sebagai santri.</div>";
    exit;
}

// Ambil id_santri dari session
$id_santri = intval($_SESSION['id_santri']);

// Koneksi database
include 'config/database.php';

// Ambil data santri
$sql_santri = "SELECT * FROM tbl_santri WHERE id_santri = ?";
$stmt = mysqli_prepare($kon, $sql_santri);
mysqli_stmt_bind_param($stmt, "i", $id_santri);
mysqli_stmt_execute($stmt);
$hasil_santri = mysqli_stmt_get_result($stmt);
$data_santri = mysqli_fetch_assoc($hasil_santri);

if (!$data_santri) {
    echo "<div class='alert alert-danger'>Santri tidak ditemukan.</div>";
    exit;
}

// Filter tanggal
$start_date = isset($_GET['start_date']) ? $_GET['start_date'] : '';
$end_date = isset($_GET['end_date']) ? $_GET['end_date'] : date('Y-m-d');
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Hafalan - <?php echo htmlspecialchars($data_santri['nama_santri']); ?></title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/font-awesome.min.css">
    <link rel="stylesheet" href="../../template/css/data-hafalan.css">
    <style>
        .panel {
            border: none;
            box-shadow: 0 0 10px rgba(10, 0, 0, 0.1);
            margin-bottom: 20px;
        }
        .panel-heading {
            background-color: rgb(252, 251, 251) !important;
            color: white !important;
            padding: 15px;
            border-radius: 5px 5px 0 0;
        }
        .panel-body {
            padding: 20px;
            background-color: white;
            border-radius: 0 0 5px 5px;
        }
        .filter-form {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .section-title {
            font-weight: bold;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 2px solid rgb(182, 71, 82);
            color: rgb(19, 1, 5);
        }
        .table-responsive {
            margin-top: 15px;
        }
        .table > thead > tr > th {
            background-color: rgb(182, 71, 82);
            color: white;
            font-weight: bold;
        }
        .table > tbody > tr:nth-child(even) {
            background-color: #f8f9fa;
        }
        .table > tbody > tr:hover {
            background-color: #e9ecef;
        }
        .btn-primary {
            background-color: rgb(182, 71, 82) !important;
            border-color: rgb(182, 71, 82) !important;
        }
        .btn-primary:hover {
            background-color: rgb(189, 3, 22) !important;
            border-color: rgb(189, 3, 22) !important;
        }
    </style>
</head>
<body>

<div class="container mt-4">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="mb-0">Monitoring Hafalan - <?php echo htmlspecialchars($data_santri['nama_santri']); ?></h4>
                </div>
                <div class="panel-body">
                    <!-- Form Filter Tanggal -->
                    <div class="filter-form">
                    <form method="GET" class="form-inline">
                        <input type="hidden" name="page" value="r">
                        <input type="hidden" name="id_santri" value="<?php echo $id_santri; ?>">
                            <div class="form-group mx-sm-3">
                                <label class="mr-2">Dari Tanggal:</label>
                                <input type="date" name="start_date" class="form-control" value="<?php echo $start_date; ?>">
                            </div>
                            <div class="form-group mx-sm-3">
                                <label class="mr-2">Sampai Tanggal:</label>
                                <input type="date" name="end_date" class="form-control" value="<?php echo $end_date; ?>">
                            </div>
                            <button type="submit" class="btn btn-primary mr-2">
                                <i class="fa fa-search"></i> Tampilkan
                            </button>
                            <a href="apps/data_hafalan/cetak_laporan.php?id_santri=<?php echo $id_santri; ?>&start_date=<?php echo $start_date; ?>&end_date=<?php echo $end_date; ?>" class="btn btn-success" target="_blank">
                                <i class="fa fa-file-pdf-o"></i> Download PDF
                            </a>
                        </form>
                    </div>

                    <!-- Panel Jumlah Juz -->
                    <div class="section-title">JUMLAH JUZ HAFALAN</div>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Jumlah Juz</th>
                                    <th>Keterangan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sql_juz = "SELECT * FROM tbl_jumlah_juz WHERE id_santri = ?";
                                $stmt = mysqli_prepare($kon, $sql_juz);
                                mysqli_stmt_bind_param($stmt, "i", $id_santri);
                                mysqli_stmt_execute($stmt);
                                $hasil_juz = mysqli_stmt_get_result($stmt);
                                $data_juz = mysqli_fetch_assoc($hasil_juz);

                                if ($data_juz) {
                                    echo "<tr>";
                                    echo "<td>" . htmlspecialchars($data_juz['jumlah_juz']) . "</td>";
                                    echo "<td>" . htmlspecialchars($data_juz['keterangan']) . "</td>";
                                    echo "</tr>";
                                } else {
                                    echo "<tr><td colspan='2' class='text-center'>Belum ada data jumlah juz.</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- Panel Riwayat Tasmi -->
                    <div class="section-title">RIWAYAT TASMI</div>
                    
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th style="width: 5%">No</th>
                                    <th style="width: 12%">Tanggal Tasmi</th>
                                    <th style="width: 10%">Tambah Juz</th>
                                    <th style="width: 10%">Juz Tasmi</th>
                                    <th style="width: 10%">Khofi</th>
                                    <th style="width: 10%">Jali</th>
                                    <th style="width: 10%">Status</th>
                                    <th style="width: 10%">Penyimak</th>
                                    <th>Keterangan</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                            $sql_tasmi = "SELECT * FROM tbl_tasmi WHERE id_santri = ?";
                            $params = array($id_santri);
                            $types = "i";

                            if($start_date && $end_date) {
                                $sql_tasmi .= " AND tanggal BETWEEN ? AND ?";
                                $params[] = $start_date;
                                $params[] = $end_date;
                                $types .= "ss";
                                $sql_tasmi .= " ORDER BY tanggal DESC";
                            } else {
                                $sql_tasmi .= " ORDER BY tanggal DESC LIMIT 10";
                            }
                            
            $stmt = mysqli_prepare($kon, $sql_tasmi);
                            mysqli_stmt_bind_param($stmt, $types, ...$params);
            mysqli_stmt_execute($stmt);
            $hasil_tasmi = mysqli_stmt_get_result($stmt);

            $no = 1;
            while ($data_tasmi = mysqli_fetch_assoc($hasil_tasmi)) :
            ?>
                                    <tr>
                                        <td class="text-center"><?php echo $no++; ?></td>
                                        <td class="text-center"><?php echo date('d-m-Y', strtotime($data_tasmi['tanggal'])); ?></td>
                                        <td class="text-center"><?php echo htmlspecialchars($data_tasmi['tambah_juz']); ?></td>
                                        <td class="text-center"><?php echo htmlspecialchars($data_tasmi['juz_tasmi']); ?></td>
                                        <td class="text-center"><?php echo htmlspecialchars($data_tasmi['khofi']); ?></td>
                                        <td class="text-center"><?php echo htmlspecialchars($data_tasmi['jali']); ?></td>
                                        <td class="text-center"><?php echo htmlspecialchars($data_tasmi['status']); ?></td>
                                        <td class="text-center"><?php echo htmlspecialchars($data_tasmi['penyimak']); ?></td>
                                        <td><?php echo htmlspecialchars($data_tasmi['keterangan']); ?></td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- Panel Riwayat Hafalan -->
                    <div class="section-title">RIWAYAT HAFALAN</div>
                    
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th style="width: 5%">No</th>
                                    <th style="width: 15%">Tanggal Hafalan</th>
                                    <th style="width: 15%">Surat</th>
                                    <th style="width: 15%">Ayat</th>
                                    <th style="width: 10%">Juz</th>
                                    <th style="width: 10%">Status</th>
                                    <th>Keterangan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sql_hafalan = "SELECT h.*, s.nama_surat 
                                                FROM tbl_hafalan h 
                                                JOIN tbl_surat s ON h.id_surat = s.id_surat
                                                WHERE h.id_santri = ?";
                                $params = array($id_santri);
                                $types = "i";
    
                                if($start_date && $end_date) {
                                    $sql_hafalan .= " AND h.tgl_hafalan BETWEEN ? AND ?";
                                    $params[] = $start_date;
                                    $params[] = $end_date;
                                    $types .= "ss";
                                    $sql_hafalan .= " ORDER BY h.tgl_hafalan DESC";
                                } else {
                                    $sql_hafalan .= " ORDER BY h.tgl_hafalan DESC LIMIT 10";
                                }
                                
                                $stmt = mysqli_prepare($kon, $sql_hafalan);
                                mysqli_stmt_bind_param($stmt, $types, ...$params);
                                mysqli_stmt_execute($stmt);
                                $hasil_hafalan = mysqli_stmt_get_result($stmt);
    
                                $no = 0;
                                while ($data_hafalan = mysqli_fetch_assoc($hasil_hafalan)) :
                                    $no++;
                                ?>
                                    <tr>
                                        <td class="text-center"><?php echo $no++; ?></td>
                                        <td class="text-center"><?php echo date('d-m-Y', strtotime($data_hafalan['tgl_hafalan'])); ?></td>
                                        <td><?php echo htmlspecialchars($data_hafalan['nama_surat']); ?></td>
                                        <td class="text-center"><?php echo $data_hafalan['ayat']; ?></td>
                                        <td class="text-center"><?php echo $data_hafalan['juz']; ?></td>
                                        <td class="text-center"><?php echo htmlspecialchars($data_hafalan['status']); ?></td>
                                        <td><?php echo htmlspecialchars($data_hafalan['keterangan']); ?></td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
</body>
</html>