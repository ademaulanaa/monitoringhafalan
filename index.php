<?php
    //Memulai sesi
session_start();
    //Jika kode pengguna di session kosong maka kembali ke login
if (!$_SESSION["kode_pengguna"]){
    header("Location:login.php");
    //Jika kode pengguna ada maka akan di proses masuk ke halaman utama
} else {
        //Menghubungkan database
    include 'config/database.php';
        //Mengambil variable dari session 
    $kode_pengguna=$_SESSION["kode_pengguna"];
    $username=$_SESSION["username"];
        //Query untuk menampilkan nama ke halaman utama
    $hasil=mysqli_query($kon,"select username from tbl_user where kode_pengguna='$kode_pengguna'");
        //Menyimpan data query ke variable data
    $data = mysqli_fetch_array($hasil); 
        //Menyimpan data username ke variable username
    $username_db=$data['username'];
    //Jika username kosong maka session akan di hapus
    if ($username!=$username_db){
        //Menghapus session
        session_unset();
        session_destroy();
        //Mengalihkan page ke halaman login
        header("Location:login.php");
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Favicon -->
    <link rel="shortcut icon" href="source/img/logo2.jpg">
    <!-- Title Website -->
    <title>PONDOK PESANTREN NURUL QUR'AN</title>
    <!-- Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="template/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="template/css/font-awesome.min.css" rel="stylesheet">
    <!-- Date Picker 3 -->
    <link href="template/css/datepicker3.css" rel="stylesheet">
    <!-- Local CSS -->
    <link href="template/css/styles.css" rel="stylesheet">
    <!-- jQuery -->
    <link rel="stylesheet" href="assets/css/jquery-ui.css">
    <script src="template/js/jquery-2.2.3.min.js"></script>
    <script src="template/js/jquery-1.11.1.min.js"></script>
    <link rel="stylesheet" href="template.css/style.css">
    <!-- Sertakan Chart.js lokal -->
    <script src="template/js/chart.min.js"></script> 
    <!-- Custom Font -->
    <link href="src/font/font.css" rel="stylesheet" type="text/css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="assets/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

</head>

<nav class="navbar navbar-custom navbar-fixed-top bg-faded" role="navigation">
    <div class="container-fluid">
        <div class="navbar-header">
        <a class="navbar-brand d-flex align-items-center" href="#">
                <img src="source/img/logo2.jpg" alt="NQ Logo" class="logo-navbar"> 
                <span class="text-navbar"> PONDOK PESANTREN NURUL QUR'AN</span>
            </a>
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#sidebar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>

                <span class="icon-bar"></span>

            </button>
            
        </div>
    </div>
</nav>

<style>
    .logo-navbar {
        height: 30px;
        margin-right: 8px;
        vertical-align: middle;
    }
    .navbar-brand {
        display: flex;
        align-items: center;
        text-decoration: none;
    }
    .text-navbar {
        color: rgb(255, 255, 255) !important;
        font-weight: bold;
    }
    .navbar-custom {
        background: #000000 !important;
    }
    .navbar-header .navbar-brand {
        color: #fff;
        font-size: 20px;
        text-transform: uppercase;
        font-weight: 500;
        height: 60px;
        padding-top: 18px;
    }
    /* Style untuk Sidebar */
    .sidebar {
        background: #000000 !important;
    }
    .sidebar ul.nav a {
        color: #fff !important;
    }
    .sidebar ul.nav a:hover, 
    .sidebar ul.nav li.parent ul li a:hover {
        background-color: rgb(220, 53, 69) !important;
        color: #fff !important;
    }
    .sidebar ul.nav .active > a, 
    .sidebar ul.nav li.parent a.active {
        background-color: #000000 !important;
        color: #fff !important;
    }
    .sidebar ul.nav ul.children {
        background: rgb(182, 71, 82) !important;
    }
    .sidebar ul.nav ul.children li a {
        background: rgb(182, 71, 82) !important;
        color: #fff !important;
    }
    .profile-sidebar {
        border-bottom: 1px solid rgba(255, 255, 255, 0.1) !important;
    }
    .profile-usertitle {
        color: #fff !important;
    }
    .profile-usertitle-name {
        color: #fff !important;
        font-size: 16px;
        font-weight: 600;
    }
    .profile-usertitle-status {
        color: #000000 !important;
        font-size: 14px;
    }
</style>


        <div id="sidebar-collapse" class="col-sm-3 col-lg-2 sidebar">
            <!-- Menampilkan info nama dan level admin di navbar -->
            <?php if ($_SESSION['level']=='Admin' or $_SESSION['level']=='admin'):?>
                <div class="profile-sidebar">
                    <div class="profile-userpic">
                        <img src="source/img/profile.png" class="img-responsive" alt="">
                    </div>
                    <div class="profile-usertitle">
                        <?php echo substr($_SESSION['nama_admin'],0,20); ?>
                        <div class="profile-usertitle-name"><?php echo "Administrator"; ?></div>
                        <div></div>
                    </div>
                    <div class="clear"></div>
                </div>
            <?php endif; ?>
            <!-- Menampilkan info nama dan level admin di navbar -->

            <!-- Menampilkan info nama dan level santri di navbar -->
            <?php if ($_SESSION['level']=='Santri' or $_SESSION['level']=='santri'):?>
                <div class="profile-sidebar">
                    <div class="profile-userpic">
                        <img src="apps/santri/foto/<?php echo $_SESSION['foto'];?>" class="img-responsive" alt="">
                    </div>
                    <div class="profile-usertitle">
                        <?php echo substr($_SESSION['nama_santri'],0,20); ?>
                        <div class="profile-usertitle-name"><?php echo "Santri"; ?></div>
                        <div></div>
                    </div>
                    <div class="clear"></div>
                </div>
            <?php endif;  
            ?>
            <!-- Menampilkan info nama dan level santri di navbar -->

            <!-- Menampilkan info nama dan level guru di navbar -->
            <?php if ($_SESSION['level']=='Guru' or $_SESSION['level']=='guru'):?>
                <div class="profile-sidebar">
                    <div class="profile-userpic">
                        <img src="apps/guru/foto/<?php echo $_SESSION['foto'];?>" class="img-responsive" alt="">
                    </div>
                    <div class="profile-usertitle">
                        <?php echo substr($_SESSION['nama_guru'],0,20); ?>
                        <div class="profile-usertitle-name"><?php echo "Guru"; ?></div>
                        <div></div>
                    </div>
                    <div class="clear"></div>
                </div>
            <?php endif;  
            ?>
            <!-- Menampilkan info nama dan level guru di navbar -->

            <!-- Side Bar Navigation -->
            <div class="divider"></div>
            <!-- Menu Beranda -->
            <ul class="nav menu">
                <li><a href='index.php?page=beranda'><em class='fa fa-home'>&nbsp;</em> Dashboard</a></li>
                <!-- Menu Beranda -->
                <!-- Menu Admin -->
                <?php if ($_SESSION["level"]=="Admin" or $_SESSION['level']=='admin'): ?>
                    <li><a href="index.php?page=santri"><i class="fas fa-user-graduate">&nbsp;</i> Data Santri</a></li>
                    <li><a href="index.php?page=guru"><i class="fas fa-chalkboard-teacher">&nbsp;</i> Data Guru</a></li>
                    <li><a href="index.php?page=kelas"><i class="fas fa-school">&nbsp;</i> Data Kelas</a></li>
                    <!--<li><a href="index.php?page=surat"><i class="fas fa-book">&nbsp;</i> Data Surat</a></li--> 
                    <li><a href="index.php?page=data_hafalan"><i class="fas fa-book-open">&nbsp;</i>Data Hafalan</a></li>
                    <li><a href="index.php?page=laporan"><i class="fas fa-chart-line">&nbsp;</i> Laporan</a></li>
                    <li><a href="index.php?page=admin"><i class="fas fa-user-cog">&nbsp;</i> Data Admin</a></li>

                <?php endif; ?>
                <!-- Menu Santri -->
                <?php  if ($_SESSION["level"]=="Santri" or $_SESSION["level"]=="santri"): ?>
                    <li><a href="index.php?page=r"><i class="fas fa-user-cog">&nbsp;</i> Riwayat Hafalan</a></li>

                <?php endif; ?>


                <!-- Menu Guru -->
                <?php  if ($_SESSION["level"]=="Guru" or $_SESSION["level"]=="guru"): ?>
                    <li><a href="index.php?page=data_hafalan"><i class="fas fa-book-open">&nbsp;</i>Data Hafalan</a></li>
                    <li><a href="index.php?page=laporan"><i class="fas fa-chart-line">&nbsp;</i> Laporan</a></li>
                <?php endif; ?>
                    <!-- Menu Guru -->

                    <!-- Menu Keluar -->    
                    <li><a href="logout.php" id="keluar"><i class="fas fa-sign-out-alt">&nbsp;</i> Logout </a></li>
                </ul>
                <!-- Menu Keluar -->
            </div>
            <!-- Side Bar Navigation -->

            <!-- Page Penghubung -->
            <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
                <?php 
                if(isset($_GET['page'])){
                    $page = $_GET['page'];
                    switch ($page) {
                        case 'beranda':
                        include "apps/beranda/index.php";
                        break;
                        case 'admin':
                        include "apps/admin/index.php";
                        break;
                        case 'guru':
                        include "apps/guru/index.php";
                        break;
                        case 'santri':
                        include "apps/santri/index.php";
                        break;
                        case 'kelas':
                        include "apps/kelas/index.php";
                        break;
                        case 'surat':
                        include "apps/surat/index.php";
                        break;
                        case 'data_absensi':
                        include "apps/data_absensi/index.php";
                        break;
                        case 'data_hafalan':
                        include "apps/data_hafalan/index.php";
                        break;
                        case 'laporan':
                        include "apps/laporan/index.php";
                        break;
                        case 'pengaturan':
                        include "apps/pengaturan/index.php";
                        break;
                        case 'absen':
                        include "apps/pengguna/absen.php";
                        break;
                        case 'hafalan_santri':
                        include "apps/data_hafalan/hafalan_santri.php";
                        break;
                        case 'riwayat_hafalan_santri':
                        include "apps/data_hafalan/riwayat_hafalan_santri.php";
                        break;
                        case 'r':
                        include "apps/data_hafalan/r.php";
                        break;
                        case 'profil':
                        include "apps/pengguna/profil.php";
                        break;
                        default:
                        echo "<center><h3>Maaf. Halaman Tidak Di Temukan !</h3></center>";
                        break;
                    }
                }
                ?>

            </div>

            <!-- Java Script -->
            <script src="template/js/bootstrap.min.js"></script>
            <script src="template/js/chart.min.js"></script>
            <script src="template/js/chart-data.js"></script>
            <script src="template/js/easypiechart.js"></script>
            <script src="template/js/easypiechart-data.js"></script>
            <script src="template/js/bootstrap-datepicker.js"></script>
            <script src="template/js/custom.js"></script>
            <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
            <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.6.2/css/buttons.dataTables.min.css">
            <script src="/assets/chart/chart.js"></script>
            <!-- Java Script -->

            <script>
   // konfirmasi sebelum keluar aplikasi
   $('#keluar').on('click',function(){
    konfirmasi=confirm("Apakah Anda Yakin Ingin Keluar?")
    if (konfirmasi){
        return true;
    }else {
        return false;
    }
});
</script>
</body>
</html>