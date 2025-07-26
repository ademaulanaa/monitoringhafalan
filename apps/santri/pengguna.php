<?php
    session_start();
    if (isset($_POST['submit'])) {

        include '../../config/database.php';
        function input($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            mysqli_query($kon,"START TRANSACTION");

            $kode_santri=input($_POST["kode_santri"]);
            $username=input($_POST["username"]);
            $level="Santri";
            $password=md5(input($_POST["password"]));
            
            $sql="UPDATE tbl_user SET
            username='$username',
            password='$password',
            level='$level'
            WHERE kode_pengguna='$kode_santri'";
            $setting_pengguna=mysqli_query($kon,$sql);

            if ($setting_pengguna) {
                mysqli_query($kon,"COMMIT");
                header("Location:../../index.php?page=santri&pengguna=berhasil");
            }
            else {
                mysqli_query($kon,"ROLLBACK");
                header("Location:../../index.php?page=santri&pengguna=gagal");
            }
        }  
    }
?>

<form action="apps/santri/pengguna.php" method="post">
<?php
    include '../../config/database.php';
    $kode_pengguna=$_POST['kode_santri'];
    $query = mysqli_query($kon, "SELECT * FROM tbl_user where kode_pengguna='$kode_pengguna'");
    $data = mysqli_fetch_array($query);
    $username=$data['username'];
?>
    <div class="row">
        <div class="col-sm-7">
            <div class="form-group">
                <input name="kode_santri" type="hidden" id="kode_santri" class="form-control" value="<?php echo $_POST['kode_santri'];?>"/>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                <label>Username :</label>
                <input name="username" type="text" id="username" class="form-control" value="<?php echo $username; ?>" placeholder="Buat Username" required>
                <div id="info_username"> </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label>Password :</label>
                <input name="password" type="password" class="form-control" value="" placeholder="Buat Password" required>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-4">
            <button type="submit" name="submit" id="submit" class="btn-setting btn btn-success"><i class="fa fa-edit"></i> Simpan</button>
        </div>
    </div>
</form>

<script>
    $("#username").bind('keyup', function () {
        var username = $('#username').val();
        $.ajax({
            url: 'apps/pengguna/cek_username.php',
            method: 'POST',
            data:{username:username},
            success:function(data){
                $('#info_username').show();
                $('#info_username').html(data);
            }
        }); 
    });
</script>

<script>
    // fungsi mengubah password
   $('.btn-setting').on('click',function(){
        konfirmasi=confirm("Konfirmasi Menyimpan Username dan Password?")
        if (konfirmasi){
            return true;
        }else {
            return false;
        }
    });
</script>