<?php


// Handle action edit dan hapus
if (isset($_GET['action'])) {
    $action = $_GET['action'];
    
    if ($action == 'edit' && isset($_GET['id'])) {
        include 'apps/surat/edit.php';
        exit();
    } elseif ($action == 'hapus' && isset($_GET['id'])) {
        include 'apps/surat/hapus.php';
        exit();
    } elseif ($action == 'tambah') {
        include 'apps/surat/tambah.php';
        exit();
    }
}

// Tampilkan pesan notifikasi
if (isset($_GET['update'])) {
    if ($_GET['update'] == 'berhasil') {
        echo '<div class="alert alert-success alert-dismissible fade in" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <strong>Berhasil!</strong> Data surat berhasil diupdate.
              </div>';
    } elseif ($_GET['update'] == 'gagal') {
        echo '<div class="alert alert-danger alert-dismissible fade in" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <strong>Gagal!</strong> Data surat gagal diupdate.
              </div>';
    }
}

if (isset($_GET['hapus'])) {
    if ($_GET['hapus'] == 'berhasil') {
        echo '<div class="alert alert-success alert-dismissible fade in" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <strong>Berhasil!</strong> Data surat berhasil dihapus.
              </div>';
    } elseif ($_GET['hapus'] == 'gagal') {
        echo '<div class="alert alert-danger alert-dismissible fade in" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <strong>Gagal!</strong> Data surat gagal dihapus.
              </div>';
    }
}

if (isset($_GET['error']) && $_GET['error'] == 'notfound') {
    echo '<div class="alert alert-warning alert-dismissible fade in" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <strong>Peringatan!</strong> Data surat tidak ditemukan.
          </div>';
}

if (isset($_GET['tambah'])) {
    if ($_GET['tambah'] == 'berhasil') {
        echo '<div class="alert alert-success alert-dismissible fade in" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <strong>Berhasil!</strong> Data surat berhasil ditambahkan.
              </div>';
    } elseif ($_GET['tambah'] == 'gagal') {
        echo '<div class="alert alert-danger alert-dismissible fade in" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <strong>Gagal!</strong> Data surat gagal ditambahkan.
              </div>';
    }
}
?>

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                Data Surat
                <span class="pull-right clickable panel-toggle panel-button-tab-left"><em class="fa fa-toggle-up"></em></span>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-sm-6">
                        <a href="index.php?page=surat&action=tambah" class="btn btn-success">
                            <i class="fa fa-plus"></i> Tambah Data Surat
                        </a>
                    </div>
                    <div class="col-sm-6">
                        <form action="#" method="GET">
                            <input type="hidden" name="page" value="surat"/>
                            <div class="input-group">
                                <input type="text" name="cari" id="cari" class="form-control" value="<?php echo isset($_GET['cari']) ? $_GET['cari'] : ''; ?>" placeholder="Cari Nama Surat atau Jumlah Ayat">
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-info"><i class="fa fa-search"></i> Cari</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div><!--/.row-->

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                Data Surat
            </div>
            <div class="panel-body">
                <div class="form-group">
                </div>
                <div class="table-responsive">
                    <table class="table table-striped table-hover table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead class="thead-dark text-nowrap">
                            <tr>
                                <th>No</th>
                                <th>Nama Surat</th>
                                <th>Jumlah Ayat</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            include 'config/database.php';

                // Mengamankan input pencarian dari SQL Injection
                            $cari = isset($_GET['cari']) ? trim($_GET['cari']) : '';
                            $cari = mysqli_real_escape_string($kon, $cari);

                // Query dengan pencarian
                            $sql = "SELECT * FROM tbl_surat";
                            if (!empty($cari)) {
                                $sql .= " WHERE nama_surat LIKE '%$cari%' OR jumlah_ayat LIKE '%$cari%'";
                            }

                            $hasil = mysqli_query($kon, $sql);

                // Menampilkan data jika ada
                            if (mysqli_num_rows($hasil) > 0) {
                                $no = 0;
                                while ($data = mysqli_fetch_array($hasil)) :
                                    $no++;
                                    ?>
                                    <tr>
                                        <td class="text-center"><?php echo $no; ?></td>
                                        <td><?php echo $data['nama_surat']; ?></td>
                                        <td><?php echo $data['jumlah_ayat']; ?></td>
                                        <td class="text-center">
                                            <a href="index.php?page=surat&action=edit&id=<?php echo $data['id_surat']; ?>" class="btn btn-warning btn-sm" title="Edit">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                            <a href="index.php?page=surat&action=hapus&id=<?php echo $data['id_surat']; ?>" class="btn btn-danger btn-sm" title="Hapus" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                                <i class="fa fa-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endwhile; 
                            } else { ?>
                                <tr>
                                    <td colspan="4" class="text-center text-danger">Data tidak ditemukan.</td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>
</div><!--/.row-->