<?php
// Ambil ID santri dari URL (jika diperlukan)
$id_santri = isset($_GET['id_santri']) ? intval($_GET['id_santri']) : null;

// Cek session dan level user
if (!isset($_SESSION['level'])) {
    echo "<h3 class='text-center'>Anda belum login. Silakan login terlebih dahulu.</h3>";
    exit();
}

$level = strtolower($_SESSION['level']); // Konversi ke huruf kecil agar konsisten
include "config/database.php"; // Hubungkan dengan database

// Query untuk mengambil data jumlah siswa per kelas
$kelasLabels = [];
$jumlahSiswaPerKelas = [];

$query = "SELECT k.nama_kelas, COUNT(s.id_santri) AS jumlah_siswa 
          FROM tbl_kelas k 
          LEFT JOIN tbl_santri s ON k.id_kelas = s.id_kelas 
          GROUP BY k.id_kelas";
$result = mysqli_query($kon, $query);

if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $kelasLabels[] = $row['nama_kelas'];
        $jumlahSiswaPerKelas[] = $row['jumlah_siswa'];
    }
} else {
    $kelasLabels = ["Tidak Ada Data"];
    $jumlahSiswaPerKelas = [0];
}

// Ubah ke format JSON agar bisa digunakan di JavaScript
$kelasLabelsJSON = json_encode($kelasLabels);
$jumlahSiswaJSON = json_encode($jumlahSiswaPerKelas);

// Query untuk mengambil data santri dengan hafalan terbanyak (status Lanjut)
$queryHafalanTerbanyak = "
    SELECT s.nama_santri, COUNT(DISTINCT h.juz) AS jumlah_hafalan 
    FROM tbl_hafalan h 
    JOIN tbl_santri s ON h.id_santri = s.id_santri 
    WHERE h.status = 'Lanjut' 
    GROUP BY s.id_santri 
    ORDER BY jumlah_hafalan DESC 
    LIMIT 5"; // Ambil 5 santri teratas
$resultHafalanTerbanyak = mysqli_query($kon, $queryHafalanTerbanyak);

$santriLabels = [];
$jumlahHafalan = [];

if ($resultHafalanTerbanyak && mysqli_num_rows($resultHafalanTerbanyak) > 0) {
    while ($row = mysqli_fetch_assoc($resultHafalanTerbanyak)) {
        $santriLabels[] = $row['nama_santri'];
        $jumlahHafalan[] = $row['jumlah_hafalan'];
    }
} else {
    $santriLabels = ["Tidak Ada Data"];
    $jumlahHafalan = [0];
}

// Ubah ke format JSON untuk digunakan di JavaScript
$santriLabelsJSON = json_encode($santriLabels);
$jumlahHafalanJSON = json_encode($jumlahHafalan);

