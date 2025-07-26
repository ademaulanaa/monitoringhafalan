<?php 
if ($_SESSION["level"] != 'Admin' && $_SESSION["level"] != 'admin') {
    echo "<br><div class='alert alert-danger'>Tidak Memiliki Hak Akses</div>";
    exit;
}
?>


<!-- <div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                Data Kelas
            </div>
            <div class="panel-body">
                <div class="row">
                    <form action="#" method="GET">
                        <input type="hidden" name="page" value="kelas"/>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <input type="text" name="cari" id="cari" class="form-control" value="" placeholder="Pencarian">
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
            <div class="panel-heading">Data Kelas</div>
            <div class="panel-body">
                <div class="form-group">
                    <button type="button" class="btn btn-success" id="tombol_tambah"><i class="fa fa-plus"></i> Tambah</button>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped table-hover table-bordered table-sm" id="dataTable" width="100%" cellspacing="0">
                        <thead class="thead-dark text-center text-nowrap">
                            <tr>
                                <th>No</th>
                                <th>Nama Kelas</th>
                                <th>Jumlah Santri</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                         <tbody>
                            <?php
    include 'config/database.php'; // Pastikan path ini benar

    // Ambil nilai pencarian dari URL
    $cari = isset($_GET['cari']) ? trim($_GET['cari']) : '';

    // Query dasar untuk data kelas
    $sql = "SELECT k.*, 
    (SELECT COUNT(*) FROM tbl_santri s WHERE s.id_kelas = k.id_kelas) AS jumlah_santri 
    FROM tbl_kelas k";
    if (!empty($cari)) {
        $sql .= " WHERE k.nama_kelas LIKE ?";
    }
    $sql .= " ORDER BY k.nama_kelas ASC";
    $stmt = mysqli_prepare($kon, $sql);
    if (!$stmt) {
        die("Error dalam persiapan statement: " . mysqli_error($kon));
    }

    if (!empty($cari)) {
        $search_term = "%$cari%";
        mysqli_stmt_bind_param($stmt, "s", $search_term);
    }

    // Eksekusi statement
    mysqli_stmt_execute($stmt);

    // Ambil hasil query
    $hasil = mysqli_stmt_get_result($stmt);

    if (!$hasil) {
        echo "<tr><td colspan='4' class='text-center'>Gagal mengambil data kelas</td></tr>";
    } else {
        $no = 0;
        $dataFound = false; // Variabel untuk mengecek apakah ada data yang ditemukan
        while ($data = mysqli_fetch_array($hasil)) :
            $no++;
            $dataFound = true; // Set variabel menjadi true jika ada data
            ?>
            <tr>
                <td class="text-center"><?php echo $no; ?></td>
                <td><?php echo htmlspecialchars($data['nama_kelas']); ?></td>
                <td class="text-center"><?php echo $data['jumlah_santri']; ?> Santri</td>
                <td class="text-center">
                    <button id_kelas="<?php echo $data['id_kelas']; ?>" class="tombol_edit btn btn-warning btn-sm">
                        <i class="fa fa-edit"></i>
                    </button>
                    <a href="apps/kelas/hapus.php?id_kelas=<?php echo $data['id_kelas']; ?>" class="btn-hapus-kelas btn btn-danger btn-sm">
                        <i class="fa fa-trash"></i>
                    </a>
                </td>
            </tr>
            <?php 
        endwhile;

        // Jika tidak ada data yang ditemukan, tampilkan pesan
        if (!$dataFound) {
            echo "<tr><td colspan='4' class='text-center'>Data tidak ditemukan</td></tr>";
        }
    }
    ?>
</tbody>
</table>
</div>
</div>
</div>
</div>
</div><!--/.row-->


<!-- Modal -->
<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="judul"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="tampil_data">
                <!-- Data akan dimuat di sini -->
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    // Tambah Kelas
    $('#tombol_tambah').on('click', function() {
        $.ajax({
            url: 'apps/kelas/tambah.php',
            method: 'post',
            success: function(data) {
                $('#tampil_data').html(data);
                document.getElementById("judul").innerHTML = 'Tambah Kelas';
            }
        });
        $('#modal').modal('show');
    });

    // Edit Kelas
    $('.tombol_edit').on('click', function() {
        var id_kelas = $(this).attr("id_kelas");
        $.ajax({
            url: 'apps/kelas/edit.php',
            method: 'post',
            data: {id_kelas: id_kelas},
            success: function(data) {
                $('#tampil_data').html(data);
                document.getElementById("judul").innerHTML = 'Edit Kelas';
            }
        });
        $('#modal').modal('show');
    });

    // Hapus Kelas
    $('.btn-hapus-kelas').on('click', function() {
        return confirm("Yakin menghapus kelas?");
    });
</script>
