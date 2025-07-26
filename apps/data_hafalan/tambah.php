<?php
// Ambil ID santri dari POST
$id_santri = isset($_POST['id_santri']) ? intval($_POST['id_santri']) : null;

if (!$id_santri) {
    echo "<div class='alert alert-danger'>ID Santri tidak ditemukan.</div>";
    exit;
}

// Include koneksi database
include '../../config/database.php';

// Fungsi untuk membersihkan input
function input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Proses tambah data hafalan
if (isset($_POST['tambah_data_hafalan'])) {
    // Ambil data dari form
    $id_santri = input($_POST["id_santri"]);
    $id_surat = input($_POST["id_surat"]);
    $ayat = input($_POST["ayat"]);
    $juz = input($_POST["juz"]);
    $tgl_hafalan = input($_POST["tgl_hafalan"]);
    $status = input($_POST["status"]);
    $keterangan = input($_POST["keterangan"]);

    // Ambil ID Kelas dari tbl_santri berdasarkan id_santri
    $query_kelas = mysqli_query($kon, "SELECT id_kelas FROM tbl_santri WHERE id_santri = '$id_santri'");
    $data_kelas = mysqli_fetch_assoc($query_kelas);
    $id_kelas = $data_kelas['id_kelas'] ?? null;

    if (!$id_kelas) {
        echo "<div class='alert alert-danger'>ID Kelas tidak ditemukan untuk santri ini.</div>";
        exit;
    }

    // Query untuk insert data hafalan
    $sql = "INSERT INTO tbl_hafalan (id_santri, id_kelas, id_surat, ayat, juz, tgl_hafalan, status, keterangan) 
            VALUES ('$id_santri', '$id_kelas', '$id_surat', '$ayat', '$juz', '$tgl_hafalan', '$status', '$keterangan')";

    // Eksekusi query
    if (mysqli_query($kon, $sql)) {
        header("Location: ../../index.php?page=riwayat_hafalan_santri&id_santri=$id_santri&add=berhasil");
    } else {
        header("Location: ../../index.php?page=riwayat_hafalan_santri&id_santri=$id_santri&add=gagal");
    }
}
?>

<!-- Form Tambah Hafalan -->

    <div class="card-body">
        <form action="apps/data_hafalan/tambah.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="id_santri" value="<?php echo htmlspecialchars($id_santri); ?>">
            
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Surat</label>
                        <select name="id_surat" class="form-control" required>
                            <option value="">-- Pilih Surat --</option>
                            <?php
                            $sql_surat = "SELECT * FROM tbl_surat ORDER BY id_surat ASC";
                            $hasil_surat = mysqli_query($kon, $sql_surat);
                            while ($data_surat = mysqli_fetch_assoc($hasil_surat)) {
                                echo "<option value='" . $data_surat['id_surat'] . "'>" . $data_surat['id_surat'] . ". " . htmlspecialchars($data_surat['nama_surat']) . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Ayat</label>
                        <input type="text" name="ayat" class="form-control" required>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Juz</label>
                        <input type="number" name="juz" class="form-control" min="1" max="30" required>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Tanggal Hafalan </label>
                        <input type="date" name="tgl_hafalan" class="form-control" value="<?php echo date('Y-m-d'); ?>" required>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Status </label>
                        <select name="status" class="form-control" required>
                            <option value="">-- Pilih Status --</option>
                            <option value="Lanjut">Lanjut</option>
                            <option value="Ulang">Ulang</option>
                        </select>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Keterangan</label>
                        <textarea class="form-control" name="keterangan" rows="3" placeholder="Masukkan keterangan"></textarea>
                    </div>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-sm-12">
                    <button type="submit" name="tambah_data_hafalan" class="btn btn-primary" style="background-color: rgb(182, 71, 82); border-color: rgb(182, 71, 82);">
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
