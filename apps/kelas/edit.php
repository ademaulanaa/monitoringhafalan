<?php
session_start();
if (isset($_POST['edit_kelas'])) {
    include '../../config/database.php'; // Pastikan path ini benar

    function input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        mysqli_query($kon, "START TRANSACTION");
        $id_kelas = input($_POST["id_kelas"]);
        $nama_kelas = input($_POST["nama_kelas"]);

        $sql = "UPDATE tbl_kelas SET nama_kelas='$nama_kelas' WHERE id_kelas=$id_kelas";
        $edit_kelas = mysqli_query($kon, $sql);
        
        if ($edit_kelas) {
            mysqli_query($kon, "COMMIT");
            header("Location:../../index.php?page=kelas&edit=berhasil");
        } else {
            mysqli_query($kon, "ROLLBACK");
            header("Location:../../index.php?page=kelas&edit=gagal");
        }
    }
}
?>

<?php 
include '../../config/database.php'; // Pastikan path ini benar
$id_kelas = $_POST["id_kelas"];
$sql = "SELECT * FROM tbl_kelas WHERE id_kelas=$id_kelas LIMIT 1";
$hasil = mysqli_query($kon, $sql);
$data = mysqli_fetch_array($hasil);
?>

<form action="apps/kelas/edit.php" method="post">
    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                <label>Nama Kelas :</label>
                <input type="hidden" name="id_kelas" class="form-control" value="<?php echo $data['id_kelas'];?>">
                <input type="text" name="nama_kelas" class="form-control" value="<?php echo $data['nama_kelas'];?>" placeholder="Masukkan Nama Kelas" required>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-4">
            <div class="form-group">
                <br>
                <button type="submit" name="edit_kelas" class="btn btn-warning" ><i class="fa fa-edit"></i> Update</button>
            </div>
        </div>
    </div>
</form>