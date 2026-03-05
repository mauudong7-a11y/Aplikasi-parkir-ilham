<?php
include '../../functions/auth_check.php';
check_login();
check_role(['petugas']);
include '../../config/database.php';
include '../../includes/header.php';
include '../../includes/sidebar.php';
?>

<div class="flex-grow-1 bg-light">
    <?php include '../../includes/navbar.php'; ?>
    
    <div class="content">
        <h2 class="mb-4">Parkir Keluar / Pembayaran</h2>
        
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <!-- Search -->
                <form action="" method="GET" class="mb-3">
                    <div class="input-group">
                        <input type="text" name="q" class="form-control" placeholder="Cari Plat Nomor..." value="<?= isset($_GET['q']) ? $_GET['q'] : '' ?>">
                        <button class="btn btn-primary" type="submit">Cari</button>
                    </div>
                </form>

                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>No Polisi</th>
                            <th>Kendaraan</th>
                            <th>Masuk</th>
                            <th>Durasi (Jam)</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $where = "WHERE status = 'masuk'";
                        if (isset($_GET['q']) && !empty($_GET['q'])) {
                            $q = mysqli_real_escape_string($conn, $_GET['q']);
                            $where .= " AND plat_nomor LIKE '%$q%'";
                        }

                        $query = mysqli_query($conn, "SELECT * FROM tabel_transaksi 
                                                      JOIN tabel_kendaraan ON tabel_transaksi.id_kendaraan = tabel_kendaraan.id_kendaraan 
                                                      $where ORDER BY jam_masuk ASC");
                        
                        if(mysqli_num_rows($query) == 0): ?>
                            <tr><td colspan="5" class="text-center">Tidak ada kendaraan parkir.</td></tr>
                        <?php else:
                            while ($row = mysqli_fetch_assoc($query)) {
                                $masuk = new DateTime($row['jam_masuk']);
                                $now = new DateTime();
                                $diff = $now->diff($masuk);
                                $jam = $diff->h + ($diff->days * 24);
                                if ($diff->i > 0) $jam++; // Pembulatan ke atas per jam
                                if ($jam == 0) $jam = 1; // Minimal 1 jam
                        ?>
                        <tr>
                            <td class="fw-bold"><?= $row['plat_nomor'] ?></td>
                            <td><?= $row['nama_kendaraan'] ?></td>
                            <td><?= date('H:i d/m/Y', strtotime($row['jam_masuk'])) ?></td>
                            <td><?= $jam ?> Jam</td>
                            <td>
                                <a href="parkir_bayar.php?id=<?= $row['id_transaksi'] ?>" class="btn btn-success btn-sm"><i class="fas fa-money-bill-wave"></i> Bayar / Keluar</a>
                            </td>
                        </tr>
                        <?php } endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include '../../includes/footer.php'; ?>
