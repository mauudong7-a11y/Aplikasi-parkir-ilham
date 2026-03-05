<?php
include '../../functions/auth_check.php';
check_login();
// Allow Owner AND Admin to view reports if needed, but per soal UKK usually Owner
if ($_SESSION['role'] != 'owner' && $_SESSION['role'] != 'admin') {
    check_role(['owner']);
}
include '../../config/database.php';
include '../../includes/header.php';
include '../../includes/sidebar.php';

$tgl_awal = isset($_GET['tgl_awal']) ? $_GET['tgl_awal'] : date('Y-m-d');
$tgl_akhir = isset($_GET['tgl_akhir']) ? $_GET['tgl_akhir'] : date('Y-m-d');

$query_sql = "SELECT * FROM tabel_transaksi 
              JOIN tabel_kendaraan ON tabel_transaksi.id_kendaraan = tabel_kendaraan.id_kendaraan 
              JOIN tabel_userS ON tabel_transaksi.id_user = tabel_users.id_user 
              WHERE status='keluar' AND DATE(tanggal_transaksi) BETWEEN '$tgl_awal' AND '$tgl_akhir'";

$query = mysqli_query($conn, $query_sql);
?>

<div class="flex-grow-1 bg-light">
    <?php include '../../includes/navbar.php'; ?>
    
    <div class="content">
        <h2 class="mb-4">Laporan Transaksi</h2>
        
        <div class="card border-0 shadow-sm mb-4 no-print">
            <div class="card-body">
                <form action="" method="GET" class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Tanggal Awal</label>
                        <input type="date" name="tgl_awal" class="form-control" value="<?= $tgl_awal ?>">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Tanggal Akhir</label>
                        <input type="date" name="tgl_akhir" class="form-control" value="<?= $tgl_akhir ?>">
                    </div>
                    <div class="col-md-4 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary w-100 me-2">Tampilkan</button>
                        <button type="button" onclick="window.print()" class="btn btn-success w-100">Cetak</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-body">
                 <div class="d-none d-print-block text-center mb-4">
                    <h3>LAPORAN PENDAPATAN PARKIR</h3>
                    <p>Periode: <?= date('d/m/Y', strtotime($tgl_awal)) ?> s/d <?= date('d/m/Y', strtotime($tgl_akhir)) ?></p>
                 </div>

                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>No. Tiket/Polisi</th>
                            <th>Jenis Kendaraan</th>
                            <th>Waktu Masuk</th>
                            <th>Waktu Keluar</th>
                            <th>Lama</th>
                            <th>Total Bayar</th>
                            <th>Petugas</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        $total_pendapatan = 0;
                        while ($row = mysqli_fetch_assoc($query)) {
                            $total_pendapatan += $row['total_bayar'];
                        ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $row['plat_nomor'] ?></td>
                            <td><?= $row['nama_kendaraan'] ?></td>
                            <td><?= $row['jam_masuk'] ?></td>
                            <td><?= $row['jam_keluar'] ?></td>
                            <td><?= $row['lama_parkir'] ?> Jam</td>
                            <td class="text-end">Rp <?= number_format($row['total_bayar'], 0, ',', '.') ?></td>
                            <td><?= $row['nama_user'] ?></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                    <tfoot>
                        <tr class="table-dark">
                            <td colspan="6" class="text-center fw-bold">TOTAL PENDAPATAN</td>
                            <td class="text-end fw-bold">Rp <?= number_format($total_pendapatan, 0, ',', '.') ?></td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
    @media print {
        .sidebar, .navbar, .no-print, .btn, footer {
            display: none !important;
        }
        .content {
            margin: 0;
            padding: 0;
        }
        .card {
            border: none !important;
            box-shadow: none !important;
        }
    }
</style>

<?php include '../../includes/footer.php'; ?>
