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
                Data Santri
            </div>
            <div class="panel-body">
                <div class="row">
                    <form action="#" method="GET">
                        <input type="hidden" name="page" value="santri"/>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <input type="text" name="cari" id="cari" class="form-control" value="<?php echo isset($_GET['cari']) ? $_GET['cari'] : ''; ?>" placeholder="Pencarian">
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <select name="kelas" id="kelas" class="form-control">
                                    <option value="">-- Semua Kelas --</option>
                                    <?php
                                    // Ambil data kelas dari database
                                    include 'config/database.php';
                                    $sql_kelas = "SELECT * FROM tbl_kelas ORDER BY nama_kelas ASC"; // Urutkan kelas berdasarkan nama
                                    $hasil_kelas = mysqli_query($kon, $sql_kelas);
                                    while ($row_kelas = mysqli_fetch_assoc($hasil_kelas)) {
                                        $selected = (isset($_GET['kelas']) && $_GET['kelas'] == $row_kelas['id_kelas']) ? 'selected' : '';
                                        echo "<option value='{$row_kelas['id_kelas']}' $selected>{$row_kelas['nama_kelas']}</option>";
                                    }
                                    ?>
                                </select>
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
                // Validasi untuk menampilkan pesan pemberitahuan saat user menambah admin
                if (isset($_GET['add'])) {
                    if ($_GET['add'] == 'berhasil') {
                        echo "<div class='alert alert-success'><strong>Berhasil!</strong> Data Santri Telah Disimpan</div>";
                    } else if ($_GET['add'] == 'gagal') {
                        echo "<div class='alert alert-danger'><strong>Gagal!</strong> Data Santri Gagal Disimpan</div>";
                    }
                }

                // Validasi untuk menampilkan pesan pemberitahuan saat user mengedit admin
                if (isset($_GET['edit'])) {
                    if ($_GET['edit'] == 'berhasil') {
                        echo "<div class='alert alert-success'><strong>Berhasil!</strong> Data Santri Telah Diupdate</div>";
                    } else if ($_GET['edit'] == 'gagal') {
                        echo "<div class='alert alert-danger'><strong>Gagal!</strong> Data Santri Gagal Diupdate</div>";
                    }
                }

                // Validasi untuk menampilkan pesan pemberitahuan saat user menghapus admin
                if (isset($_GET['pengguna'])) {
                    if ($_GET['pengguna'] == 'berhasil') {
                        echo "<div class='alert alert-success'><strong>Berhasil!</strong> Setting Data Santri Berhasil</div>";
                    } else if ($_GET['pengguna'] == 'gagal') {
                        echo "<div class='alert alert-danger'><strong>Gagal!</strong> Setting Data Santri Gagal</div>";
                    }
                }

                // Validasi untuk menampilkan pesan pemberitahuan saat user menghapus admin
                if (isset($_GET['hapus'])) {
                    if ($_GET['hapus'] == 'berhasil') {
                        echo "<div class='alert alert-success'><strong>Berhasil!</strong> Data Santri Telah Dihapus</div>";
                    } else if ($_GET['hapus'] == 'gagal') {
                        echo "<div class='alert alert-danger'><strong>Gagal!</strong> Data Santri Gagal Dihapus</div>";
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
                                <th>NIS</th>
                                <th>Nama</th>
                                <th>Kelas</th>
                                <th>Nama Ortu</th>
                                <th>Foto</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                         
                            <?php
                            include 'config/database.php';

                            $cari = isset($_GET['cari']) ? trim($_GET['cari']) : '';
                            $kelas = isset($_GET['kelas']) ? $_GET['kelas'] : '';

                            $sql = "SELECT ts.*, tk.nama_kelas FROM tbl_santri ts 
                            LEFT JOIN tbl_kelas tk ON ts.id_kelas = tk.id_kelas 
                            WHERE 1=1";
                            if (!empty($cari)) {
                                $sql .= " AND (ts.nama_santri LIKE '%$cari%' OR ts.nis LIKE '%$cari%')";
                            }
                            if (!empty($kelas)) {
                                $sql .= " AND ts.id_kelas = '$kelas'";
                            }
                            $sql .= " ORDER BY ts.nama_santri ASC";
                            $hasil = mysqli_query($kon, $sql);

                            if (!$hasil) {
                                echo "<tr><td colspan='7' class='text-center'>Gagal mengambil data santri</td></tr>";
                            } else {
                                $no = 0;
        $dataFound = false; // Variabel untuk mengecek apakah ada data yang ditemukan
        while ($data = mysqli_fetch_array($hasil)) :
            $no++;
            $dataFound = true; // Set variabel menjadi true jika ada data
            ?>
            <tr>
                <td class="text-center"><?php echo $no; ?></td>
                <td><?php echo htmlspecialchars($data['nis']); ?></td>
                <td><?php echo htmlspecialchars($data['nama_santri']); ?></td>
                <td><?php echo htmlspecialchars($data['nama_kelas']); ?></td>
                <td><?php echo htmlspecialchars($data['nama_ortu']); ?></td>
                <td class="text-center">
                    <img src="apps/santri/foto/<?php echo htmlspecialchars($data['foto']); ?>" width="80" class="img-thumbnail">
                </td>
                <td class="text-center text-nowrap">
                    <button id_santri="<?php echo $data['id_santri']; ?>" class="tombol_detail btn btn-success btn-circle btn-sm">
                        <i class="fa fa-eye"></i>
                    </button>
                    
                    <button id_santri="<?php echo $data['id_santri']; ?>" class="tombol_edit btn btn-warning btn-circle btn-sm">
                        <i class="fa fa-edit"></i>
                    </button>
                    <a href="apps/santri/hapus.php?id_santri=<?php echo $data['id_santri']; ?>&kode_santri=<?php echo $data['kode_santri']; ?>" class="btn-hapus-santri btn btn-danger btn-circle btn-sm">
                        <i class="fa fa-trash"></i>
                    </a>
                </td>
            </tr>
        <?php endwhile; ?>

        <?php
        // Jika tidak ada data yang ditemukan, tampilkan pesan
        if (!$dataFound) {
            echo "<tr><td colspan='7' class='text-center'>Data tidak ditemukan</td></tr>";
        }
        ?>
    <?php } ?>
</tbody>
</table>
</div>

</div>
</div>
</div>
</div><!--/.row-->

<!-- Modal -->
<div class="modal fade" id="modal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="judul"></h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div id="tampil_data"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Data akan di load menggunakan AJAX -->
<script>
    // Tambah admin
    $('#tombol_tambah').on('click', function () {
        $.ajax({
            url: 'apps/santri/tambah.php',
            method: 'post',
            success: function (data) {
                $('#tampil_data').html(data);
                document.getElementById("judul").innerHTML = 'Tambah Santri';
            }
        });
        // Membuka modal
        $('#modal').modal('show');
    });

    // Detail Santri
    $('.tombol_detail').on('click', function () {
        var id_santri = $(this).attr("id_santri");
        $.ajax({
            url: 'apps/santri/detail.php',
            method: 'post',
            data: { id_santri: id_santri },
            success: function (data) {
                $('#tampil_data').html(data);
                document.getElementById("judul").innerHTML = 'Detail Santri';
            }
        });
        // Membuka modal
        $('#modal').modal('show');
    });

    // Setting Santri
    $('.tombol_setting').on('click', function () {
        var kode_santri = $(this).attr("kode_santri");
        $.ajax({
            url: 'apps/santri/pengguna.php',
            method: 'post',
            data: { kode_santri: kode_santri },
            success: function (data) {
                $('#tampil_data').html(data);
                document.getElementById("judul").innerHTML = 'Setting Santri';
            }
        });
        // Membuka modal
        $('#modal').modal('show');
    });

    // Edit Santri
    $('.tombol_edit').on('click', function () {
        var id_santri = $(this).attr("id_santri");
        $.ajax({
            url: 'apps/santri/edit.php',
            method: 'post',
            data: { id_santri: id_santri },
            success: function (data) {
                $('#tampil_data').html(data);
                document.getElementById("judul").innerHTML = 'Edit Santri';
            }
        });
        // Membuka modal
        $('#modal').modal('show');
    });

    // Hapus admin
    $('.btn-hapus-santri').on('click', function () {
        konfirmasi = confirm("Konfirmasi Sebelum Menghapus Santri?")
        if (konfirmasi) {
            return true;
        } else {
            return false;
        }
    });
</script>