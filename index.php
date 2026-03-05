<?php
include 'functions/auth_check.php';
check_login('login.php');
include 'config/database.php';
?>

<?php include 'includes/header.php'; ?>
<?php include 'includes/sidebar.php'; ?>

<div class="flex-grow-1 bg-light">
    <?php include 'includes/navbar.php'; ?>
    
    <div class="content">
        <h2>Dashboard</h2>
        <p>Halo <strong><?= $_SESSION['nama_user'] ?></strong>, selamat datang di sistem Aplikasi Kasir Parkir.</p>
        
        <div class="row mt-4">
            <?php if($_SESSION['role'] == 'admin'): 
                $user_count = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM tabel_users"));
                $kendaraan_count = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM tabel_kendaraan"));
            ?>
                <div class="col-md-3">
                    <div class="card text-white bg-primary mb-3">
                        <div class="card-body">
                            <h5 class="card-title">Total User</h5>
                            <p class="card-text display-4"><?= $user_count ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card text-white bg-success mb-3">
                        <div class="card-body">
                            <h5 class="card-title">Jenis Kendaraan</h5>
                            <p class="card-text display-4"><?= $kendaraan_count ?></p>
                        </div>
                    </div>
                </div>

            <?php elseif($_SESSION['role'] == 'petugas'): 
                $parkir_aktif = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM tabel_transaksi WHERE status='masuk'"));
            ?>
                <div class="col-md-4">
                    <div class="card text-white bg-info mb-3">
                        <div class="card-body">
                            <h5 class="card-title">Kendaraan Parkir</h5>
                            <p class="card-text display-4"><?= $parkir_aktif ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <a href="pages/petugas/parkir_masuk.php" class="btn btn-primary btn-lg w-100 h-100 d-flex align-items-center justify-content-center">
                        <i class="fas fa-sign-in-alt fa-2x me-2"></i> Parkir Masuk
                    </a>
                </div>
                <div class="col-md-4">
                    <a href="pages/petugas/parkir_keluar.php" class="btn btn-danger btn-lg w-100 h-100 d-flex align-items-center justify-content-center">
                        <i class="fas fa-sign-out-alt fa-2x me-2"></i> Parkir Keluar
                    </a>
                </div>
            
            <?php elseif($_SESSION['role'] == 'owner'): 
                 $today = date('Y-m-d');
                 $income = mysqli_fetch_assoc(mysqli_query($conn, "SELECT SUM(total_bayar) as total FROM tabel_transaksi WHERE DATE(tanggal_transaksi) = '$today'"));
            ?>
                <div class="col-md-4">
                    <div class="card text-white bg-success mb-3">
                        <div class="card-body">
                            <h5 class="card-title">Pendapatan Hari Ini</h5>
                            <p class="card-text display-6">Rp <?= number_format($income['total'] ?? 0, 0, ',', '.') ?></p>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
