<?php
include '../../functions/auth_check.php';
check_login();
check_role(['admin']);
include '../../config/database.php';

$id = $_GET['id'];
$data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM tabel_users WHERE id_user = '$id'"));

if (!$data) {
    header("Location: user_read.php");
    exit;
}

$error = "";

if (isset($_POST['update'])) {
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $role = $_POST['role'];
    $password_query = "";

    if (!empty($_POST['password'])) {
        $password = md5($_POST['password']);
        $password_query = ", password='$password'";
    }

    $query = "UPDATE tabel_users SET nama_user='$nama', role='$role' $password_query WHERE id_user='$id'";
    
    if (mysqli_query($conn, $query)) {
         // Log Activity
         $id_admin = $_SESSION['id_user'];
         mysqli_query($conn, "INSERT INTO tabel_log_aktivitas (id_user, aktivitas) VALUES ('$id_admin', 'Mengedit user: {$data['username']}')");

        header("Location: user_read.php");
        exit;
    } else {
        $error = "Gagal update data: " . mysqli_error($conn);
    }
}

include '../../includes/header.php';
include '../../includes/sidebar.php';
?>

<div class="flex-grow-1 bg-light">
    <?php include '../../includes/navbar.php'; ?>
    
    <div class="content">
        <h2 class="mb-4">Edit User</h2>
        <div class="card border-0 shadow-sm" style="max-width: 600px;">
            <div class="card-body">
                <?php if($error): ?>
                    <div class="alert alert-danger"><?= $error ?></div>
                <?php endif; ?>
                
                <form action="" method="POST">
                    <div class="mb-3">
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" name="nama" class="form-control" value="<?= $data['nama_user'] ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Username</label>
                        <input type="text" class="form-control" value="<?= $data['username'] ?>" disabled>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password (Kosongkan jika tidak diganti)</label>
                        <input type="password" name="password" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Role</label>
                        <select name="role" class="form-select" required>
                            <option value="admin" <?= $data['role'] == 'admin' ? 'selected' : '' ?>>Admin</option>
                            <option value="petugas" <?= $data['role'] == 'petugas' ? 'selected' : '' ?>>Petugas</option>
                            <option value="owner" <?= $data['role'] == 'owner' ? 'selected' : '' ?>>Owner</option>
                        </select>
                    </div>
                    <a href="user_read.php" class="btn btn-secondary">Kembali</a>
                    <button type="submit" name="update" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include '../../includes/footer.php'; ?>
