<?php
session_start();
// Ambil ID hafalan dari POST
$id_hafalan = isset($_POST['id_hafalan']) ? intval($_POST['id_hafalan']) : null;

if (!$id_hafalan) {
    echo "<div class='alert alert-danger'>Hafalan tidak ditemukan.</div>";
    exit;
}

include '../../config/database.php';

// Fungsi untuk membersihkan input
function input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Proses update data hafalan
if (isset($_POST['edit_hafalan'])) {
    // Ambil data dari form
    $id_hafalan = input($_POST["id_hafalan"]);
    $id_santri = input($_POST["id_santri"]);
    $id_surat = input($_POST["id_surat"]);
    $ayat = input($_POST["ayat"]);
    $juz = input($_POST["juz"]);
    $tgl_hafalan = input($_POST["tgl_hafalan"]);
    $status = input($_POST["status"]);
    $keterangan = input($_POST["keterangan"]);

    // Query untuk update data hafalan
    $sql = "UPDATE tbl_hafalan SET
            id_surat = '$id_surat',
            ayat = '$ayat',
            juz = '$juz',
            tgl_hafalan = '$tgl_hafalan',
            status = '$status',
            keterangan = '$keterangan'
            WHERE id_hafalan = '$id_hafalan';";

    // Eksekusi query
    if (mysqli_query($kon, $sql)) {
        header("Location: ../../index.php?page=riwayat_hafalan_santri&id_santri=$id_santri&edit=berhasil");
    } else {
        header("Location: ../../index.php?page=riwayat_hafalan_santri&id_santri=$id_santri&edit=gagal");
    }
}

// Ambil data hafalan yang akan diedit
if (isset($_POST['id_hafalan'])) {
    $id_hafalan = $_POST['id_hafalan'];
    $query = "SELECT h.*, s.nama_surat 
              FROM tbl_hafalan h 
              JOIN tbl_surat s ON h.id_surat = s.id_surat
              WHERE h.id_hafalan = '$id_hafalan';";
    $result = mysqli_query($kon, $query);
    $data_hafalan = mysqli_fetch_assoc($result);
}
?>

<!-- Form Edit Hafalan -->
    <div class="card-body">
        <form action="apps/data_hafalan/edit.php" method="post" enctype="multipart/form-data">
            <div class="row">
                <input type="hidden" name="id_hafalan" value="<?php echo $data_hafalan['id_hafalan']; ?>">
                <input type="hidden" name="id_santri" value="<?php echo $data_hafalan['id_santri']; ?>">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Surat <span class="text-danger">*</span></label>
                        <select name="id_surat" class="form-control" required>
                            <option value="">-- Pilih Surat --</option>
                            <?php
                            // Ambil data surat dari database
                            $sql_surat = "SELECT * FROM tbl_surat ORDER BY id_surat ASC";
                            $hasil_surat = mysqli_query($kon, $sql_surat);
                            while ($data_surat = mysqli_fetch_assoc($hasil_surat)) {
                                $selected = ($data_surat['id_surat'] == $data_hafalan['id_surat']) ? 'selected' : '';
                                echo "<option value='" . $data_surat['id_surat'] . "' $selected>" . $data_surat['id_surat'] . ". " . htmlspecialchars($data_surat['nama_surat']) . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Ayat <span class="text-danger">*</span></label>
                        <input type="text" name="ayat" class="form-control" value="<?php echo $data_hafalan['ayat']; ?>" required>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Juz <span class="text-danger">*</span></label>
                        <input type="number" name="juz" class="form-control" value="<?php echo $data_hafalan['juz']; ?>" min="1" max="30" required>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Tanggal Hafalan <span class="text-danger">*</span></label>
                        <input type="date" name="tgl_hafalan" class="form-control" value="<?php echo $data_hafalan['tgl_hafalan']; ?>" required>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Status <span class="text-danger">*</span></label>
                        <select name="status" class="form-control" required>
                            <option value="">-- Pilih Status --</option>
                            <option value="Lanjut" <?php echo ($data_hafalan['status'] == 'Lanjut') ? 'selected' : ''; ?>>Lanjut</option>
                            <option value="Ulang" <?php echo ($data_hafalan['status'] == 'Ulang') ? 'selected' : ''; ?>>Ulang</option>
                        </select>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Keterangan</label>
                        <textarea class="form-control" name="keterangan" rows="3" placeholder="Masukkan keterangan tambahan (opsional)"><?php echo $data_hafalan['keterangan']; ?></textarea>
                    </div>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-sm-12">
                    <button type="submit" name="edit_hafalan" class="btn btn-primary" style="background-color: rgb(182, 71, 82); border-color: rgb(182, 71, 82);">
                        <i class="fa fa-save"></i> Simpan
                    </button>
                    <button type="reset" class="btn btn-secondary">
                        <i class="fa fa-refresh"></i> Reset
                    </button>
                   
                </div>
            </div>
        </form>
    </div>
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