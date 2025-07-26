<?php
session_start();
include '../../config/database.php';

function input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if (isset($_POST['edit_guru'])) {
    mysqli_query($kon, "START TRANSACTION");

    $id_guru = input($_POST["id_guru"]);
    $kode_guru = input($_POST["kode_guru"]);
    $nama_guru = input($_POST["nama_guru"]);
    $nip = input($_POST["nip"]);
    $email = input($_POST["email"]);
    $alamat = input($_POST["alamat"]);
    $no_telp = input($_POST["no_telp"]);
    $username = input($_POST["username"]);
    $password = !empty($_POST["password"]) ? md5(input($_POST["password"])) : $_POST["password_lama"];
    $level = "Guru";

    $foto_saat_ini = $_POST['foto_saat_ini'];
    $foto_baru = $_FILES['foto_baru']['name'];
    $file_tmp = $_FILES['foto_baru']['tmp_name'];
    $ekstensi_diperbolehkan = array('png', 'jpg', 'jpeg', 'gif');
    $x = explode('.', $foto_baru);
    $ekstensi = strtolower(end($x));

    if (!empty($foto_baru)) {
        if (in_array($ekstensi, $ekstensi_diperbolehkan) === true) {
            move_uploaded_file($file_tmp, "foto/$foto_baru");
            if ($foto_saat_ini != 'foto_default.png') {
                unlink("foto/" . $foto_saat_ini);
            }
            $sql = "UPDATE tbl_guru SET 
            kode_guru='$kode_guru',
            nama_guru='$nama_guru',
            nip='$nip',
            email='$email',
            alamat='$alamat',
            no_telp='$no_telp',
            foto='$foto_baru'
            WHERE id_guru=$id_guru";
        }
    } else {
        $sql = "UPDATE tbl_guru SET 
        kode_guru='$kode_guru',
        nama_guru='$nama_guru',
        nip='$nip',
        email='$email',
        alamat='$alamat',
        no_telp='$no_telp'
        WHERE id_guru=$id_guru";
    }

    // Update data pengguna
    $sql_user = "UPDATE tbl_user SET 
                 username = '$username',
                 password = '$password',
                 level = '$level'
                 WHERE kode_pengguna = '$kode_guru'";
    $update_user = mysqli_query($kon, $sql_user);

    $edit_guru = mysqli_query($kon, $sql);
    if ($edit_guru && $update_user) {
        mysqli_query($kon, "COMMIT");
        header("Location:../../index.php?page=guru&edit=berhasil");
    } else {
        mysqli_query($kon, "ROLLBACK");
        header("Location:../../index.php?page=guru&edit=gagal");
    }
}
?>

<?php
$id_guru = $_POST["id_guru"];
$sql = "SELECT g.*, u.username, u.password 
        FROM tbl_guru g 
        LEFT JOIN tbl_user u ON g.kode_guru = u.kode_pengguna 
        WHERE g.id_guru=$id_guru LIMIT 1";
$hasil = mysqli_query($kon, $sql);
$data = mysqli_fetch_array($hasil);
?>

<form action="apps/guru/edit.php" method="post" enctype="multipart/form-data">
    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                <label>Nama Lengkap :</label>
                <input type="hidden" name="id_guru" class="form-control" value="<?php echo $data['id_guru']; ?>">
                <input type="hidden" name="kode_guru" class="form-control" value="<?php echo $data['kode_guru']; ?>">
                <input type="hidden" name="password_lama" class="form-control" value="<?php echo $data['password']; ?>">
                <input type="text" name="nama_guru" class="form-control" value="<?php echo $data['nama_guru']; ?>" placeholder="Masukan Nama Guru" required>
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
                <label>NIP :</label>
                <input type="text" name="nip" class="form-control" value="<?php echo $data['nip']; ?>" placeholder="Masukan NIP" required>
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
                <label>Email:</label>
                <input type="email" name="email" class="form-control" value="<?php echo $data['email']; ?>" required>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label>No. Telepon:</label>
                <input type="text" name="no_telp" class="form-control" value="<?php echo $data['no_telp']; ?>" required>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                <label>Alamat:</label>
                <textarea class="form-control" name="alamat" rows="3" required><?php echo $data['alamat']; ?></textarea>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-sm-3">
            <label>Foto Saat Ini:</label><br>
            <img src="apps/guru/foto/<?php echo $data['foto']; ?>" id="preview" width="100%" class="rounded">
            <input type="hidden" name="foto_saat_ini" value="<?php echo $data['foto']; ?>">
        </div>
        <div class="col-sm-4">
            <label>Upload Foto Baru:</label>
            <input type="file" name="foto_baru" class="file">
            <div class="input-group my-3">
                <input type="text" class="form-control" disabled placeholder="Upload File" id="file">
                <div class="input-group-append">
                    <button type="button" id="pilih_foto" class="browse btn btn-info">Pilih Foto</button>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-sm-4">
            <br>
            <button type="submit" name="edit_guru" class="btn btn-warning"><i class="fa fa-edit"></i> Update</button>
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

    $(document).on("click", "#pilih_foto", function() {
        var file = $(this).parents().find(".file");
        file.trigger("click");
    });

    $('input[type="file"]').change(function(e) {
        var fileName = e.target.files[0].name;
        $("#file").val(fileName);

        var reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById("preview").src = e.target.result;
        };
        reader.readAsDataURL(this.files[0]);
    });
</script>

