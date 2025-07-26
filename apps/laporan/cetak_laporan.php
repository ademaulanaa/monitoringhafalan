<?php
session_start();
if ($_SESSION["level"] != 'Admin' && $_SESSION["level"] != 'admin') {
    echo "<br><div class='alert alert-danger'>Tidak Memiliki Hak Akses</div>";
    exit;
}

require('../../config/database.php');

// Get filter parameters
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
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Hafalan Santri</title>
    <link rel="stylesheet" href="../../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../assets/css/font-awesome.min.css">
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
            text-align: left;
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
                <p>Pondok Pesantren Nurul Quran</p>
            </div>
            <div class="card-body">
                <div class="text-right mb-3 no-print">
                    <button onclick="downloadPDF()" class="btn btn-primary">
                        <i class="fa fa-download"></i> Download PDF
                    </button>
                </div>

                <!-- Filter Information -->
                <div class="section">
                    <div class="section-title">INFORMASI FILTER</div>
                    <?php if($id_kelas): 
                        $kelas_query = mysqli_query($kon, "SELECT nama_kelas FROM tbl_kelas WHERE id_kelas = $id_kelas");
                        $kelas_data = mysqli_fetch_assoc($kelas_query);
                    ?>
                    <div class="info-item">
                        <span class="info-label">Kelas:</span>
                        <span><?php echo htmlspecialchars($kelas_data['nama_kelas']); ?></span>
                    </div>
                    <?php endif; ?>
                    <div class="info-item">
                        <span class="info-label">Periode:</span>
                        <span><?php 
                            if($start_date == '1970-01-01' && $end_date == date('Y-m-d')) {
                                echo "Semua Data";
                            } else {
                                echo date('d/m/Y', strtotime($start_date)) . ' - ' . date('d/m/Y', strtotime($end_date));
                            }
                        ?></span>
                    </div>
                </div>

                <!-- Data Santri -->
                <div class="section">
                    <div class="section-title">DATA SANTRI</div>
                    <div class="table-responsive">
                        <table>
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
                                    echo '<td>' . ($data_santri['jumlah_juz'] ? htmlspecialchars($data_santri['jumlah_juz']) : '-') . '</td>';
                                    echo '<td>' . ($data_santri['tasmi_terakhir'] ? htmlspecialchars($data_santri['tasmi_terakhir']) : '-') . '</td>';
                                    echo '<td>' . ($data_santri['hafalan_terakhir'] ? htmlspecialchars($data_santri['hafalan_terakhir']) : '-') . '</td>';
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
                filename: 'Laporan_Hafalan_Santri_<?php echo date('Y-m-d'); ?>.pdf',
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