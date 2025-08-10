<?php
session_start();
include '../../config/database.php';

$id_tahsin = isset($_POST['id_tahsin']) ? intval($_POST['id_tahsin']) : null;

if (!$id_tahsin) {
    echo "<div class='alert alert-danger'>ID Tahsin tidak valid.</div>";
    exit;
}

// Fungsi untuk membersihkan input
function input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Proses update data tahsin
if (isset($_POST['edit_tahsin'])) {
    // Ambil data dari form
    $id_tahsin = input($_POST["id_tahsin"]);
    $id_santri = input($_POST["id_santri"]);
    $tanggal = input($_POST["tanggal"]);
    $jilid = input($_POST["jilid"]);
    $halaman = input($_POST["halaman"]);
    $status = input($_POST["status"]);
    $keterangan = input($_POST["keterangan"]);

    // Query untuk update data tahsin
    $sql = "UPDATE tbl_tahsin SET
            tanggal = '$tanggal',
            jilid = '$jilid',
            halaman = '$halaman',
            status = '$status',
            keterangan = '$keterangan'
            WHERE id_tahsin = '$id_tahsin';";

    // Eksekusi query
    if (mysqli_query($kon, $sql)) {
        header("Location: ../../index.php?page=riwayat_hafalan_santri&id_santri=$id_santri&edit=berhasil");
    } else {
        header("Location: ../../index.php?page=riwayat_hafalan_santri&id_santri=$id_santri&edit=gagal");
    }
}

// Ambil data tahsin yang akan diedit
if (isset($_POST['id_tahsin'])) {
    $id_tahsin = $_POST['id_tahsin'];
    $query = "SELECT * FROM tbl_tahsin WHERE id_tahsin = '$id_tahsin';";
    $result = mysqli_query($kon, $query);
    $data_tahsin = mysqli_fetch_assoc($result);
}
?>

<form method="POST" action="apps/data_hafalan/edit_tahsin.php">
    <input type="hidden" name="id_tahsin" value="<?php echo $data_tahsin['id_tahsin']; ?>">
    <input type="hidden" name="id_santri" value="<?php echo $data_tahsin['id_santri']; ?>">
    
    <div class="form-group">
        <label>Tanggal Tahsin:</label>
        <input type="date" name="tanggal" class="form-control" value="<?php echo $data_tahsin['tanggal']; ?>" required>
    </div>
    
    <div class="form-group">
        <label>Jilid:</label>
        <select name="jilid" class="form-control" required>
            <option value="">Pilih Jilid</option>
            <option value="1" <?php echo ($data_tahsin['jilid'] == '1') ? 'selected' : ''; ?>>Jilid 1</option>
            <option value="2" <?php echo ($data_tahsin['jilid'] == '2') ? 'selected' : ''; ?>>Jilid 2</option>
            <option value="3" <?php echo ($data_tahsin['jilid'] == '3') ? 'selected' : ''; ?>>Jilid 3</option>
            <option value="4" <?php echo ($data_tahsin['jilid'] == '4') ? 'selected' : ''; ?>>Jilid 4</option>
            <option value="5" <?php echo ($data_tahsin['jilid'] == '5') ? 'selected' : ''; ?>>Jilid 5</option>
            <option value="6" <?php echo ($data_tahsin['jilid'] == '6') ? 'selected' : ''; ?>>Jilid 6</option>
            <option value="7" <?php echo ($data_tahsin['jilid'] == '7') ? 'selected' : ''; ?>>Jilid 7</option>
        </select>
    </div>
    
    <div class="form-group">
        <label>Halaman:</label>
        <input type="text" name="halaman" class="form-control" value="<?php echo htmlspecialchars($data_tahsin['halaman']); ?>" placeholder="Contoh: 1-5" required>
    </div>
    
    <div class="form-group">
        <label>Status:</label>
        <select name="status" class="form-control" required>
            <option value="">Pilih Status</option>
            <option value="Lanjut" <?php echo ($data_tahsin['status'] == 'Lanjut') ? 'selected' : ''; ?>>Lanjut</option>
            <option value="Ulang" <?php echo ($data_tahsin['status'] == 'Ulang') ? 'selected' : ''; ?>>Ulang</option>
            <option value="Tidak Setoran" <?php echo ($data_tahsin['status'] == 'Tidak Setoran') ? 'selected' : ''; ?>>Tidak Setoran</option>
        </select>
    </div>
    
    <div class="form-group">
        <label>Keterangan:</label>
        <textarea name="keterangan" class="form-control" rows="3" placeholder="Masukkan keterangan tambahan..."><?php echo htmlspecialchars($data_tahsin['keterangan']); ?></textarea>
    </div>
    
    <div class="form-group">
        <button type="submit" name="edit_tahsin" class="btn btn-primary" style="background-color: rgb(182, 71, 82); border-color: rgb(182, 71, 82);">
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
