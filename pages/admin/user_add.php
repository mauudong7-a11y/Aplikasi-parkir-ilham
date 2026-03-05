<?php
include '../../functions/auth_check.php';
check_login();
check_role(['admin']);
include '../../config/database.php';

$error = "";
$success = "";

if (isset($_POST['simpan'])) {
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = md5($_POST['password']);
    $role = $_POST['role'];

    $check = mysqli_query($conn, "SELECT * FROM tabel_users WHERE username = '$username'");
    if (mysqli_num_rows($check) > 0) {
        $error = "Username sudah digunakan!";
    } else {
        $query = "INSERT INTO tabel_users (nama_user, username, password, role) VALUES ('$nama', '$username', '$password', '$role')";
        if (mysqli_query($conn, $query)) {
            // Log Activity
            $id_admin = $_SESSION['id_user'];
            mysqli_query($conn, "INSERT INTO tabel_log_aktivitas (id_user, aktivitas) VALUES ('$id_admin', 'Menambahkan user baru: $username')");

            header("Location: user_read.php");
            exit;
        } else {
            $error = "Gagal menyimpan data: " . mysqli_error($conn);
        }
    }
}

include '../../includes/header.php';
include '../../includes/sidebar.php';
?>

<div class="flex-grow-1 bg-light">
    <?php include '../../includes/navbar.php'; ?>
    
    <div class="content">
        <h2 class="mb-4">Tambah User</h2>
        <div class="card border-0 shadow-sm" style="max-width: 600px;">
            <div class="card-body">
                <?php if($error): ?>
                    <div class="alert alert-danger"><?= $error ?></div>
                <?php endif; ?>
                
                <form action="" method="POST">
                    <div class="mb-3">
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" name="nama" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Username</label>
                        <input type="text" name="username" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Role</label>
                        <select name="role" class="form-select" required>
                            <option value="admin">Admin</option>
                            <option value="petugas">Petugas</option>
                            <option value="owner">Owner</option>
                        </select>
                    </div>
                    <a href="user_read.php" class="btn btn-secondary">Kembali</a>
                    <button type="submit" name="simpan" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include '../../includes/footer.php'; ?>
