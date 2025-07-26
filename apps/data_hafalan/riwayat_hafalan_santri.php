<?php
include 'config/database.php';

// Ambil ID santri dari URL
$id_santri = isset($_GET['id_santri']) ? intval($_GET['id_santri']) : null;

if (!$id_santri) {
    echo "<div class='alert alert-danger'>Santri tidak ditemukan.</div>";
    exit;
}

// Filter tanggal
$start_date = isset($_GET['start_date']) ? $_GET['start_date'] : '';
$end_date = isset($_GET['end_date']) ? $_GET['end_date'] : date('Y-m-d');

// Ambil data santri
$sql_santri = "SELECT s.*, k.nama_kelas 
               FROM tbl_santri s 
               LEFT JOIN tbl_kelas k ON s.id_kelas = k.id_kelas 
               WHERE s.id_santri = ?";
$stmt = mysqli_prepare($kon, $sql_santri);
mysqli_stmt_bind_param($stmt, "i", $id_santri);
mysqli_stmt_execute($stmt);
$hasil_santri = mysqli_stmt_get_result($stmt);
$data_santri = mysqli_fetch_assoc($hasil_santri);

if (!$data_santri) {
    echo "<div class='alert alert-danger'>Santri tidak ditemukan.</div>";
    exit;
}

// Tangani update jumlah juz
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['jumlah_juz'])) {
    $jumlah_juz = mysqli_real_escape_string($kon, $_POST['jumlah_juz']);
    $keterangan = mysqli_real_escape_string($kon, $_POST['keterangan']);

    $sql_cek = "SELECT * FROM tbl_jumlah_juz WHERE id_santri = ?";
    $stmt = mysqli_prepare($kon, $sql_cek);
    mysqli_stmt_bind_param($stmt, "i", $id_santri);
    mysqli_stmt_execute($stmt);
    $res_cek = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($res_cek) > 0) {
        $sql_update = "UPDATE tbl_jumlah_juz SET jumlah_juz = ?, keterangan = ? WHERE id_santri = ?";
        $stmt = mysqli_prepare($kon, $sql_update);
        mysqli_stmt_bind_param($stmt, "ssi", $jumlah_juz, $keterangan, $id_santri);
        mysqli_stmt_execute($stmt);
    } else {
        $sql_insert = "INSERT INTO tbl_jumlah_juz (id_santri, jumlah_juz, keterangan) VALUES (?, ?, ?)";
        $stmt = mysqli_prepare($kon, $sql_insert);
        mysqli_stmt_bind_param($stmt, "iss", $id_santri, $jumlah_juz, $keterangan);
        mysqli_stmt_execute($stmt);
    }

    
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['tambah_tasmi'])) {
    $tanggal = mysqli_real_escape_string($kon, $_POST['tanggal']);
    $tambah_juz = mysqli_real_escape_string($kon, $_POST['tambah_juz']);
    $khofi = mysqli_real_escape_string($kon, $_POST['khofi']);
    $jali = mysqli_real_escape_string($kon, $_POST['jali']);
    $keterangan = mysqli_real_escape_string($kon, $_POST['keterangan']);

    $sql_insert = "INSERT INTO tbl_tasmi (id_santri, tanggal, tambah_juz, khofi, jali, keterangan) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($kon, $sql_insert);
    mysqli_stmt_bind_param($stmt, "isssss", $id_santri, $tanggal, $tambah_juz, $khofi, $jali, $keterangan);
    mysqli_stmt_execute($stmt);

    echo "<div class='alert alert-success'>Riwayat tasmi berhasil ditambahkan.</div>";
}

