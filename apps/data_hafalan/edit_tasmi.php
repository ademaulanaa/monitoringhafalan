<?php
session_start();
// Cek apakah user sudah login
if (!isset($_SESSION['level'])) {
    header("Location: ../../index.php");
    exit();
}

// Ambil ID tasmi dari POST
$id_tasmi = isset($_POST['id_tasmi']) ? intval($_POST['id_tasmi']) : null;

if (!$id_tasmi) {
    echo "<div class='alert alert-danger'>Data tasmi tidak ditemukan.</div>";
    exit;
}

include '../../config/database.php';

// Fungsi untuk membersihkan input
function input($data) {
    global $kon;
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return mysqli_real_escape_string($kon, $data);
}

// Proses update data tasmi
if (isset($_POST['edit_tasmi'])) {
    // Ambil data dari form
    $id_tasmi = input($_POST["id_tasmi"]);
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

    // Mulai transaksi
    mysqli_begin_transaction($kon);

    try {
        // Query untuk update data tasmi
        $sql = "UPDATE tbl_tasmi SET
                tanggal = ?,
                tambah_juz = ?,
                juz_tasmi = ?,
                status = ?,
                khofi = ?,
                jali = ?,
                penyimak = ?,
                keterangan = ?
                WHERE id_tasmi = ?";

        $stmt = mysqli_prepare($kon, $sql);
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "ssssssssi", $tanggal, $juz_penyimak, $juz_tasmi, $status, $khofi, $jali, $penyimak, $keterangan, $id_tasmi);

            if (mysqli_stmt_execute($stmt)) {
                mysqli_commit($kon);
                header("Location: ../../index.php?page=riwayat_hafalan_santri&id_santri=$id_santri&edit=berhasil");
                exit();
            } else {
                throw new Exception("Gagal mengupdate data: " . mysqli_error($kon));
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

// Ambil data tasmi yang akan diedit
if (isset($_POST['id_tasmi'])) {
    $id_tasmi = $_POST['id_tasmi'];
    $query = "SELECT * FROM tbl_tasmi WHERE id_tasmi = ?";
    $stmt = mysqli_prepare($kon, $query);
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "i", $id_tasmi);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $data_tasmi = mysqli_fetch_assoc($result);
        mysqli_stmt_close($stmt);
        
        if (!$data_tasmi) {
            echo "<div class='alert alert-danger'>Data tasmi tidak ditemukan.</div>";
            exit;
        }
    } else {
        echo "<div class='alert alert-danger'>Error dalam persiapan query: " . mysqli_error($kon) . "</div>";
        exit;
    }
}
?>

<!-- Form Edit Tasmi -->
<form action="apps/data_hafalan/edit_tasmi.php" method="post" enctype="multipart/form-data">
    <div class="row">
        <input type="hidden" name="id_tasmi" value="<?php echo htmlspecialchars($data_tasmi['id_tasmi']); ?>">
        <input type="hidden" name="id_santri" value="<?php echo htmlspecialchars($data_tasmi['id_santri']); ?>">
        <div class="col-sm-6">
            <div class="form-group">
                <label>Tanggal Tasmi :</label>
                <input type="date" name="tanggal" class="form-control" value="<?php echo htmlspecialchars($data_tasmi['tanggal']); ?>" required>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label>Tambah Juz :</label>
                <input type="number" name="juz_penyimak" class="form-control" value="<?php echo htmlspecialchars($data_tasmi['tambah_juz']); ?>" min="1" max="30" required>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                <label>Juz Tasmi :</label>
                <input type="text" name="juz_tasmi" class="form-control" value="<?php echo htmlspecialchars($data_tasmi['juz_tasmi']); ?>" required>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label>Status :</label>
                <select name="status" class="form-control" required>
                    <option value="Lanjut" <?php echo ($data_tasmi['status'] == 'Lanjut') ? 'selected' : ''; ?>>Lanjut</option>
                    <option value="Ulang" <?php echo ($data_tasmi['status'] == 'Ulang') ? 'selected' : ''; ?>>Ulang</option>
                </select>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                <label>Khofi :</label>
                <input type="number" name="khofi" class="form-control" value="<?php echo htmlspecialchars($data_tasmi['khofi']); ?>" min="1" max="5" required>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label>Jali :</label>
                <input type="number" name="jali" class="form-control" value="<?php echo htmlspecialchars($data_tasmi['jali']); ?>" min="1" max="5" required>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                <label>Penyimak :</label>
                <input type="text" name="penyimak" class="form-control" value="<?php echo htmlspecialchars($data_tasmi['penyimak']); ?>" required>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label>Keterangan :</label>
                <textarea class="form-control" name="keterangan" rows="3"><?php echo htmlspecialchars($data_tasmi['keterangan']); ?></textarea>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <button type="submit" name="edit_tasmi" class="btn btn-primary" style="background-color: rgb(182, 71, 82); border-color: rgb(182, 71, 82);">
                <i class="fa fa-edit"></i> Update
            </button>
            <button type="reset" class="btn btn-secondary">
                <i class="fa fa-refresh"></i> Reset
            </button>
        </div>
    </div>
</form>
