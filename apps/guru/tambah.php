<?php
    session_start();
    if (isset($_POST['tambah_guru'])) {
        
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

            $nama_guru=input($_POST["nama_guru"]);
            $nip=input($_POST["nip"]);
            $email=input($_POST["email"]);
            $no_telp=input($_POST["no_telp"]);
            $alamat=input($_POST["alamat"]);
            $username = input($_POST["username"]);
            $password = md5(input($_POST["password"]));
            $level = "Guru";
            $ekstensi_diperbolehkan = array('png','jpg','jpeg','gif');
            $foto = $_FILES['foto']['name'];
            $x = explode('.', $foto);
            $ekstensi = strtolower(end($x));
            $ukuran = $_FILES['foto']['size'];
            $file_tmp = $_FILES['foto']['tmp_name'];

            include '../../config/database.php';
            $query = mysqli_query($kon, "SELECT max(id_guru) as id_terbesar FROM tbl_guru");
            $ambil= mysqli_fetch_array($query);
            $id_guru = $ambil['id_terbesar'];
            $id_guru++;
            
            //Membuat kode guru
            $huruf = "G";
            $kode_guru = $huruf . sprintf("%03s", $id_guru);

            $sql="INSERT INTO tbl_user (kode_pengguna, username, password, level) VALUES ('$kode_guru', '$username', '$password', '$level')";
            
            //Menyimpan ke tabel pengguna
            $simpan_pengguna=mysqli_query($kon,$sql);

            if (!empty($foto)){
                if(in_array($ekstensi, $ekstensi_diperbolehkan) === true){
                    // Resize gambar ke 300x400 px sebelum simpan
                    $target_width = 300;
                    $target_height = 400;
                    $target_path = 'foto/'.$foto;
                    // Ambil tipe gambar
                    if ($ekstensi == 'jpg' || $ekstensi == 'jpeg') {
                        $src_image = imagecreatefromjpeg($file_tmp);
                    } elseif ($ekstensi == 'png') {
                        $src_image = imagecreatefrompng($file_tmp);
                    } elseif ($ekstensi == 'gif') {
                        $src_image = imagecreatefromgif($file_tmp);
                    } else {
                        $src_image = false;
                    }
                    if ($src_image) {
                        $dst_image = imagecreatetruecolor($target_width, $target_height);
                        // Untuk PNG transparan
                        if ($ekstensi == 'png') {
                            imagealphablending($dst_image, false);
                            imagesavealpha($dst_image, true);
                        }
                        $src_width = imagesx($src_image);
                        $src_height = imagesy($src_image);
                        imagecopyresampled($dst_image, $src_image, 0, 0, 0, 0, $target_width, $target_height, $src_width, $src_height);
                        if ($ekstensi == 'jpg' || $ekstensi == 'jpeg') {
                            imagejpeg($dst_image, $target_path, 90);
                        } elseif ($ekstensi == 'png') {
                            imagepng($dst_image, $target_path);
                        } elseif ($ekstensi == 'gif') {
                            imagegif($dst_image, $target_path);
                        }
                        imagedestroy($src_image);
                        imagedestroy($dst_image);
                    } else {
                        // Jika bukan gambar, upload biasa
                        move_uploaded_file($file_tmp, $target_path);
                    }
                    //Sql jika menggunakan foto
                    $sql="insert into tbl_guru (kode_guru,nama_guru ,nip, email,alamat,no_telp,foto) values
                    ('$kode_guru','$nama_guru','$nip','$email','$alamat','$no_telp','$foto')";
                }
            }else {
                //Sql jika tidak menggunakan foto, maka akan memakai gambar_default.png
                $foto="foto_default.png";
                $sql="insert into tbl_guru (kode_guru,nama_guru,nip, email, alamat,no_telp,foto) values
                ('$kode_guru','$nama_guru','$nip','$email','$alamat','$no_telp','$foto')";
            }

            //Menyimpan ke tabel guru
            $simpan_guru=mysqli_query($kon,$sql);
            
            if ($simpan_pengguna and $simpan_guru) {
                mysqli_query($kon,"COMMIT");
                header("Location:../../index.php?page=guru&add=berhasil");
            }
            else {
                mysqli_query($kon,"ROLLBACK");
                header("Location:../../index.php?page=guru&add=gagal");
            }
        }
    }
?>


<form action="apps/guru/tambah.php" method="post" enctype="multipart/form-data">
    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                <label>Nama Lengkap :</label>
                <input type="text" name="nama_guru" class="form-control" placeholder="Masukan Nama Guru" required>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label>Username :</label>
                <input type="text" name="username" class="form-control" placeholder="Masukan Username" required>
                <div id="info_username"></div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                <label>NIP :</label>
                <input type="text" name="nip" class="form-control" placeholder="Masukan Nomor Induk Pegawai" required>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label>Password :</label>
                <input type="password" name="password" class="form-control" placeholder="Masukan Password" required>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                <label>Email :</label>
                <input type="email" name="email" class="form-control" placeholder="Masukan Email" required>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label>No Telp :</label>
                <input type="text" name="no_telp" class="form-control" placeholder="Masukan No Telp" required>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-7">
            <div class="form-group">
                <label>Alamat :</label>
                <textarea class="form-control" name="alamat" rows="4" id="alamat"></textarea>
            </div>
        </div>
        <div class="col-sm-5">
            <div class="form-group">
                <div id="msg"></div>
                <label>Foto :</label>
                <input type="file" name="foto" class="file" >
                    <div class="input-group my-3">
                        <input type="text" class="form-control" disabled placeholder="Upload Foto" id="file">
                        <div class="input-group-append">
                            <button type="button" id="pilih_foto" class="browse btn btn-info"><i class="fa fa-search"></i> Pilih</button>
                        </div>
                    </div>
                <img src="source/img/size.png" id="preview" class="img-thumbnail">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-4">
            <button type="submit" name="tambah_guru" id="Submit" class="btn btn-success"><i class="fa fa-plus"></i>Tambah</button>
            <!--<button type="reset" class="btn btn-warning"><i class="fa fa-trash"></i> Reset</button>-->
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
    $(document).on("click", "#pilih_foto", function() {
    var file = $(this).parents().find(".file");
    file.trigger("click");
    });
    $('input[type="file"]').change(function(e) {
    var fileName = e.target.files[0].name;
    $("#file").val(fileName);

    var reader = new FileReader();
    reader.onload = function(e) {
        // get loaded data and render thumbnail.
        document.getElementById("preview").src = e.target.result;
    };
    // read the image file as a data URL.
    reader.readAsDataURL(this.files[0]);
    });

    // Cek username
    $('input[name="username"]').bind('keyup', function () {
        var username = $(this).val();
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

