<?php
include '../../functions/auth_check.php';
check_login();
check_role(['admin']);
include '../../config/database.php';

if (isset($_POST['simpan'])) {
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    mysqli_query($conn, "INSERT INTO tabel_kendaraan (nama_kendaraan) VALUES ('$nama')");
    
    // Log
    $id_admin = $_SESSION['id_user'];
    mysqli_query($conn, "INSERT INTO tabel_log_aktivitas (id_user, aktivitas) VALUES ('$id_admin', 'Menambahkan kendaraan: $nama')");
    
    header("Location: kendaraan_read.php");
    exit;
}

include '../../includes/header.php';
include '../../includes/sidebar.php';
?>

<div class="flex-grow-1 bg-light">
    <?php include '../../includes/navbar.php'; ?>
    <div class="content">
        <h2 class="mb-4">Tambah Kendaraan</h2>
        <div class="card border-0 shadow-sm col-md-6">
            <div class="card-body">
                <form action="" method="POST">
                    <div class="mb-3">
                        <label class="form-label">Nama Kendaraan</label>
                        <input type="text" name="nama" class="form-control" required>
                    </div>
                    <a href="kendaraan_read.php" class="btn btn-secondary">Kembali</a>
                    <button type="submit" name="simpan" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include '../../includes/footer.php'; ?>
