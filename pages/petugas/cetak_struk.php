<?php
include '../../functions/auth_check.php';
check_login();
include '../../config/database.php';

$id = $_GET['id'];
$query = mysqli_query($conn, "SELECT * FROM tabel_transaksi 
                              JOIN tabel_kendaraan ON tabel_transaksi.id_kendaraan = tabel_kendaraan.id_kendaraan 
                              JOIN tabel_users ON tabel_transaksi.id_user = tabel_users.id_user
                              WHERE id_transaksi = '$id'");
$data = mysqli_fetch_assoc($query);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Struk Parkir</title>
    <style>
        body { font-family: monospace; width: 300px; margin: 20px auto; border: 1px solid #ddd; padding: 20px; }
        .text-center { text-align: center; }
        .line { border-bottom: 1px dashed black; margin: 10px 0; }
        @media print {
            body { border: none; margin: 0; }
            .btn-print { display: none; }
        }
    </style>
</head>
<body onload="window.print()">
    <div class="text-center">
        <h3>E-PARKING</h3>
        <p>Jl. Contoh No. 123</p>
    </div>
    <div class="line"></div>
    <table>
        <tr><td>No. Transaksi</td><td>: <?= $data['id_transaksi'] ?></td></tr>
        <tr><td>Plat Nomor</td><td>: <?= $data['plat_nomor'] ?></td></tr>
        <tr><td>Kendaraan</td><td>: <?= $data['nama_kendaraan'] ?></td></tr>
        <tr><td>Masuk</td><td>: <?= $data['jam_masuk'] ?></td></tr>
        <tr><td>Keluar</td><td>: <?= $data['jam_keluar'] ?></td></tr>
        <tr><td>Lama</td><td>: <?= $data['lama_parkir'] ?> Jam</td></tr>
        <tr><td>Kasir</td><td>: <?= $data['nama_user'] ?></td></tr>
    </table>
    <div class="line"></div>
    <div class="text-center">
        <h3>Rp <?= number_format($data['total_bayar'], 0, ',', '.') ?></h3>
        <p>Terima Kasih</p>
    </div>
    <div class="btn-print text-center mt-4">
        <a href="parkir_keluar.php">Kembali</a>
    </div>
</body>
</html>
