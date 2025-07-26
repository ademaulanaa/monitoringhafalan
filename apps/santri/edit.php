<?php
session_start();
if (isset($_POST['edit_santri'])) {
    include '../../config/database.php';
    function input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        mysqli_query($kon, "START TRANSACTION");
        $id_santri = input($_POST["id_santri"]);
        $nama_santri = input($_POST["nama_santri"]);
        $nis = input($_POST["nis"]);
        $no_telp = input($_POST["no_telp"]);
        $nama_ortu = input($_POST["nama_ortu"]);
        $alamat = input($_POST["alamat"]);
        $id_kelas = input($_POST["id_kelas"]);
        $username = input($_POST["username"]);
        $password = !empty($_POST["password"]) ? md5(input($_POST["password"])) : $_POST["password_lama"];
        $level = "Santri";
        $kode_santri = input($_POST["kode_santri"]);
        
        // Update data pengguna
        $sql_user = "UPDATE tbl_user SET 
                     username = '$username',
                     password = '$password',
                     level = '$level'
                     WHERE kode_pengguna = '$kode_santri'";
        $update_user = mysqli_query($kon, $sql_user);

        $ekstensi_diperbolehkan = array('png', 'jpg', 'jpeg', 'gif');
        $foto = $_FILES['foto']['name'];
        $x = explode('.', $foto);
        $ekstensi = strtolower(end($x));
        $ukuran = $_FILES['foto']['size'];
        $file_tmp = $_FILES['foto']['tmp_name'];
        $pengguna = input($_POST["pengguna"]);
        $foto_saat_ini = $_POST['foto_saat_ini'];
        $foto_baru = $_FILES['foto_baru']['name'];
        $ekstensi_diperbolehkan = array('png', 'jpg', 'jpeg', 'gif');
        $x = explode('.', $foto_baru);
        $ekstensi = strtolower(end($x));
        $ukuran = $_FILES['foto_baru']['size'];
        $file_tmp = $_FILES['foto_baru']['tmp_name'];

        if (!empty($foto_baru)) {
            if (in_array($ekstensi, $ekstensi_diperbolehkan) === true) {
                move_uploaded_file($file_tmp, 'foto/' . $foto_baru);
                if ($foto_saat_ini != 'foto_default.png') {
                    unlink("foto/" . $foto_saat_ini);
                }
                $sql = "UPDATE tbl_santri SET
                        nama_santri='$nama_santri',
                        nis='$nis',
                        alamat='$alamat',
                        nama_ortu='$nama_ortu',
                        no_telp='$no_telp',
                        foto='$foto_baru',
                        id_kelas='$id_kelas'
                        WHERE id_santri=$id_santri";
            }
        } else {
            $sql = "UPDATE tbl_santri SET
                    nama_santri='$nama_santri',
                    nis='$nis',
                    no_telp='$no_telp',
                    alamat='$alamat',
                    nama_ortu='$nama_ortu',
                    id_kelas='$id_kelas'
                    WHERE id_santri=$id_santri";
        }

        $edit_santri = mysqli_query($kon, $sql);
        if ($edit_santri && $update_user) {
            mysqli_query($kon, "COMMIT");
            header("Location:../../index.php?page=santri&edit=berhasil");
        } else {
            mysqli_query($kon, "ROLLBACK");
            header("Location:../../index.php?page=santri&edit=gagal");
        }
    }
}
?>

<?php
include '../../config/database.php';
$id_santri = $_POST["id_santri"];
$sql = "SELECT s.*, u.username, u.password 
        FROM tbl_santri s 
        LEFT JOIN tbl_user u ON s.kode_santri = u.kode_pengguna 
        WHERE s.id_santri=$id_santri LIMIT 1";
$hasil = mysqli_query($kon, $sql);
$data = mysqli_fetch_array($hasil);
?>

