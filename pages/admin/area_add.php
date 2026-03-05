<?php
include '../../functions/auth_check.php';
check_login();
check_role(['admin']);
include '../../config/database.php';

if (isset($_POST['simpan'])) {
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $kapasitas = (int)$_POST['kapasitas'];
    mysqli_query($conn, "INSERT INTO tabel_area_parkir (nama_area, kapasitas) VALUES ('$nama', '$kapasitas')");
    
    // Log
    $id_admin = $_SESSION['id_user'];
    mysqli_query($conn, "INSERT INTO tabel_log_aktivitas (id_user, aktivitas) VALUES ('$id_admin', 'Menambahkan area: $nama')");
    
    header("Location: area_read.php");
    exit;
}

include '../../includes/header.php';
include '../../includes/sidebar.php';
?>

<div class="flex-grow-1 bg-light">
    <?php include '../../includes/navbar.php'; ?>
    <div class="content">
        <h2 class="mb-4">Tambah Area Parkir</h2>
        <div class="card border-0 shadow-sm col-md-6">
            <div class="card-body">
                <form action="" method="POST">
                    <div class="mb-3">
                        <label class="form-label">Nama Area</label>
                        <input type="text" name="nama" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Kapasitas</label>
                        <input type="number" name="kapasitas" class="form-control" required>
                    </div>
                    <a href="area_read.php" class="btn btn-secondary">Kembali</a>
                    <button type="submit" name="simpan" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include '../../includes/footer.php'; ?>