// Update Data Tasmi
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_tasmi'])) {
    $id_tasmi = intval($_POST['id_tasmi']);
    $tanggal = mysqli_real_escape_string($kon, $_POST['tanggal']);
    $tambah_juz = mysqli_real_escape_string($kon, $_POST['tambah_juz']);
    $khofi = mysqli_real_escape_string($kon, $_POST['khofi']);
    $jali = mysqli_real_escape_string($kon, $_POST['jali']);
    $keterangan = mysqli_real_escape_string($kon, $_POST['keterangan']);

    $sql_update = "UPDATE tbl_tasmi SET tanggal=?, tambah_juz=?, khofi=?, jali=?, keterangan=? WHERE id_tasmi=?";
    $stmt = mysqli_prepare($kon, $sql_update);
    mysqli_stmt_bind_param($stmt, "sssssi", $tanggal, $tambah_juz, $khofi, $jali, $keterangan, $id_tasmi);
    mysqli_stmt_execute($stmt);
    echo "<div class='alert alert-info'>Riwayat tasmi berhasil diperbarui.</div>";
}

// Hapus Data Tasmi
if (isset($_GET['hapus_tasmi'])) {
    $id_tasmi = intval($_GET['hapus_tasmi']);
    $sql_delete = "DELETE FROM tbl_tasmi WHERE id_tasmi=?";
    $stmt = mysqli_prepare($kon, $sql_delete);
    mysqli_stmt_bind_param($stmt, "i", $id_tasmi);
    mysqli_stmt_execute($stmt);
    echo "<div class='alert alert-danger'>Riwayat tasmi berhasil dihapus.</div>";
}


?>

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

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="mb-0">Monitoring Hafalan - <?php echo htmlspecialchars($data_santri['nama_santri']); ?></h4>
            </div>
            <div class="panel-body">
                <div class="form-group">
                    <a href="index.php?page=hafalan_santri&id_kelas=<?php echo $data_santri['id_kelas']; ?>" class="btn btn-primary">
                        <i class="fa fa-arrow-left"></i> Kembali
                    </a>
                </div>
                <?php
                if (isset($_GET['add'])) {
                    if ($_GET['add']=='berhasil'){
                        echo"<div class='alert alert-success'><strong>Berhasil!</strong> Data Telah Disimpan</div>";
                    }else if ($_GET['add']=='gagal'){
                        echo"<div class='alert alert-danger'><strong>Gagal!</strong> Data Gagal Disimpan</div>";
                    }    
                }

                if (isset($_GET['edit'])) {
                    if ($_GET['edit']=='berhasil'){
                        echo"<div class='alert alert-success'><strong>Berhasil!</strong> Data Telah Diupdate</div>";
                    }else if ($_GET['edit']=='gagal'){
                        echo"<div class='alert alert-danger'><strong>Gagal!</strong> Data Gagal Diupdate</div>";
                    }    
                }


                if (isset($_GET['hapus'])) {
                    if ($_GET['hapus']=='berhasil'){
                        echo"<div class='alert alert-success'><strong>Berhasil!</strong> Data Telah Dihapus</div>";
                    }else if ($_GET['hapus']=='gagal'){
                        echo"<div class='alert alert-danger'><strong>Gagal!</strong> Data Gagal Dihapus</div>";
                    }    
                }
                ?>

                <!-- Form Filter Tanggal -->
                <div class="filter-form">
                    <form method="GET" class="form-inline">
                        <input type="hidden" name="page" value="riwayat_hafalan_santri">
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
                        <a href="apps/data_hafalan/cetak_laporan.php?id_santri=<?php echo $id_santri; ?>&start_date=<?php echo $start_date; ?>&end_date=<?php echo $end_date; ?>" 
                           class="btn btn-success" target="_blank">
                            <i class="fa fa-file-pdf-o"></i> Cetak PDF
                        </a>
                    </form>
                </div>

                <!-- Tabel Jumlah Juz -->
                <div class="section-title">JUMLAH JUZ HAFALAN</div>
