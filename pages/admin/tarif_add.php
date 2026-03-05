<?php
include '../../functions/auth_check.php';
check_login();
check_role(['admin']);
include '../../config/database.php';

if (isset($_POST['simpan'])) {
    $id_kendaraan = $_POST['id_kendaraan'];
    $tarif = $_POST['tarif'];
    
    // Cek duplikasi
    $check = mysqli_query($conn, "SELECT * FROM tabel_tarif WHERE id_kendaraan='$id_kendaraan'");
    if(mysqli_num_rows($check) > 0) {
        echo "<script>alert('Tarif untuk kendaraan ini sudah ada!');</script>";
    } else {
        mysqli_query($conn, "INSERT INTO tabel_tarif (id_kendaraan, tarif_per_jam) VALUES ('$id_kendaraan', '$tarif')");
            // Log
        $id_admin = $_SESSION['id_user'];
        mysqli_query($conn, "INSERT INTO tabel_log_aktivitas (id_user, aktivitas) VALUES ('$id_admin', 'Menambahkan tarif baru')");

        header("Location: tarif_read.php");
        exit;
    }
}

include '../../includes/header.php';
include '../../includes/sidebar.php';
?>

<div class="flex-grow-1 bg-light">
    <?php include '../../includes/navbar.php'; ?>
    <div class="content">
        <h2 class="mb-4">Tambah Tarif</h2>
        <div class="card border-0 shadow-sm col-md-6">
            <div class="card-body">
                <form action="" method="POST">
                    <div class="mb-3">
                        <label class="form-label">Jenis Kendaraan</label>
                        <select name="id_kendaraan" class="form-select" required>
                            <?php
                            $kendaraan = mysqli_query($conn, "SELECT * FROM tabel_kendaraan");
                            while($k = mysqli_fetch_assoc($kendaraan)) {
                                echo "<option value='{$k['id_kendaraan']}'>{$k['nama_kendaraan']}</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tarif Per Jam (Rp)</label>
                        <input type="number" name="tarif" class="form-control" required>
                    </div>
                    <a href="tarif_read.php" class="btn btn-secondary">Kembali</a>
                    <button type="submit" name="simpan" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include '../../includes/footer.php'; ?>
