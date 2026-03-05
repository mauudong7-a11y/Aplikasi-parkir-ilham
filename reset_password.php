<?php
include 'config/database.php';

$new_password = 'admin'; // Ganti dengan password yang diinginkan
$hashed_password = md5($new_password);

$query = "UPDATE tabel_users SET password = '$hashed_password' WHERE username = 'admin'";
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - Aplikasi Parkir</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { background: #f4f7f6; height: 100 vh; display: flex; align-items: center; justify-content: center; }
        .card { border: none; border-radius: 15px; box-shadow: 0 10px 30px rgba(0,0,0,0.1); }
        .success-icon { font-size: 4rem; color: #28a745; margin-bottom: 1rem; }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card text-center p-5">
                    <?php if (mysqli_query($conn, $query)): ?>
                        <div class="success-icon"><i class="fas fa-check-circle"></i></div>
                        <h2 class="fw-bold mb-3">Password Berhasil Diganti!</h2>
                        <p class="text-muted mb-4">Password untuk username <strong>admin</strong> telah berhasil direset.</p>
                        
                        <div class="bg-light p-3 rounded mb-4">
                            <p class="mb-1 small text-uppercase text-muted">Password Baru Anda:</p>
                            <h3 class="mb-0 text-primary font-monospace"><?= $new_password ?></h3>
                        </div>

                        <a href="login.php" class="btn btn-primary w-100 py-2 fw-bold mb-3">
                            <i class="fas fa-sign-in-alt me-2"></i> Ke Halaman Login
                        </a>
                        
                        <div class="alert alert-warning small mb-0">
                            <i class="fas fa-exclamation-triangle me-2"></i> <strong>KEAMANAN:</strong> Segera hapus file ini (<code>reset_password.php</code>) dari server Anda!
                        </div>
                    <?php else: ?>
                        <div class="text-danger mb-3"><i class="fas fa-times-circle fa-4x"></i></div>
                        <h2 class="fw-bold mb-2">Gagal!</h2>
                        <p class="text-muted"><?= mysqli_error($conn) ?></p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