<form method="POST">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
            <tr>
                <th>Jumlah Juz</th>
                <th>Keterangan</th>
                <th class="text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql_juz = "SELECT * FROM tbl_jumlah_juz WHERE id_santri = ?";
            $stmt = mysqli_prepare($kon, $sql_juz);
            mysqli_stmt_bind_param($stmt, "i", $id_santri);
            mysqli_stmt_execute($stmt);
            $res_juz = mysqli_stmt_get_result($stmt);
            $data_juz = mysqli_fetch_assoc($res_juz);
            ?>
            <tr>
                <td>
                    <input type="text" name="jumlah_juz" class="form-control" placeholder="Contoh: 5 " value="<?php echo isset($data_juz['jumlah_juz']) ? $data_juz['jumlah_juz'] : ''; ?>" required>
                </td>
                <td>
                    <input type="text" name="keterangan" class="form-control" placeholder="Contoh: Juz 1 - 5" value="<?php echo isset($data_juz['keterangan']) ? $data_juz['keterangan'] : ''; ?>">
                </td>
                <td class="text-center">
                                        <button type="submit" class="btn btn-warning btn-sm">
                                            <i class="fa fa-save"></i> Update
                                        </button>
                </td>
            </tr>
        </tbody>
    </table>
                    </div>
</form>

<!-- Form Tambah Riwayat Tasmi -->
                <div class="section-title">RIWAYAT TASMI</div>
<div class="form-group">
    <button type="button" class="btn btn-success" id="tombol_tambah_tasmi">
        <i class="fa fa-plus"></i> Tambah Tasmi
    </button>
</div>

<!-- Tabel Riwayat Tasmi -->
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
                <th style="width: 13%">Keterangan</th>
                <th style="width: 10%">Aksi</th>
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
                    <td class="text-center text-nowrap">
                        <button id_tasmi="<?php echo $data_tasmi['id_tasmi']; ?>" class="tombol_edit_tasmi btn btn-warning btn-circle btn-sm">
                            <i class="fa fa-edit"></i>
                        </button>
                        <a href="apps/data_hafalan/hapus_tasmi.php?id_tasmi=<?php echo $data_tasmi['id_tasmi']; ?>" class="btn-hapus-tasmi btn btn-danger btn-circle btn-sm">
                            <i class="fa fa-trash"></i>
                        </a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

                <!-- Tabel Riwayat Hafalan -->
                <div class="section-title">RIWAYAT HAFALAN</div>
                <div class="form-group">
                <button type="button" class="btn btn-success" id="tombol_tambah">
                        <i class="fa fa-plus"></i> Tambah Hafalan
                    </button>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" id="dataTable">
                        <thead>
                            <tr>
                                <th style="width: 5%">No</th>
                                <th style="width: 15%">Tanggal Hafalan</th>
                                <th style="width: 15%">Surat</th>
                                <th style="width: 15%">Ayat</th>
                                <th style="width: 10%">Juz</th>
                                <th style="width: 10%">Status</th>
                                <th style="width: 20%">Keterangan</th>
                                <th style="width: 10%">Aksi</th>
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
                                    <td class="text-center"><?php echo $no; ?></td>
                                    <td class="text-center"><?php echo date('d-m-Y', strtotime($data_hafalan['tgl_hafalan'])); ?></td>
                                    <td class="text-center"><?php echo htmlspecialchars($data_hafalan['nama_surat']); ?></td>
                                    <td class="text-center"><?php echo htmlspecialchars($data_hafalan['ayat']); ?></td>
                                    <td class="text-center"><?php echo htmlspecialchars($data_hafalan['juz']); ?></td>
                                    <td class="text-center"><?php echo htmlspecialchars($data_hafalan['status']); ?></td>
                                    <td class="text-center"><?php echo htmlspecialchars($data_hafalan['keterangan']); ?></td>
                                    <td class="text-center text-nowrap">
                                        <button id_hafalan="<?php echo $data_hafalan['id_hafalan']; ?>" class="tombol_edit btn btn-warning btn-circle btn-sm">
                                            <i class="fa fa-edit"></i>
                                        </button>
                                        <a href="apps/data_hafalan/hapus.php?id_hafalan=<?php echo $data_hafalan['id_hafalan']; ?>" class="btn-hapus-hafalan btn btn-danger btn-circle btn-sm">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="judul"></h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div id="tampil_data"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
            </div>
        </div>
    </div>
