<?php
include '../../functions/auth_check.php';
check_login();
check_role(['admin']);
include '../../config/database.php';

$id = $_GET['id'];
$data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM tabel_tarif WHERE id_tarif = '$id'"));

if (isset($_POST['update'])) {
    $tarif = $_POST['tarif'];
    mysqli_query($conn, "UPDATE tabel_tarif SET tarif_per_jam='$tarif' WHERE id_tarif='$id'");
       // Log
       $id_admin = $_SESSION['id_user'];
       mysqli_query($conn, "INSERT INTO tabel_log_aktivitas (id_user, aktivitas) VALUES ('$id_admin', 'Mengedit tarif ID: $id')");

    header("Location: tarif_read.php");
    exit;
}

include '../../includes/header.php';
include '../../includes/sidebar.php';
?>

<div class="flex-grow-1 bg-light">
    <?php include '../../includes/navbar.php'; ?>
    <div class="content">
        <h2 class="mb-4">Edit Tarif</h2>
        <div class="card border-0 shadow-sm col-md-6">
            <div class="card-body">
                <form action="" method="POST">
                    <div class="mb-3">
                        <label class="form-label">Jenis Kendaraan</label>
                        <select class="form-select" disabled>
                            <?php
                            $kendaraan = mysqli_query($conn, "SELECT * FROM tabel_kendaraan WHERE id_kendaraan='{$data['id_kendaraan']}'");
                            $k = mysqli_fetch_assoc($kendaraan);
                            echo "<option selected>{$k['nama_kendaraan']}</option>";
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tarif Per Jam (Rp)</label>
                        <input type="number" name="tarif" class="form-control" value="<?= $data['tarif_per_jam'] ?>" required>
                    </div>
                    <a href="tarif_read.php" class="btn btn-secondary">Kembali</a>
                    <button type="submit" name="update" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include '../../includes/footer.php'; ?>
