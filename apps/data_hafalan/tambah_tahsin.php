<?php
session_start();
include '../../config/database.php';

$id_santri = isset($_POST['id_santri']) ? intval($_POST['id_santri']) : 0;

if (!$id_santri) {
    echo "<div class='alert alert-danger'>ID Santri tidak valid.</div>";
    exit;
}

// Fungsi untuk membersihkan input
function input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Proses tambah data tahsin
if (isset($_POST['tambah_data_tahsin'])) {
    // Ambil data dari form
    $id_santri = input($_POST["id_santri"]);
    $tanggal = input($_POST["tanggal"]);
    $jilid = input($_POST["jilid"]);
    $halaman = input($_POST["halaman"]);
    $status = input($_POST["status"]);
    $keterangan = input($_POST["keterangan"]);

    // Query untuk insert data tahsin
    $sql = "INSERT INTO tbl_tahsin (id_santri, tanggal, jilid, halaman, status, keterangan) 
            VALUES ('$id_santri', '$tanggal', '$jilid', '$halaman', '$status', '$keterangan')";

    // Eksekusi query
    if (mysqli_query($kon, $sql)) {
        header("Location: ../../index.php?page=riwayat_hafalan_santri&id_santri=$id_santri&add=berhasil");
    } else {
        header("Location: ../../index.php?page=riwayat_hafalan_santri&id_santri=$id_santri&add=gagal");
    }
}
?>

<form method="POST" action="apps/data_hafalan/tambah_tahsin.php">
    <input type="hidden" name="id_santri" value="<?php echo htmlspecialchars($id_santri); ?>">
    
    <div class="form-group">
        <label>Tanggal Tahsin:</label>
        <input type="date" name="tanggal" class="form-control" value="<?php echo date('Y-m-d'); ?>" required>
    </div>
    
    <div class="form-group">
        <label>Jilid:</label>
        <select name="jilid" class="form-control" required>
            <option value="">Pilih Jilid</option>
            <option value="1">Jilid 1</option>
            <option value="2">Jilid 2</option>
            <option value="3">Jilid 3</option>
            <option value="4">Jilid 4</option>
            <option value="5">Jilid 5</option>
            <option value="6">Jilid 6</option>
            <option value="7">Jilid 7</option>
        </select>
    </div>
    
    <div class="form-group">
        <label>Halaman:</label>
        <input type="text" name="halaman" class="form-control" placeholder="Contoh: 1-5" required>
    </div>
    
    <div class="form-group">
        <label>Status:</label>
        <select name="status" class="form-control" required>
            <option value="">Pilih Status</option>
            <option value="Lanjut">Lanjut</option>
            <option value="Ulang">Ulang</option>
            <option value="Tidak Setoran">Tidak Setoran</option>
        </select>
    </div>
    
    <div class="form-group">
        <label>Keterangan:</label>
        <textarea name="keterangan" class="form-control" rows="3" placeholder="Masukkan keterangan tambahan..."></textarea>
    </div>
    
    <div class="form-group">
        <button type="submit" name="tambah_data_tahsin" class="btn btn-primary" style="background-color: rgb(182, 71, 82); border-color: rgb(182, 71, 82);">
            <i class="fa fa-save"></i> Simpan
        </button>
        <button type="reset" class="btn btn-secondary">
            <i class="fa fa-refresh"></i> Reset
        </button>
    </div>
</form>
</div>

<style>
.card {
    border: none;
    box-shadow: 0 0 10px rgba(0,0,0,0.1);
    margin-bottom: 20px;
}
.card-header {
    border-radius: 5px 5px 0 0;
    padding: 15px;
}
.card-body {
    padding: 20px;
}
.form-group {
    margin-bottom: 20px;
}
.form-control:focus {
    border-color: rgb(182, 71, 82);
    box-shadow: 0 0 0 0.2rem rgba(182, 71, 82, 0.25);
}
.btn-primary:hover {
    background-color: rgb(189, 3, 22) !important;
    border-color: rgb(189, 3, 22) !important;
}
</style>
