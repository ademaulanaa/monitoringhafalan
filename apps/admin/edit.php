<?php
session_start();
    if (isset($_POST['edit_admin'])) {
        
        //Include file koneksi, untuk koneksikan ke database
        include '../../config/database.php';
        
        //Fungsi untuk mencegah inputan karakter yang tidak sesuai
        function input($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }

        //Cek apakah ada kiriman form dari method post
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            //Memulai transaksi
            mysqli_query($kon,"START TRANSACTION");
            
            $id_admin = input($_POST["id_admin"]);
            $kode_admin = input($_POST["kode_admin"]);
            $nama = input($_POST["nama"]);
            $nip = input($_POST["nip"]);
            $email = input($_POST["email"]);
            $username = input($_POST["username"]);
            $password = !empty($_POST["password"]) ? md5(input($_POST["password"])) : $_POST["password_lama"];
            $level = "Admin";

            // Update data pengguna
            $sql_user = "UPDATE tbl_user SET 
                         username = '$username',
                         password = '$password',
                         level = '$level'
                         WHERE kode_pengguna = '$kode_admin'";
            $update_user = mysqli_query($kon, $sql_user);

            // Update data admin
            $sql_admin = "UPDATE tbl_admin SET 
                         nama = '$nama',
                         nip = '$nip',
                         email = '$email'
                         WHERE id_admin = $id_admin";
            $update_admin = mysqli_query($kon, $sql_admin);

            if ($update_user && $update_admin) {
                mysqli_query($kon,"COMMIT");
                header("Location:../../index.php?page=admin&edit=berhasil");
            } else {
                mysqli_query($kon,"ROLLBACK");
                header("Location:../../index.php?page=admin&edit=gagal");
            }
        }
    }
?>

<?php 
    include '../../config/database.php';
    $id_admin=$_POST["id_admin"];
    $sql="select a.*, u.username, u.password from tbl_admin a 
          left join tbl_user u on a.kode_admin = u.kode_pengguna 
          where a.id_admin=$id_admin limit 1";
    $hasil=mysqli_query($kon,$sql);
    $data = mysqli_fetch_array($hasil); 
?>

<form action="apps/admin/edit.php" method="post" enctype="multipart/form-data">
    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                <label>Nama Lengkap :</label>
                <input type="hidden" name="id_admin" class="form-control" value="<?php echo $data['id_admin'];?>">
                <input type="hidden" name="kode_admin" class="form-control" value="<?php echo $data['kode_admin'];?>">
                <input type="hidden" name="password_lama" class="form-control" value="<?php echo $data['password'];?>">
                <input type="text" name="nama" class="form-control" value="<?php echo $data['nama'];?>" placeholder="Masukan Nama Lengkap" required>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label>Username :</label>
                <input type="text" name="username" class="form-control" value="<?php echo $data['username'];?>" placeholder="Masukan Username" required>
                <div id="info_username"></div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                <label>Nomor Induk Pegawai (NIP) :</label>
                <input type="text" name="nip" class="form-control" value="<?php echo $data['nip'];?>" placeholder="Masukan Nomor Induk Pegawai" required>
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
                <label>Email :</label>
                <input type="email" name="email" class="form-control" value="<?php echo $data['email'];?>" placeholder="Masukan Email" required>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-4">
            <div class="form-group">
                <br>
                <button type="submit" name="edit_admin" id="Submit" class="btn btn-warning"><i class="fa fa-edit"></i> Update</button>
            </div>
        </div>
    </div>
</form>

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
</script>

<style>
    .file {
    visibility: hidden;
    position: absolute;
    }
</style>