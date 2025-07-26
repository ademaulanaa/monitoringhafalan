<?php 
if ($_SESSION["level"] != 'Admin' && $_SESSION["level"] != 'admin' && 
    $_SESSION["level"] != 'guru' && $_SESSION["level"] != 'Guru') {

    echo "<br><div class='alert alert-danger'>Tidak memiliki Hak Akses</div>";
exit;
}
?>

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                Data Guru
            </div>
            <div class="panel-body">
                <div class="row">
                    <form action="#" method="GET">
                        <input type="hidden" name="page" value="guru"/>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <input type="text" name="cari" id="cari" class="form-control"  value="" placeholder="Pencarian">
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <button type="submit" class="btn btn-info"><i class="fa fa-search"></i> Cari</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div><!--/.row-->

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-body">

                <?php
                if (isset($_GET['add'])) {
                    if ($_GET['add']=='berhasil'){
                        echo"<div class='alert alert-success'><strong>Berhasil!</strong> Data Guru Telah Disimpan</div>";
                    }else if ($_GET['add']=='gagal'){
                        echo"<div class='alert alert-danger'><strong>Gagal!</strong> Data Guru Gagal Disimpan</div>";
                    }    
                }

                if (isset($_GET['edit'])) {
                    if ($_GET['edit']=='berhasil'){
                        echo"<div class='alert alert-success'><strong>Berhasil!</strong> Data Guru Telah Diupdate</div>";
                    }else if ($_GET['edit']=='gagal'){
                        echo"<div class='alert alert-danger'><strong>Gagal!</strong> Data Guru Gagal Diupdate</div>";
                    }    
                }

                if (isset($_GET['pengguna'])) {
                    if ($_GET['pengguna']=='berhasil'){
                        echo"<div class='alert alert-success'><strong>Berhasil!</strong> Setting Data Guru Berhasil</div>";
                    }else if ($_GET['pengguna']=='gagal'){
                        echo"<div class='alert alert-danger'><strong>Gagal!</strong> Setting Data Guru Gagal</div>";
                    }    
                }

                if (isset($_GET['hapus'])) {
                    if ($_GET['hapus']=='berhasil'){
                        echo"<div class='alert alert-success'><strong>Berhasil!</strong> Data Guru Telah Dihapus</div>";
                    }else if ($_GET['hapus']=='gagal'){
                        echo"<div class='alert alert-danger'><strong>Gagal!</strong> Data Guru Gagal Dihapus</div>";
                    }    
                }
                ?>
                <div class="form-group">
                    <button type="button" class="btn btn-success" id="tombol_tambah"><i class="fa fa-plus"></i> Tambah</button>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover table-sm" id="dataTable" width="100%" cellspacing="0">
                        <thead class="thead-dark text-center text-nowrap">
                            <tr>
                                <th>No</th>
                                <th>NIP</th>
                                <th>Nama Guru</th>
                                <th>Foto</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tbody>
                                <?php
                                include 'config/database.php';

                                $cari = isset($_GET['cari']) ? trim($_GET['cari']) : '';
                                $sql = "SELECT * FROM tbl_guru";
                                if (!empty($cari)) {
                                    $sql .= " WHERE nama_guru LIKE '%$cari%' OR nip LIKE '%$cari%'";
                                }
                                $sql .= " ORDER BY nama_guru ASC";
                                $hasil = mysqli_query($kon, $sql);

                                if (!$hasil) {
                                    echo "<tr><td colspan='5' class='text-center'>Gagal mengambil data guru</td></tr>";
                                } else {
                                    $no = 0;
        $dataFound = false; // Variabel untuk mengecek apakah ada data yang ditemukan
        while ($data = mysqli_fetch_array($hasil)) :
            $no++;
            $dataFound = true; // Set variabel menjadi true jika ada data
            ?>
            <tr>
                <td class="text-center"><?php echo $no; ?></td>
                <td><?php echo htmlspecialchars($data['nip']); ?></td>
                <td><?php echo htmlspecialchars($data['nama_guru']); ?></td>
                <td class="text-center">
                    <img src="apps/guru/foto/<?php echo htmlspecialchars($data['foto']); ?>" width="80" class="img-thumbnail">
                </td>
                <td class="text-center text-nowrap">
                    <button id_guru="<?php echo $data['id_guru']; ?>" class="tombol_detail btn btn-success btn-circle btn-sm">
                        <i class="fa fa-eye"></i>
                    </button>
                    <button id_guru="<?php echo $data['id_guru']; ?>" class="tombol_edit btn btn-warning btn-circle btn-sm">
                        <i class="fa fa-edit"></i>
                    </button>
                    <a href="apps/guru/hapus.php?id_guru=<?php echo $data['id_guru']; ?>&kode_guru=<?php echo $data['kode_guru']; ?>" class="btn-hapus-guru btn btn-danger btn-circle btn-sm">
                        <i class="fa fa-trash"></i>
                    </a>
                </td>
            </tr>
        <?php endwhile; ?>

        <?php
        // Jika tidak ada data yang ditemukan, tampilkan pesan
        if (!$dataFound) {
            echo "<tr><td colspan='5' class='text-center'>Data tidak ditemukan</td></tr>";
        }
        ?>
    <?php } ?>
</tbody>
</table>
</div>

<!-- Modal -->
<div class="modal fade" id="modal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <h4 class="modal-title" id="judul"></h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">
                <div id="tampil_data">                    
                </div>  
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
            </div>

        </div>
    </div>
</div>

<!-- Data akan di load menggunakan AJAX -->
<script>
    // Tambah guru
    $('#tombol_tambah').on('click',function(){
        $.ajax({
            url: 'apps/guru/tambah.php',
            method: 'post',
            success:function(data){
                $('#tampil_data').html(data);  
                document.getElementById("judul").innerHTML='Tambah Guru';
            }
        });
        // Membuka modal
        $('#modal').modal('show');
    });
</script>

<script>
    // Detail Guru
    $('.tombol_detail').on('click',function(){
        var id_guru = $(this).attr("id_guru");
        $.ajax({
            url: 'apps/guru/detail.php', 
            method: 'post',
            data: {id_guru:id_guru},
            success:function(data){
                $('#tampil_data').html(data);  
                document.getElementById("judul").innerHTML='Detail Guru';
            }
        });
        // Membuka modal
        $('#modal').modal('show');
    });
</script>

<script>
    // Setting Guru
    $('.tombol_setting').on('click',function(){
        var kode_guru = $(this).attr("kode_guru");
        $.ajax({
            url: 'apps/guru/pengguna.php',
            method: 'post',
            data: {kode_guru:kode_guru},
            success:function(data){
                $('#tampil_data').html(data);  
                document.getElementById("judul").innerHTML='Setting Guru';
            }
        });
        // Membuka modal
        $('#modal').modal('show');
    });
</script>

<script>
    // Edit Guru
    $('.tombol_edit').on('click',function(){
        var id_guru = $(this).attr("id_guru");
        $.ajax({
            url: 'apps/guru/edit.php',
            method: 'post',
            data: {id_guru:id_guru},
            success:function(data){
                $('#tampil_data').html(data);  
                document.getElementById("judul").innerHTML='Edit Guru';
            }
        });
        // Membuka modal
        $('#modal').modal('show');
    });
</script>

<script>
   // Hapus guru
   $('.btn-hapus-guru').on('click',function(){
    konfirmasi=confirm("Konfirmasi Sebelum Menghapus Guru?")
    if (konfirmasi){
        return true;
    }else {
        return false;
    }
});
</script>
<!-- Data akan di load menggunakan AJAX -->

