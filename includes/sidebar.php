<?php
$current_page = basename($_SERVER['PHP_SELF']);
$in_sub = (strpos($_SERVER['PHP_SELF'], '/pages/') !== false);
$prefix = $in_sub ? '../../' : '';
?>
<div class="sidebar p-3" style="width: 250px;">
    <h4 class="text-center mb-4">E-Parking</h4>
    <hr>
    <a href="<?= $prefix ?>index.php" class="<?= $current_page == 'index.php' ? 'active' : '' ?>">
        <i class="fas fa-tachometer-alt me-2"></i> Dashboard
    </a>

    <?php if($_SESSION['role'] == 'admin'): ?>
        <small class="text-muted ms-2 mt-2 d-block text-uppercase" style="font-size:0.75rem">Master Data</small>
        <a href="<?= $prefix ?>pages/admin/user_read.php" class="<?= $current_page == 'user_read.php' ? 'active' : '' ?>">
            <i class="fas fa-users me-2"></i> Kelola User
        </a>
        <a href="<?= $prefix ?>pages/admin/kendaraan_read.php" class="<?= $current_page == 'kendaraan_read.php' ? 'active' : '' ?>">
            <i class="fas fa-car me-2"></i> Kelola Kendaraan
        </a>
        <a href="<?= $prefix ?>pages/admin/area_read.php" class="<?= $current_page == 'area_read.php' ? 'active' : '' ?>">
            <i class="fas fa-map-marker-alt me-2"></i> Area Parkir
        </a>
        <a href="<?= $prefix ?>pages/admin/tarif_read.php" class="<?= $current_page == 'tarif_read.php' ? 'active' : '' ?>">
            <i class="fas fa-tags me-2"></i> Tarif Parkir
        </a>
        <small class="text-muted ms-2 mt-2 d-block text-uppercase" style="font-size:0.75rem">Laporan</small>
        <a href="<?= $prefix ?>pages/admin/logs.php" class="<?= $current_page == 'logs.php' ? 'active' : '' ?>">
            <i class="fas fa-history me-2"></i> Log Aktivitas
        </a>
    
    <?php elseif($_SESSION['role'] == 'petugas'): ?>
        <small class="text-muted ms-2 mt-2 d-block text-uppercase" style="font-size:0.75rem">Transaksi</small>
        <a href="<?= $prefix ?>pages/petugas/parkir_masuk.php" class="<?= $current_page == 'parkir_masuk.php' ? 'active' : '' ?>">
            <i class="fas fa-sign-in-alt me-2"></i> Parkir Masuk
        </a>
        <a href="<?= $prefix ?>pages/petugas/parkir_keluar.php" class="<?= $current_page == 'parkir_keluar.php' ? 'active' : '' ?>">
            <i class="fas fa-sign-out-alt me-2"></i> Parkir Keluar
        </a>
    
    <?php elseif($_SESSION['role'] == 'owner'): ?>
        <small class="text-muted ms-2 mt-2 d-block text-uppercase" style="font-size:0.75rem">Laporan</small>
        <a href="<?= $prefix ?>pages/owner/laporan.php" class="<?= $current_page == 'laporan.php' ? 'active' : '' ?>">
            <i class="fas fa-chart-line me-2"></i> Laporan Pendapatan
        </a>
    <?php endif; ?>

    <a href="<?= $prefix ?>pages/change_password.php" class="<?= $current_page == 'change_password.php' ? 'active' : '' ?>">
        <i class="fas fa-user-shield me-2"></i> Ganti Password
    </a>
    <hr>
    <a href="<?= $prefix ?>logout.php" class="text-danger"><i class="fas fa-sign-out-alt me-2"></i> Logout</a>
</div>

