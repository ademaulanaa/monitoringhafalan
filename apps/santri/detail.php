<?php
include '../../config/database.php';

$id_santri = $_POST["id_santri"];

$sql = "SELECT tbl_santri.*, tbl_kelas.nama_kelas 
        FROM tbl_santri
        LEFT JOIN tbl_kelas ON tbl_santri.id_kelas = tbl_kelas.id_kelas
        WHERE tbl_santri.id_santri = $id_santri LIMIT 1";

$hasil = mysqli_query($kon, $sql);
$data = mysqli_fetch_array($hasil);
?>


<table class="table">
    <tbody>
        <tr>
            <td>Nama Lengkap</td>
            <td width="75%">: <?php echo $data['nama_santri']; ?></td>
        </tr>
        <tr>
            <td>Nomor Induk Santri</td>
            <td width="75%">: <?php echo $data['nis']; ?></td>
        </tr>
        <tr>
            <td>Kelas</td>
            <td width="75%">: <?php echo $data['nama_kelas']; ?></td>
        </tr>
        <tr>
            <td>Nama Ortu</td>
            <td width="75%">: <?php echo $data['nama_ortu']; ?></td>
        </tr>
        <tr>
            <td>No Telp</td>
            <td width="75%">: <?php echo $data['no_telp']; ?></td>
        </tr>
        <tr>
            <td>Alamat</td>
            <td width="75%">: <?php echo $data['alamat']; ?></td>
        </tr>
    </tbody>
</table>