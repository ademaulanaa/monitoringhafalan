<?php
require('../../config/database.php');

// Ambil ID santri dan tanggal dari URL
$id_santri = isset($_GET['id_santri']) ? intval($_GET['id_santri']) : null;
$start_date = isset($_GET['start_date']) ? $_GET['start_date'] : '';
$end_date = isset($_GET['end_date']) ? $_GET['end_date'] : date('Y-m-d');

if (!$id_santri) {
    die("ID Santri tidak ditemukan");
}

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
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Hafalan - <?php echo htmlspecialchars($data_santri['nama_santri']); ?></title>
    <link rel="stylesheet" href="../../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../assets/css/font-awesome.min.css">
    <link rel="stylesheet" href="../../template/css/laporan.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <style>
        @page {
            size: A4;
            margin: 8mm;
        }
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            font-size: 12px;
            background-color: #ffffff;
        }
        .container {
            max-width: 210mm;
            margin: 0 auto;
            padding: 0;
        }
        .card {
            border: none;
            box-shadow: none;
            margin: 0;
            padding: 0;
            background: white;
        }
        .card-header {
            background-color: #ffffff;
            color: #000000;
            padding: 10px 0;
            border-bottom: 2px solid #000000;
            text-align: center;
        }
        .card-header h4 {
            margin: 0;
            font-size: 16px;
            font-weight: bold;
        }
        .card-body {
            padding: 10px 0;
            background-color: white;
        }
        .section {
            margin-bottom: 15px;
            background-color: white;
            padding: 10px 0;
        }
        .section-title {
            font-weight: bold;
            margin-bottom: 10px;
            padding-bottom: 5px;
            border-bottom: 1px solid #000000;
            color: #000000;
            font-size: 14px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
            background-color: white;
        }
        th, td {
            border: 1px solid #000000;
            padding: 5px;
            text-align: center;
            font-size: 11px;
        }
        th {
            background-color: #f0f0f0;
            font-weight: bold;
            color: #000000;
        }
        tr:nth-child(even) {
            background-color: #f8f8f8;
        }
        .info-item {
            margin-bottom: 5px;
            padding: 3px 0;
            border-bottom: 1px solid #dddddd;
        }
        .info-label {
            font-weight: bold;
            display: inline-block;
            width: 120px;
            color: #000000;
        }
        .no-print {
            display: none !important;
        }
        .text-right {
            text-align: right;
        }
        .mb-3 {
            margin-bottom: 1rem;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h4>Laporan Hafalan Santri</h4>
            </div>
            <div class="card-body">
                <div class="text-right mb-3 no-print">
                    <button onclick="downloadPDF()" class="btn-action btn-download">
                        <i class="fa fa-download"></i> Download PDF
                    </button>
                </div>

                <!-- Data Santri -->
                <div class="section">
                    <div class="section-title">DATA SANTRI</div>
                    <div class="info-item">
                        <span class="info-label">Nama Santri:</span>
                        <span><?php echo htmlspecialchars($data_santri['nama_santri']); ?></span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">NIS:</span>
                        <span><?php echo htmlspecialchars($data_santri['nis']); ?></span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Kelas:</span>
                        <span><?php echo htmlspecialchars($data_santri['nama_kelas']); ?></span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Periode:</span>
                        <span><?php echo $start_date ? date('d-m-Y', strtotime($start_date)) . ' s/d ' . date('d-m-Y', strtotime($end_date)) : 'Semua Data'; ?></span>
                    </div>
                </div>

                <!-- Jumlah Juz -->
                <div class="section">
                    <div class="section-title">JUMLAH JUZ HAFALAN</div>
                    <?php
                    $sql_juz = "SELECT * FROM tbl_jumlah_juz WHERE id_santri = ?";
                    $stmt = mysqli_prepare($kon, $sql_juz);
                    mysqli_stmt_bind_param($stmt, "i", $id_santri);
                    mysqli_stmt_execute($stmt);
                    $hasil_juz = mysqli_stmt_get_result($stmt);
                    $data_juz = mysqli_fetch_assoc($hasil_juz);

                    if ($data_juz) {
                        echo '<div class="info-item">';
                        echo '<span class="info-label">Jumlah Juz:</span>';
                        echo '<span>' . htmlspecialchars($data_juz['jumlah_juz']) . '</span>';
                        echo '</div>';
                        echo '<div class="info-item">';
                        echo '<span class="info-label">Keterangan:</span>';
                        echo '<span>' . htmlspecialchars($data_juz['keterangan']) . '</span>';
                        echo '</div>';
                    } else {
                        echo '<p class="text-muted">Belum ada data jumlah juz</p>';
                    }
                    ?>
                </div>

                <!-- Riwayat Tasmi -->
                <div class="section">
                    <div class="section-title">RIWAYAT TASMI</div>
                    <div class="table-responsive">
                        <table>
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Tanggal</th>
                                    <th>Tambah Juz</th>
                                    <th>Juz Tasmi</th>
                                    <th>Khofi</th>
                                    <th>Jali</th>
                                    <th>Status</th>
                                    <th>Penyimak</th>
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
                                }

                                $sql_tasmi .= " ORDER BY tanggal DESC";
                                
                                $stmt = mysqli_prepare($kon, $sql_tasmi);
                                mysqli_stmt_bind_param($stmt, $types, ...$params);
                                mysqli_stmt_execute($stmt);
                                $hasil_tasmi = mysqli_stmt_get_result($stmt);

                                $no = 1;
                                while ($data_tasmi = mysqli_fetch_assoc($hasil_tasmi)) {
                                    echo '<tr>';
                                    echo '<td>' . $no++ . '</td>';
                                    echo '<td>' . date('d-m-Y', strtotime($data_tasmi['tanggal'])) . '</td>';
                                    echo '<td>' . htmlspecialchars($data_tasmi['tambah_juz']) . '</td>';
                                    echo '<td>' . htmlspecialchars($data_tasmi['juz_tasmi']) . '</td>';
                                    echo '<td>' . htmlspecialchars($data_tasmi['khofi']) . '</td>';
                                    echo '<td>' . htmlspecialchars($data_tasmi['jali']) . '</td>';
                                    echo '<td>' . htmlspecialchars($data_tasmi['status']) . '</td>';
                                    echo '<td>' . htmlspecialchars($data_tasmi['penyimak']) . '</td>';
                                    echo '<td>' . htmlspecialchars($data_tasmi['keterangan']) . '</td>';
                                    echo '</tr>';
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Riwayat Hafalan -->
                <div class="section">
                    <div class="section-title">RIWAYAT HAFALAN</div>
                    <div class="table-responsive">
                        <table>
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Tanggal</th>
                                    <th>Surat</th>
                                    <th>Ayat</th>
                                    <th>Juz</th>
                                    <th>Status</th>
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
                                }

                                $sql_hafalan .= " ORDER BY h.tgl_hafalan DESC";
                                
                                $stmt = mysqli_prepare($kon, $sql_hafalan);
                                mysqli_stmt_bind_param($stmt, $types, ...$params);
                                mysqli_stmt_execute($stmt);
                                $hasil_hafalan = mysqli_stmt_get_result($stmt);

                                $no = 1;
                                while ($data_hafalan = mysqli_fetch_assoc($hasil_hafalan)) {
                                    echo '<tr>';
                                    echo '<td>' . $no++ . '</td>';
                                    echo '<td>' . date('d-m-Y', strtotime($data_hafalan['tgl_hafalan'])) . '</td>';
                                    echo '<td>' . htmlspecialchars($data_hafalan['nama_surat']) . '</td>';
                                    echo '<td>' . htmlspecialchars($data_hafalan['ayat']) . '</td>';
                                    echo '<td>' . htmlspecialchars($data_hafalan['juz']) . '</td>';
                                    echo '<td>' . htmlspecialchars($data_hafalan['status']) . '</td>';
                                    echo '<td>' . htmlspecialchars($data_hafalan['keterangan']) . '</td>';
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

    <script src="../../assets/js/jquery.min.js"></script>
    <script src="../../assets/js/bootstrap.min.js"></script>
    <script>
        function downloadPDF() {
            const element = document.querySelector('.card');
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

            html2pdf().set(opt).from(element).save();
        }

        // Download PDF otomatis saat halaman dimuat
        window.onload = function() {
            downloadPDF();
        };
    </script>
</body>
</html>