// Query jumlah data untuk admin
if ($level == 'admin') {
    $jumlahGuru = mysqli_fetch_array(mysqli_query($kon, "SELECT COUNT(*) AS total FROM tbl_guru"))['total'];
    $jumlahSiswa = mysqli_fetch_array(mysqli_query($kon, "SELECT COUNT(*) AS total FROM tbl_santri"))['total'];
    $jumlahPengguna = mysqli_fetch_array(mysqli_query($kon, "SELECT COUNT(*) AS total FROM tbl_user"))['total'];
    $jumlahSurat = mysqli_fetch_array(mysqli_query($kon, "SELECT COUNT(*) AS total FROM tbl_surat"))['total'];
    $jumlahAdmin = mysqli_fetch_array(mysqli_query($kon, "SELECT COUNT(*) AS total FROM tbl_user WHERE level = 'admin'"))['total'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
</head>
<body>

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading"><strong>Dashboard</strong></div>
                <div class="panel-body">
                    <?php
                    // Tampilkan pesan selamat datang berdasarkan level
                    switch ($level) {
                        case 'admin':
                            ?>
                            <div class="row">
                                <!-- Kotak 1: Guru Terdaftar -->
                                <div class="col-lg-3 col-md-3 mb-3">
                                    <div class="panel d-flex flex-column align-items-center p-3 text-center"
                                    style="border: 3px solidrgb(255, 255, 255); background-color:rgba(80, 85, 90, 0.1); border-radius: 0px; box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1);">
                                    <i class="fa fa-user fa-3x text-primary mb-2"></i>
                                    <div class="text-dark font-weight-bold">Guru Terdaftar</div>
                                    <h2 class="mb-0 mt-1"><?php echo $jumlahGuru; ?></h2>
                                </div>
                            </div>

                            <!-- Kotak 2: Siswa Terdaftar -->
                            <div class="col-lg-3 col-md-3 mb-3">
                                <div class="panel d-flex flex-column align-items-center p-3 text-center"
                                style="border: 3px solidrgb(249, 252, 250); background-color:rgba(0, 128, 255, 0.1); border-radius: 0px; box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1);">
                                <i class="fa fa-users fa-3x text-success mb-2"></i>
                                <div class="text-dark font-weight-bold">Santri Terdaftar</div>
                                <h2 class="mb-0 mt-1"><?php echo $jumlahSiswa; ?></h2>
                            </div>
                        </div>

                        <!-- Kotak 3: Total Admin -->
                    <div class="col-lg-3 col-md-3 mb-3">
                        <div class="panel d-flex flex-column align-items-center p-3 text-center"
                        style="border: 3px solidrgb(255, 255, 255); background-color:rgba(80, 85, 90, 0.1); border-radius: 0px; box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1);">
                        <i class="fa fa-user-shield fa-3x text-danger mb-2"></i>
                        <div class="text-dark font-weight-bold">Total Admin</div>
                        <h2 class="mb-0 mt-1"><?php echo $jumlahAdmin; ?></h2>
                    </div>
                </div>

                        <!-- Kotak 4: Total Pengguna -->
                        <div class="col-lg-3 col-md-3 mb-3">
                            <div class="panel d-flex flex-column align-items-center p-3 text-center"
                            style="border: 3px solidrgb(255, 255, 255); background-color:rgba(80, 85, 90, 0.1); border-radius: 0px; box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1);">
                            <i class="fa fa-user-circle fa-3x text-warning mb-2"></i>
                            <div class="text-dark font-weight-bold">Total Pengguna</div>
                            <h2 class="mb-0 mt-1"><?php echo $jumlahPengguna; ?></h2>
                        </div>
                    </div>
            </div>

            <!-- Diagram Jumlah Santri dan Guru -->
            <div class="row">
                <div class="col-lg-6">
                    <div class="panel" style="border: 2px solidrgb(248, 249, 250); border-radius: 0px; box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1);">
                        <div class="panel-heading text-white" style="background:rgb(201, 85, 96); font-weight: bold;">Jumlah Santri</div>
                        <div class="panel-body" style="height: 250px;">
                            <canvas id="barChart" style="width: 100%; height: 100%;"></canvas>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="panel" style="border: 2px solidrgb(252, 255, 252); border-radius: 0px; box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1);">
                        <div class="panel-heading text-white" style="background:rgb(201, 85, 96); font-weight: bold;">Jumlah Guru & Santri</div>
                        <div class="panel-body" style="height: 250px;">
                            <canvas id="pieChart" style="width: 100%; height: 100%;"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!--Diagram Hafalan Terbanyak -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel" style="border: 2px solidrgb(252, 249, 250); border-radius: 0px; box-shadow: 2px 2px 10px rgba(160, 141, 141, 0.1);">
                        <div class="panel-heading text-white" style="background:rgb(201, 85, 96); font-weight: bold;">Santri dengan Hafalan Terbanyak</div>
                        <div class="panel-body" style="height: 300px;">
                            <canvas id="hafalanTerbanyakChart" style="width: 100%; height: 100%;"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <?php
            break;

            case 'guru':
            echo "<h3>Selamat Datang, <strong>{$_SESSION['nama_guru']}</strong>.</h3>";
            break;

            case 'santri':
            echo "<h3>Selamat Datang Wali Santri, <strong>{$_SESSION['nama_santri']}</strong>.</h3>";
            break;
        }
        ?>
    </div>
</div>
</div>
</div>

<!-- Tambahkan Script untuk Diagram -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Data untuk diagram jumlah santri per kelas
    const kelasLabels = <?php echo $kelasLabelsJSON; ?>;
    const jumlahSiswaPerKelas = <?php echo $jumlahSiswaJSON; ?>;

    // Buat diagram batang dengan Chart.js
    const barChart = new Chart(document.getElementById('barChart'), {
    type: 'bar',
    data: {
        labels: kelasLabels,
        datasets: [{
            label: 'Jumlah Santri',
            data: jumlahSiswaPerKelas,
            backgroundColor: 'rgba(40, 167, 69, 0.5)',
            borderColor: 'rgba(40, 167, 69, 1)',
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    stepSize: 1, // Set increment ke 1
                    precision: 0 // Hilangkan desimal
                }
            }
        }
    }
});

    // Diagram Lingkaran
    const pieChart = new Chart(document.getElementById('pieChart'), {
        type: 'pie',
        data: {
            labels: ['Guru', 'Santri'],
            datasets: [{
                label: 'Persentase',
                data: [<?php echo $jumlahGuru; ?>, <?php echo $jumlahSiswa; ?>],
                backgroundColor: [
                'rgba(0, 123, 255, 0.5)',
                'rgba(40, 167, 69, 0.5)',
                'rgba(255, 193, 7, 0.5)'
                ],
                borderColor: [
                'rgba(0, 123, 255, 1)',
                'rgba(40, 167, 69, 1)',
                'rgba(255, 193, 7, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top',
                },
                tooltip: {
                    enabled: true
                }
            }
        }
    });

    // Data untuk diagram hafalan terbanyak
    const santriLabels = <?php echo $santriLabelsJSON; ?>;
    const jumlahHafalan = <?php echo $jumlahHafalanJSON; ?>;

    // Buat diagram batang untuk hafalan terbanyak
    const hafalanTerbanyakChart = new Chart(document.getElementById('hafalanTerbanyakChart'), {
    type: 'bar',
    data: {
        labels: santriLabels,
        datasets: [{
            label: 'Jumlah Hafalan',
            data: jumlahHafalan,
            backgroundColor: 'rgba(211, 86, 98, 0.5)',
            borderColor: 'rgb(199, 71, 84)',
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    stepSize: 1, // Set increment ke 1
                    precision: 0 // Hilangkan desimal
                },
                title: {
                    display: true,
                    text: 'Jumlah Hafalan'
                }
            },
            x: {
                title: {
                    display: true,
                    text: 'Nama Santri'
                }
            }
        },
        plugins: {
            legend: {
                display: true,
                position: 'top',
            },
            tooltip: {
                enabled: true
            }
        }
    }
});
</script>
</body>
</html>