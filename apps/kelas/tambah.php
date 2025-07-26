<?php
session_start();
if (isset($_POST['tambah_kelas'])) {
    include '../../config/database.php'; // Pastikan path ini benar

    function input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        mysqli_query($kon, "START TRANSACTION");

        $nama_kelas = input($_POST["nama_kelas"]);

        // Ambil ID kelas terbesar
        $query = mysqli_query($kon, "SELECT MAX(id_kelas) as id_terbesar FROM tbl_kelas");
        $ambil = mysqli_fetch_array($query);
        $id_kelas = $ambil['id_terbesar'] + 1;

        // Simpan ke tabel kelas
        $sql = "INSERT INTO tbl_kelas (id_kelas, nama_kelas) VALUES ('$id_kelas', '$nama_kelas')";
        $simpan_kelas = mysqli_query($kon, $sql);

        if ($simpan_kelas) {
            mysqli_query($kon, "COMMIT");
            header("Location:../../index.php?page=kelas&add=berhasil");
        } else {
            mysqli_query($kon, "ROLLBACK");
            header("Location:../../index.php?page=kelas&add=gagal");
        }
    }
}
?>

<form action="apps/kelas/tambah.php" method="post">
    <div class="form-group">
        <label>Nama Kelas :</label>
        <input type="text" name="nama_kelas" class="form-control" placeholder="Masukkan Nama Kelas" required>
    </div>
    <button type="submit" name="tambah_kelas" class="btn btn-success"><i class="fa fa-plus"></i> Tambah Kelas</button>
</form>