<form action="apps/santri/edit.php" method="post" enctype="multipart/form-data">
    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                <label>Nama Lengkap :</label>
                <input type="hidden" name="id_santri" class="form-control" value="<?php echo $data['id_santri']; ?>">
                <input type="hidden" name="kode_santri" class="form-control" value="<?php echo $data['kode_santri']; ?>">
                <input type="hidden" name="password_lama" class="form-control" value="<?php echo $data['password']; ?>">
                <input type="text" name="nama_santri" class="form-control" value="<?php echo $data['nama_santri']; ?>" placeholder="Masukan Nama Santri" required>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label>Username :</label>
                <input type="text" name="username" class="form-control" value="<?php echo $data['username']; ?>" placeholder="Masukan Username" required>
                <div id="info_username"></div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                <label>NIS :</label>
                <input type="text" name="nis" class="form-control" value="<?php echo $data['nis']; ?>" placeholder="Masukan NIS" required>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label>Password :</label>
                <input type="password" name="password" class="form-control" placeholder="Kosongkan jika tidak ingin mengubah password">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                <label>Kelas :</label>
                <select name="id_kelas" class="form-control" required>
                    <option value="">-- Pilih Kelas --</option>
                    <?php
                    // Ambil data kelas dari database
                    $sql_kelas = "SELECT * FROM tbl_kelas";
                    $hasil_kelas = mysqli_query($kon, $sql_kelas);
                    while ($row_kelas = mysqli_fetch_assoc($hasil_kelas)) {
                        $selected = ($row_kelas['id_kelas'] == $data['id_kelas']) ? 'selected' : '';
                        echo "<option value='{$row_kelas['id_kelas']}' $selected>{$row_kelas['nama_kelas']}</option>";
                    }
                    ?>
                </select>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label>No Telp :</label>
                <input type="text" name="no_telp" class="form-control" placeholder="Masukan No Telp" value="<?php echo $data['no_telp']; ?>" required>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label>Nama Ortu :</label>
                <input type="text" name="nama_ortu" class="form-control" placeholder="Masukan Nama ortu" value="<?php echo $data['nama_ortu']; ?>" required>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-7">
            <div class="form-group">
                <label>Alamat :</label>
                <textarea class="form-control" name="alamat" rows="4" id="alamat"><?php echo $data['alamat']; ?></textarea>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-3">
            <label>Foto :</label><br>
            <img src="apps/santri/foto/<?php echo $data['foto']; ?>" id="preview" width="90%" class="rounded" alt="Cinque Terre">
            <input type="hidden" name="foto_saat_ini" value="<?php echo $data['foto']; ?>" class="form-control" />
        </div>
        <div class="col-sm-4">
            <div id="msg"></div>
            <label>Upload Foto Baru:</label>
            <input type="file" name="foto_baru" class="file">
            <div class="input-group my-3">
                <input type="text" class="form-control" disabled placeholder="Upload File" id="file">
                <div class="input-group-append">
                    <button type="button" id="pilih_foto" class="browse btn btn-info"><i class="fa fa-search"></i> Pilih Foto</button>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-4">
            <div class="form-group">
                <br>
                <button type="submit" name="edit_santri" id="Submit" class="btn btn-warning"><i class="fa fa-edit"></i> Update</button>
            </div>
        </div>
    </div>
</form>

<style>
    .file {
        visibility: hidden;
        position: absolute;
    }
</style>

<script>
    // Cek username
    $('input[name="username"]').bind('keyup', function () {
        var username = $(this).val();
        var old_username = '<?php echo $data['username']; ?>';
        if(username != old_username) {
            $.ajax({
                url: 'apps/pengguna/cek_username.php',
                method: 'POST',
                data:{username:username},
                success:function(data){
                    $('#info_username').show();
                    $('#info_username').html(data);
                }
            }); 
        } else {
            $('#info_username').hide();
        }
    });
    
    $(document).on("click", "#pilih_foto", function () {
        var file = $(this).parents().find(".file");
        file.trigger("click");
    });
    $('input[type="file"]').change(function (e) {
        var fileName = e.target.files[0].name;
        $("#file").val(fileName);
        var reader = new FileReader();
        reader.onload = function (e) {
            document.getElementById("preview").src = e.target.result;
        };
        reader.readAsDataURL(this.files[0]);
    });
</script>