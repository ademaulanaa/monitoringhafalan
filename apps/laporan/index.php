<?php 
if ($_SESSION["level"] != 'Admin' && $_SESSION["level"] != 'admin' && 
$_SESSION["level"] != 'guru' && $_SESSION["level"] != 'Guru'){
    echo "<br><div class='alert alert-danger'>Tidak Memiliki Hak Akses</div>";
    exit;
}
?>

<style>
.panel {
    border: none;
    box-shadow: 0 0 10px rgba(0,0,0,0.1);
    margin-bottom: 20px;
}
.panel-heading {
    background-color:rgb(255, 255, 255) !important;
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
    background-color: #fff5f5;
    padding: 15px;
    border-radius: 5px;
    margin-bottom: 20px;
    border: 1px solidrgb(247, 241, 242);
}
.section-title {
    font-weight: bold;
    margin-bottom: 15px;
    padding-bottom: 10px;
    border-bottom: 2px solid #dc3545;
    color: #dc3545;
}
.table-responsive {
    margin-top: 15px;
}
.table > thead > tr > th {
    background-color:rgb(245, 145, 155);
    color: white;
    font-weight: bold;
}
.table > tbody > tr:nth-child(even) {
    background-color: #fff5f5;
}
.table > tbody > tr:hover {
    background-color: #ffe5e5;
}
.btn-primary {
    background-color: #dc3545;
    border-color: #dc3545;
}
.btn-primary:hover {
    background-color: #c82333;
    border-color: #bd2130;
}
.btn-success {
    background-color: #28a745;
    border-color: #28a745;
}
.btn-success:hover {
    background-color: #218838;
    border-color: #1e7e34;
}
.form-control:focus {
    border-color: #dc3545;
    box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);
}
</style>

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="mb-0">Laporan Hafalan Santri</h4>
            </div>
            <div class="panel-body">
                <!-- Form Filter -->
                <div class="filter-form">
                    <form method="GET" class="form-inline">
                        <input type="hidden" name="page" value="laporan">
                        <div class="form-group mx-sm-3">
                            <label class="mr-2">Kelas:</label>
                            <select name="id_kelas" class="form-control">
                                <option value="">Semua Kelas</option>
                                <?php
                                include '../../config/database.php';
                                $sql_kelas = "SELECT * FROM tbl_kelas ORDER BY nama_kelas";
                                $hasil_kelas = mysqli_query($kon, $sql_kelas);
                                while ($data_kelas = mysqli_fetch_assoc($hasil_kelas)) {
                                    $selected = (isset($_GET['id_kelas']) && $_GET['id_kelas'] == $data_kelas['id_kelas']) ? 'selected' : '';
                                    echo "<option value='" . $data_kelas['id_kelas'] . "' " . $selected . ">" . $data_kelas['nama_kelas'] . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group mx-sm-3">
                            <label class="mr-2">Dari Tanggal:</label>
                            <input type="date" name="start_date" class="form-control" value="<?php echo isset($_GET['start_date']) ? $_GET['start_date'] : ''; ?>">
                        </div>
                        <div class="form-group mx-sm-3">
                            <label class="mr-2">Sampai Tanggal:</label>
                            <input type="date" name="end_date" class="form-control" value="<?php echo isset($_GET['end_date']) ? $_GET['end_date'] : date('Y-m-d'); ?>">
                        </div>
                        <button type="submit" class="btn btn-primary mr-2">
                            <i class="fa fa-search"></i> Tampilkan
                        </button>
                        <a href="apps/laporan/cetak_laporan.php?id_kelas=<?php echo isset($_GET['id_kelas']) ? $_GET['id_kelas'] : ''; ?>&start_date=<?php echo isset($_GET['start_date']) ? $_GET['start_date'] : ''; ?>&end_date=<?php echo isset($_GET['end_date']) ? $_GET['end_date'] : date('Y-m-d'); ?>" 
                           class="btn btn-success" target="_blank">
                            <i class="fa fa-file-pdf-o"></i> Cetak PDF
                        </a>
                    </form>
                </div>

                <?php
                // Set default values jika tidak ada filter
                $id_kelas = isset($_GET['id_kelas']) ? intval($_GET['id_kelas']) : '';
                $start_date = isset($_GET['start_date']) && !empty($_GET['start_date']) ? $_GET['start_date'] : '1970-01-01';
                $end_date = isset($_GET['end_date']) && !empty($_GET['end_date']) ? $_GET['end_date'] : date('Y-m-d');

                // Query untuk mengambil data santri
                $sql_santri = "SELECT s.*, k.nama_kelas,
                             (SELECT jumlah_juz FROM tbl_jumlah_juz j WHERE j.id_santri = s.id_santri) as jumlah_juz,
                             (SELECT tambah_juz FROM tbl_tasmi t 
                              WHERE t.id_santri = s.id_santri 
                              AND t.tanggal BETWEEN ? AND ?
                              ORDER BY t.tanggal DESC, t.id_tasmi DESC LIMIT 1) as tasmi_terakhir,
                             (SELECT CONCAT(sr.nama_surat, ':', h.ayat) 
                              FROM tbl_hafalan h 
                              LEFT JOIN tbl_surat sr ON h.id_surat = sr.id_surat
                              WHERE h.id_santri = s.id_santri 
                              AND h.tgl_hafalan BETWEEN ? AND ?
                              ORDER BY h.tgl_hafalan DESC, h.id_hafalan DESC LIMIT 1) as hafalan_terakhir
                             FROM tbl_santri s 
                             LEFT JOIN tbl_kelas k ON s.id_kelas = k.id_kelas";
                
                $params = array($start_date, $end_date, $start_date, $end_date);
                $types = "ssss";

                if($id_kelas) {
                    $sql_santri .= " WHERE s.id_kelas = ?";
                    $params[] = $id_kelas;
                    $types .= "i";
                }

                $sql_santri .= " ORDER BY k.nama_kelas, s.nama_santri";
                
                $stmt = mysqli_prepare($kon, $sql_santri);
                mysqli_stmt_bind_param($stmt, $types, ...$params);
                mysqli_stmt_execute($stmt);
                $hasil_santri = mysqli_stmt_get_result($stmt);
                ?>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>NIS</th>
                                <th>Nama Santri</th>
                                <th>Kelas</th>
                                <th>Jumlah Juz</th>
                                <th>Juz Tasmi Terakhir</th>
                                <th>Surat Hafalan Terakhir</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            while ($data_santri = mysqli_fetch_assoc($hasil_santri)) {
                                echo '<tr>';
                                echo '<td>' . $no++ . '</td>';
                                echo '<td>' . htmlspecialchars($data_santri['nis']) . '</td>';
                                echo '<td>' . htmlspecialchars($data_santri['nama_santri']) . '</td>';
                                echo '<td>' . htmlspecialchars($data_santri['nama_kelas']) . '</td>';
                                echo '<td class="text-center">' . ($data_santri['jumlah_juz'] ? htmlspecialchars($data_santri['jumlah_juz']) : '-') . '</td>';
                                echo '<td class="text-center">' . ($data_santri['tasmi_terakhir'] ? htmlspecialchars($data_santri['tasmi_terakhir']) : '-') . '</td>';
                                echo '<td class="text-center">' . ($data_santri['hafalan_terakhir'] ? htmlspecialchars($data_santri['hafalan_terakhir']) : '-') . '</td>';
                                echo '</tr>';
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>