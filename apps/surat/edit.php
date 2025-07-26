<?php
session_start();
include '../../config/database.php';

// Ambil ID surat dari URL
$id_surat = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Ambil data surat berdasarkan ID
$query = "SELECT * FROM tbl_surat WHERE id_surat = $id_surat";
$result = mysqli_query($kon, $query);
$data = mysqli_fetch_assoc($result);

// Jika data tidak ditemukan
if (!$data) {
    header("Location: ../../index.php?page=surat&error=notfound");
    exit();
}

// Proses update data
if (isset($_POST['update_surat'])) {
    $nama_surat = mysqli_real_escape_string($kon, $_POST['nama_surat']);
    $jumlah_ayat = mysqli_real_escape_string($kon, $_POST['jumlah_ayat']);
    
    $update_query = "UPDATE tbl_surat SET nama_surat = '$nama_surat', jumlah_ayat = '$jumlah_ayat' WHERE id_surat = $id_surat";
    $update_result = mysqli_query($kon, $update_query);
    
    if ($update_result) {
        header("Location: ../../index.php?page=surat&update=berhasil");
    } else {
        header("Location: ../../index.php?page=surat&update=gagal");
    }
    exit();
}
?>

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <strong>Edit Data Surat</strong>
            </div>
            <div class="panel-body">
                <form action="apps/surat/edit.php?id=<?php echo $id_surat; ?>" method="POST">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Nama Surat :</label>
                                <input type="text" name="nama_surat" class="form-control" value="<?php echo $data['nama_surat']; ?>" required>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Jumlah Ayat :</label>
                                <input type="number" name="jumlah_ayat" class="form-control" value="<?php echo $data['jumlah_ayat']; ?>" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4">
                            <button type="submit" name="update_surat" class="btn btn-success"><i class="fa fa-save"></i> Update</button>
                            <a href="index.php?page=surat" class="btn btn-warning"><i class="fa fa-arrow-left"></i> Kembali</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div> 