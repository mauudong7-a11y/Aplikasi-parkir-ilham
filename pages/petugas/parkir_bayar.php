<?php
include '../../functions/auth_check.php';
check_login();
check_role(['petugas']);
include '../../config/database.php';

$id = $_GET['id'];
$query = mysqli_query($conn, "SELECT * FROM tabel_transaksi 
                              JOIN tabel_kendaraan ON tabel_transaksi.id_kendaraan = tabel_kendaraan.id_kendaraan 
                              WHERE id_transaksi = '$id'");
$data = mysqli_fetch_assoc($query);

if (!$data || $data['status'] == 'keluar') {
    echo "<script>alert('Data tidak valid!'); window.location.href='parkir_keluar.php';</script>";
    exit;
}

// Hitung Biaya
$masuk = new DateTime($data['jam_masuk']);
$keluar = new DateTime(); // Waktu saat ini (Keluar)
$diff = $keluar->diff($masuk);
$lama_parkir = $diff->h + ($diff->days * 24);
if ($diff->i > 0) $lama_parkir++;
if ($lama_parkir == 0) $lama_parkir = 1;

// Ambil tarif
$tarif_query = mysqli_query($conn, "SELECT tarif_per_jam FROM tabel_tarif WHERE id_kendaraan = '{$data['id_kendaraan']}'");
$tarif_data = mysqli_fetch_assoc($tarif_query);
$tarif_per_jam = $tarif_data ? $tarif_data['tarif_per_jam'] : 0;

$total_bayar = $lama_parkir * $tarif_per_jam;

if (isset($_POST['bayar'])) {
    $jam_keluar_db = $keluar->format('Y-m-d H:i:s');
    $update = "UPDATE tabel_transaksi SET jam_keluar = '$jam_keluar_db', lama_parkir = '$lama_parkir', total_bayar = '$total_bayar', status = 'keluar' WHERE id_transaksi = '$id'";
    
    if (mysqli_query($conn, $update)) {
        header("Location: cetak_struk.php?id=$id");
        exit;
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

include '../../includes/header.php';
include '../../includes/sidebar.php';
?>

<div class="flex-grow-1 bg-light">
    <?php include '../../includes/navbar.php'; ?>
    <div class="content">
        <h2 class="mb-4">Konfirmasi Pembayaran</h2>
        <div class="card border-0 shadow-sm col-md-6 mx-auto">
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <th>Plat Nomor</th>
                        <td>: <?= $data['plat_nomor'] ?></td>
                    </tr>
                    <tr>
                        <th>Kendaraan</th>
                        <td>: <?= $data['nama_kendaraan'] ?></td>
                    </tr>
                    <tr>
                        <th>Jam Masuk</th>
                        <td>: <?= $data['jam_masuk'] ?></td>
                    </tr>
                    <tr>
                        <th>Jam Keluar</th>
                        <td>: <?= $keluar->format('Y-m-d H:i:s') ?></td>
                    </tr>
                    <tr>
                        <th>Lama Parkir</th>
                        <td>: <?= $lama_parkir ?> Jam</td>
                    </tr>
                    <tr>
                        <th>Tarif / Jam</th>
                        <td>: Rp <?= number_format($tarif_per_jam, 0, ',', '.') ?></td>
                    </tr>
                    <tr class="table-primary">
                        <th><h3>Total Bayar</h3></th>
                        <td><h3>Rp <?= number_format($total_bayar, 0, ',', '.') ?></h3></td>
                    </tr>
                </table>
                <hr>
                <form action="" method="POST">
                    <a href="parkir_keluar.php" class="btn btn-secondary w-100 mb-2">Batal</a>
                    <button type="submit" name="bayar" class="btn btn-success w-100 btn-lg">Bayar & Cetak Struk</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include '../../includes/footer.php'; ?>
