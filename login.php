<?php
// Memulai session
session_start();

// Jika terdeteksi ada variabel id_pengguna dalam session, maka langsung arahkan ke halaman dashboard
if (isset($_SESSION["id_pengguna"])) {
    session_unset();
    session_destroy();
}

// Variabel pesan untuk menampilkan validasi login
$pesan = "";

// Fungsi untuk mencegah inputan karakter yang tidak sesuai
function input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Cek apakah ada kiriman form dari method POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Menghubungkan database
    include "config/database.php";

    // Mengambil input username dan password dari form login
    $username = input($_POST["username"]);
    $password = input(md5($_POST["password"])); // Hash yang dipakai MD5

    // Query untuk cek tbl_user yang di-join dengan tbl_admin
    $tabel_admin = "SELECT * FROM tbl_user p
    INNER JOIN tbl_admin k ON k.kode_admin = p.kode_pengguna
    WHERE username = '" . $username . "' AND password = '" . $password . "' LIMIT 1";
    $cek_tabel_admin = mysqli_query($kon, $tabel_admin);
    $admin = mysqli_num_rows($cek_tabel_admin);

    // Query untuk cek tbl_user yang di-join dengan tbl_mahasiswa
    $tabel_mahasiswa = "SELECT * FROM tbl_user p
    INNER JOIN tbl_santri m ON m.kode_santri = p.kode_pengguna
    WHERE username = '" . $username . "' AND password = '" . $password . "' LIMIT 1";
    $cek_tabel_santri = mysqli_query($kon, $tabel_mahasiswa);
    $mahasiswa = mysqli_num_rows($cek_tabel_santri);

    // Query untuk cek tbl_user yang di-join dengan tbl_guru
    $tabel_guru = "SELECT * FROM tbl_user p
    INNER JOIN tbl_guru g ON g.kode_guru = p.kode_pengguna
    WHERE username = '" . $username . "' AND password = '" . $password . "' LIMIT 1";
    $cek_tabel_guru = mysqli_query($kon, $tabel_guru);
    $guru = mysqli_num_rows($cek_tabel_guru);

    // Kondisi jika pengguna merupakan admin
    if ($admin > 0) {
        $row = mysqli_fetch_assoc($cek_tabel_admin);
        $_SESSION["id_pengguna"] = $row["id_user"];
        $_SESSION["kode_pengguna"] = $row["kode_pengguna"];
        $_SESSION["nama_admin"] = $row["nama"];
        $_SESSION["username"] = $row["username"];
        $_SESSION["level"] = $row["level"];
        $_SESSION["nip"] = $row["nip"];
        // Mengalihkan halaman ke page beranda
        header("Location: index.php?page=beranda");
    }
    // Kondisi jika pengguna merupakan mahasiswa
    else if ($mahasiswa > 0) {
        $row = mysqli_fetch_assoc($cek_tabel_santri);
        $_SESSION["id_pengguna"] = $row["id_user"];
        $_SESSION["kode_pengguna"] = $row["kode_pengguna"];
        $_SESSION["id_santri"] = $row["id_santri"];
        $_SESSION["nama_santri"] = $row["nama_santri"];
        $_SESSION["username"] = $row["username"];
        $_SESSION["universitas"] = $row["universitas"];
        $_SESSION["level"] = $row["level"];
        $_SESSION["foto"] = $row["foto"];
        $_SESSION["nim"] = $row["nim"];
        // Mengalihkan halaman ke page beranda
        header("Location: index.php?page=beranda");
    }
    // Kondisi jika pengguna merupakan guru
    else if ($guru > 0) {
        $row = mysqli_fetch_assoc($cek_tabel_guru);
        $_SESSION["id_pengguna"] = $row["id_user"];
        $_SESSION["kode_pengguna"] = $row["kode_pengguna"];
        $_SESSION["id_guru"] = $row["id_guru"];
        $_SESSION["nama_guru"] = $row["nama_guru"];
        $_SESSION["username"] = $row["username"];
        $_SESSION["level"] = $row["level"];
        $_SESSION["nip"] = $row["nip"];
        $_SESSION["foto"] = $row["foto"];
        // Mengalihkan halaman ke page beranda
        header("Location: index.php?page=beranda");
    }
    // Jika username dan password tidak ditemukan
    else {
        // Variabel dibuat terlebih dahulu
        $pesan = "<div class='alert alert-danger'><strong>Error!</strong> Username dan Password Salah.</div>";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="shortcut icon" href="source/img/logo2.jpg">
    <!-- Title Website -->
    <title>MONITORING HAFALAN PONDOK PESANTREN NURUL QUR'AN</title>
    <!-- Favicon -->
    <link rel="shortcut icon" href="apps/pengaturan/logo/<?php echo $logo; ?>">
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="template/login/css/bootstrap.min.css"/>
    <!-- Google Font Roboto -->
    <link href="template/login/font/" rel="stylesheet" />
    <!-- Custom CSS -->
    <link rel="stylesheet" href="template/css/login.css"/>
    <style>
        .bg-image {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url('source/img/background.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            z-index: -2;
            filter: blur(0px) brightness(0.7) sepia(10%) saturate(50%) hue-rotate(-20deg);
        }
        .bg-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(212, 51, 67, 0.4);
            z-index: -1;
        }
    </style>
</head>
<body>
    <div class="bg-image"></div>
    <div class="bg-overlay"></div>
    <div class="container rounded shadow-lg px-3 py-4" style="max-width: 340px">
        <!-- Tambahkan Logo/Foto -->
        <div class="text-center mb-4">
            <img src="source/img/logo2.jpg" alt="Logo Nurul Quran" width="120">
        </div>
        
        <h4 class="text-center" style="line-height: 1.4; margin-bottom: 20px;">MONITORING HAFALAN<br>PONDOK PESANTREN NURUL QUR'AN</h4>
        
        <form action="<?php echo $_SERVER["PHP_SELF"];?>" method="post">
            <label for="info" class="text-muted">Silahkan Login</label>
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" class="form-control" name="username" id="username" placeholder="Masukkan username"/>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" name="password" id="password" placeholder="Masukkan password"/>
            </div>
            <?php if ($_SERVER["REQUEST_METHOD"] == "POST") echo $pesan; ?>
            <button type="submit" name="submit" class="btn btn-primary w-100 btn-block">Login</button>
        </form>
    </div>
</body>
</html>
