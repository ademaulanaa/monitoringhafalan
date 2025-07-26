<?php
// Ambil ID kelas dari URL
$id_kelas = isset($_GET['id_kelas']) ? intval($_GET['id_kelas']) : null;

if (!$id_kelas) {
    echo "<div class='alert alert-danger'>Kelas tidak ditemukan.</div>";
    exit;
}

include 'config/database.php';

// Query untuk mengambil data kelas
$sql_kelas = "SELECT * FROM tbl_kelas WHERE id_kelas = ?";
$stmt = mysqli_prepare($kon, $sql_kelas);
mysqli_stmt_bind_param($stmt, "i", $id_kelas);
mysqli_stmt_execute($stmt);
$hasil_kelas = mysqli_stmt_get_result($stmt);
$data_kelas = mysqli_fetch_assoc($hasil_kelas);

if (!$data_kelas) {
    echo "<div class='alert alert-danger'>Kelas tidak ditemukan.</div>";
    exit;
}
?>


<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">  
            <div class="panel-heading">
                Daftar Santri - <?php echo htmlspecialchars($data_kelas['nama_kelas']); ?>
                <span class="pull-right clickable panel-toggle panel-button-tab-left"><em class="fa fa-toggle-up"></em></span>
            </div>
            <div class="panel-body">
                <div class="form-group">
                    <a href="index.php?page=data_hafalan" class="btn btn-primary">
                        <i class="fa fa-arrow-left"></i> Kembali
                    </a>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped table-hover table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead class="thead-dark text-center">
                            <tr>
                                <th>No</th>
                                <th>Nama Santri</th>
                                
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Query untuk mengambil data santri berdasarkan kelas
                            $sql_santri = "SELECT * FROM tbl_santri WHERE id_kelas = ? ORDER BY nama_santri ASC";
                            $stmt = mysqli_prepare($kon, $sql_santri);
                            mysqli_stmt_bind_param($stmt, "i", $id_kelas);
                            mysqli_stmt_execute($stmt);
                            $hasil_santri = mysqli_stmt_get_result($stmt);

                            if (!$hasil_santri) {
                                echo "<tr><td colspan='4' class='text-center'>Gagal mengambil data santri: " . mysqli_error($kon) . "</td></tr>";
                            } else {
                                $no = 0;
                                while ($data_santri = mysqli_fetch_array($hasil_santri)) :
                                    $no++;

                                    // Query untuk mendapatkan surah terakhir yang diinput oleh santri
                                    $sql_last_surah = "SELECT s.nama_surat 
                                                       FROM tbl_hafalan h 
                                                       JOIN tbl_surat s ON h.id_surat = s.id_surat 
                                                       WHERE h.id_santri = ? 
                                                       ORDER BY h.tgl_hafalan DESC LIMIT 1";
                                    $stmt_surah = mysqli_prepare($kon, $sql_last_surah);
                                    mysqli_stmt_bind_param($stmt_surah, "i", $data_santri['id_santri']);
                                    mysqli_stmt_execute($stmt_surah);
                                    $hasil_surah = mysqli_stmt_get_result($stmt_surah);
                                    $data_surah = mysqli_fetch_assoc($hasil_surah);
                                   // $surah_terakhir = $data_surah ? htmlspecialchars($data_surah['nama_surat']) : "-";
                                    ?>
                                    <tr class="text-center">
                                        <td><?php echo $no; ?></td>
                                        <td class="text-left"><?php echo htmlspecialchars($data_santri['nama_santri']); ?></td>
                                        
                                        <td>
                                            <a href="index.php?page=riwayat_hafalan_santri&id_santri=<?php echo urlencode($data_santri['id_santri']); ?>" 
                                               class="btn btn-success btn-circle btn-sm">
                                                <i class="fas fa-book-open"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endwhile;
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div><!--/.row-->
