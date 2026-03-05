<?php
include '../functions/auth_check.php';
check_login();
include '../config/database.php';

$error = "";
$success = "";

if (isset($_POST['change_password'])) {
    $id_user = $_SESSION['id_user'];
    $old_password = md5($_POST['old_password']);
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Check old password
    $user_query = mysqli_query($conn, "SELECT password FROM tabel_users WHERE id_user = '$id_user'");
    $user_data = mysqli_fetch_assoc($user_query);

    if ($old_password !== $user_data['password']) {
        $error = "Password lama salah!";
    } elseif ($new_password !== $confirm_password) {
        $error = "Konfirmasi password baru tidak cocok!";
    } elseif (strlen($new_password) < 5) {
        $error = "Password baru minimal 5 karakter!";
    } else {
        $hashed_password = md5($new_password);
        $update_query = "UPDATE tabel_users SET password = '$hashed_password' WHERE id_user = '$id_user'";
        
        if (mysqli_query($conn, $update_query)) {
            $success = "Password berhasil diperbarui!";
            // Log Activity
            mysqli_query($conn, "INSERT INTO tabel_log_aktivitas (id_user, aktivitas) VALUES ('$id_user', 'Mengganti password sendiri')");
        } else {
            $error = "Gagal memperbarui password: " . mysqli_error($conn);
        }
    }
}

include '../includes/header.php';
include '../includes/sidebar.php';
?>

<div class="flex-grow-1 bg-light">
    <?php include '../includes/navbar.php'; ?>
    
    <div class="content">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Ganti Password</h2>
        </div>

        <div class="card border-0 shadow-sm" style="max-width: 500px;">
            <div class="card-body p-4">
                <?php if($error): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <?= $error ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <?php if($success): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <?= $success ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <form action="" method="POST">
                    <div class="mb-3">
                        <label class="form-label">Password Lama</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="fas fa-lock text-muted"></i></span>
                            <input type="password" name="old_password" class="form-control border-start-0 ps-0" placeholder="Masukkan password saat ini" required>
                        </div>
                    </div>
                    <hr class="my-4">
                    <div class="mb-3">
                        <label class="form-label">Password Baru</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="fas fa-key text-muted"></i></span>
                            <input type="password" name="new_password" class="form-control border-start-0 ps-0" placeholder="Masukkan password baru" required>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Konfirmasi Password Baru</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="fas fa-check-circle text-muted"></i></span>
                            <input type="password" name="confirm_password" class="form-control border-start-0 ps-0" placeholder="Ulangi password baru" required>
                        </div>
                    </div>
                    <div class="d-grid">
                        <button type="submit" name="change_password" class="btn btn-primary py-2 fw-bold">
                            <i class="fas fa-save me-2"></i> Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