</div>

<script>
    // Tambahkan fungsi downloadPDF
    function downloadPDF() {
        const element = document.querySelector('.panel');
        const opt = {
            margin: [8, 8, 8, 8],
            filename: 'Laporan_Hafalan_<?php echo $data_santri['nama_santri']; ?>_<?php echo date('Y-m-d'); ?>.pdf',
            image: { type: 'jpeg', quality: 0.98 },
            html2canvas: { 
                scale: 2,
                useCORS: true,
                logging: false,
                backgroundColor: '#ffffff'
            },
            jsPDF: { 
                unit: 'mm', 
                format: 'a4', 
                orientation: 'portrait',
                compress: true
            }
        };

        // Konversi warna ke hitam putih sebelum download
        const style = document.createElement('style');
        style.innerHTML = `
            * {
                color: black !important;
                background-color: white !important;
            }
            .panel {
                border: none !important;
                box-shadow: none !important;
                margin: 0 !important;
                padding: 0 !important;
            }
            .panel-heading {
                background-color: white !important;
                color: black !important;
                border-bottom: 2px solid black !important;
            }
            .section-title {
                color: black !important;
                border-bottom: 2px solid black !important;
            }
            table, th, td {
                border: 1px solid black !important;
            }
            th {
                background-color: #f0f0f0 !important;
            }
            tr:nth-child(even) {
                background-color: #f8f8f8 !important;
            }
            .btn-action, .btn, .form-group, .filter-form {
                display: none !important;
            }
        `;
        document.head.appendChild(style);

        // Buat elemen baru tanpa tombol aksi
        const newElement = element.cloneNode(true);
        const elementsToRemove = newElement.querySelectorAll('.btn-action, .btn, .form-group, .filter-form');
        elementsToRemove.forEach(el => el.remove());

        html2pdf().set(opt).from(newElement).save().then(() => {
            document.head.removeChild(style);
        });
    }

    $('#tombol_tambah').on('click', function () {
        $.ajax({
            url: 'apps/data_hafalan/tambah.php',
            method: 'post',
            data: { id_santri: <?php echo $id_santri; ?> },
            success: function (data) {
                $('#tampil_data').html(data);
                document.getElementById("judul").innerHTML = 'Tambah Hafalan';
                $('#modal').modal('show');
            }
        });
    });

    $('.tombol_edit').on('click', function () {
        var id_hafalan = $(this).attr("id_hafalan");
        $.ajax({
            url: 'apps/data_hafalan/edit.php',
            method: 'post',
            data: { id_hafalan: id_hafalan },
            success: function (data) {
                $('#tampil_data').html(data);
                document.getElementById("judul").innerHTML = 'Edit Hafalan';
                $('#modal').modal('show');
            }
        });
    });

    $('.btn-hapus-hafalan').on('click', function () {
        return confirm("Konfirmasi sebelum menghapus hafalan?");
    });

    $('#tombol_tambah_tasmi').on('click', function () {
        $.ajax({
            url: 'apps/data_hafalan/tambah_tasmi.php',
            method: 'post',
            data: { id_santri: <?php echo $id_santri; ?> },
            success: function (data) {
                $('#tampil_data').html(data);
                document.getElementById("judul").innerHTML = 'Tambah Tasmi';
                $('#modal').modal('show');
            }
        });
    });

    $('.tombol_edit_tasmi').on('click', function () {
        var id_tasmi = $(this).attr("id_tasmi");
        $.ajax({
            url: 'apps/data_hafalan/edit_tasmi.php',
            method: 'post',
            data: { id_tasmi: id_tasmi },
            success: function (data) {
                $('#tampil_data').html(data);
                document.getElementById("judul").innerHTML = 'Edit Tasmi';
                $('#modal').modal('show');
            }
        });
    });

    $('.btn-hapus-tasmi').on('click', function () {
        return confirm("Konfirmasi sebelum menghapus data tasmi?");
    });
</script>
