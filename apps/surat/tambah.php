<?php
session_start();
include '../../config/database.php';

// Proses tambah data surat
if (isset($_POST['tambah_surat'])) {
    $nama_surat = mysqli_real_escape_string($kon, $_POST['nama_surat']);
    $jumlah_ayat = mysqli_real_escape_string($kon, $_POST['jumlah_ayat']);
    
    $insert_query = "INSERT INTO tbl_surat (nama_surat, jumlah_ayat) VALUES ('$nama_surat', '$jumlah_ayat')";
    $insert_result = mysqli_query($kon, $insert_query);
    
    if ($insert_result) {
        header("Location: ../../index.php?page=surat&tambah=berhasil");
    } else {
        header("Location: ../../index.php?page=surat&tambah=gagal");
    }
    exit();
}
?>

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <strong>Tambah Data Surat</strong>
            </div>
            <div class="panel-body">
                <form action="apps/surat/tambah.php" method="POST">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Nama Surat :</label>
                                <input type="text" name="nama_surat" class="form-control" placeholder="Masukkan Nama Surat" required>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Jumlah Ayat :</label>
                                <input type="number" name="jumlah_ayat" class="form-control" placeholder="Masukkan Jumlah Ayat" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4">
                            <button type="submit" name="tambah_surat" class="btn btn-success"><i class="fa fa-save"></i> Simpan</button>
                            <a href="index.php?page=surat" class="btn btn-warning"><i class="fa fa-arrow-left"></i> Kembali</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div> 