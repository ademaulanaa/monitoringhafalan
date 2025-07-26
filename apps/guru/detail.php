<?php 
    include '../../config/database.php';
    
    // Ambil id_guru dari POST request
    $id_guru = $_POST["id_guru"];
    
    // Query untuk mengambil data guru berdasarkan id_guru
    $sql = "SELECT * FROM tbl_guru WHERE id_guru = $id_guru LIMIT 1";
    $hasil = mysqli_query($kon, $sql);
    $data = mysqli_fetch_array($hasil); 
?>

<!-- Tabel untuk Menampilkan Data Guru -->
<table class="table">
    <tbody>
        <tr>
            <td>Nama Lengkap</td>
            <td width="75%">: <?php echo $data['nama_guru']; ?></td>
        </tr>
        <tr>
            <td>Nomor Induk Pegawai (NIP)</td>
            <td width="75%">: <?php echo $data['nip']; ?></td>
        </tr>
        <tr>
            <td>Email</td>
            <td width="75%">: <?php echo $data['email']; ?></td>
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