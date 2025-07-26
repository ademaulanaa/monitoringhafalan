<?php
session_start();
// Cek apakah user sudah login
if (!isset($_SESSION['level'])) {
    header("Location: ../../index.php");
    exit();
}

// Ambil ID santri dari POST
$id_santri = isset($_POST['id_santri']) ? intval($_POST['id_santri']) : null;

if (!$id_santri) {
    echo "<div class='alert alert-danger'>ID Santri tidak ditemukan.</div>";
    exit;
}

// Include koneksi database
include '../../config/database.php';

// Fungsi untuk mencegah inputan karakter yang tidak sesuai
function input($data) {
    global $kon;
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return mysqli_real_escape_string($kon, $data);
}

// Cek apakah ada kiriman form dari method POST
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['tambah_data_tasmi'])) {
    // Ambil data dari form
    $id_santri = input($_POST["id_santri"]);
    $tanggal = input($_POST["tanggal"]);
    $juz_penyimak = input($_POST["juz_penyimak"]);
    $juz_tasmi = input($_POST["juz_tasmi"]);
    $status = input($_POST["status"]);
    $khofi = input($_POST["khofi"]);
    $jali = input($_POST["jali"]);
    $penyimak = input($_POST["penyimak"]);
    $keterangan = input($_POST["keterangan"]);

    // Validasi input
    if ($juz_penyimak < 1 || $juz_penyimak > 30) {
        echo "<div class='alert alert-danger'>Juz harus antara 1-30</div>";
        exit;
    }

    if ($khofi < 1 || $khofi > 5) {
        echo "<div class='alert alert-danger'>Nilai Khofi harus antara 1-5</div>";
        exit;
    }

    if ($jali < 1 || $jali > 5) {
        echo "<div class='alert alert-danger'>Nilai Jali harus antara 1-5</div>";
        exit;
    }

    // Validasi format tanggal
    if (!strtotime($tanggal)) {
        echo "<div class='alert alert-danger'>Format tanggal tidak valid.</div>";
        exit;
    }

    // Mulai transaksi
    mysqli_begin_transaction($kon);

    try {
        // Gunakan prepared statement untuk keamanan
        $sql = "INSERT INTO tbl_tasmi (id_santri, tanggal, tambah_juz, juz_tasmi, status, khofi, jali, penyimak, keterangan) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($kon, $sql);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "issssssss", $id_santri, $tanggal, $juz_penyimak, $juz_tasmi, $status, $khofi, $jali, $penyimak, $keterangan);
            
            if (mysqli_stmt_execute($stmt)) {
                mysqli_commit($kon);
                header("Location: ../../index.php?page=riwayat_hafalan_santri&id_santri=$id_santri&add=berhasil");
                exit;
            } else {
                throw new Exception("Gagal menyimpan data: " . mysqli_error($kon));
            }
            mysqli_stmt_close($stmt);
        } else {
            throw new Exception("Error dalam persiapan query: " . mysqli_error($kon));
        }
    } catch (Exception $e) {
        mysqli_rollback($kon);
        echo "<div class='alert alert-danger'>" . $e->getMessage() . "</div>";
    }
}
?>

<!-- Form Tambah Tasmi -->
<form action="apps/data_hafalan/tambah_tasmi.php" method="post" enctype="multipart/form-data">
    <input type="hidden" name="id_santri" value="<?php echo htmlspecialchars($id_santri); ?>">
    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                <label>Tanggal Tasmi :</label>
                <input type="date" name="tanggal" class="form-control" value="<?php echo date('Y-m-d'); ?>" required>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label>Tambah Juz :</label>
                <input type="number" name="juz_penyimak" class="form-control" placeholder="Contoh: 5" min="1" max="30" required>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                <label>Juz Tasmi :</label>
                <input type="text" name="juz_tasmi" class="form-control" placeholder="Contoh: 1 - 5" required>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label>Status :</label>
                <select name="status" class="form-control" required>
                    <option value="">-- Pilih Status --</option>
                    <option value="Lanjut">Lanjut</option>
                    <option value="Ulang">Ulang</option>
                </select>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                <label>Khofi :</label>
                <input type="number" name="khofi" class="form-control" placeholder="Masukkan nilai Khofi" min="1" max="5" required>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label>Jali :</label>
                <input type="number" name="jali" class="form-control" placeholder="Masukkan nilai Jali" min="1" max="5" required>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                <label>Penyimak :</label>
                <input type="text" name="penyimak" class="form-control" placeholder="Masukkan nama penyimak" required>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label>Keterangan :</label>
                <textarea class="form-control" name="keterangan" rows="3" placeholder="Masukkan keterangan"></textarea>
            </div>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-sm-12">
            <button type="submit" name="tambah_data_tasmi" class="btn btn-primary" style="background-color: rgb(182, 71, 82); border-color: rgb(182, 71, 82);">
                <i class="fa fa-save"></i> Simpan
            </button>
            <button type="reset" class="btn btn-secondary">
                <i class="fa fa-refresh"></i> Reset
            </button>
        </div>
    </div>
</form>
