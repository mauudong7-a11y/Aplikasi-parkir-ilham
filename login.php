<?php
session_start();
include 'config/database.php';

if (isset($_SESSION['login']) && $_SESSION['login'] === true) {
    echo "<script>window.location.href='index.php';</script>";
    exit;
}

$error = "";

if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = md5($_POST['password']);

    $query = "SELECT * FROM tabel_users WHERE username = '$username' AND password = '$password'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);
        $_SESSION['login'] = true;
        $_SESSION['id_user'] = $row['id_user'];
        $_SESSION['nama_user'] = $row['nama_user'];
        $_SESSION['role'] = $row['role'];

        // Redirect based on role
        if ($row['role'] == 'admin') {
            header("Location: index.php");
        } elseif ($row['role'] == 'petugas') {
            header("Location: index.php");
        } elseif ($row['role'] == 'owner') {
            header("Location: index.php");
        }
        exit;
    } else {
        $error = "Username atau password salah!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Aplikasi Parkir</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/style.css" rel="stylesheet">
</head>
<body>

<div class="running-text">
    <p>Selamat datang di Aplikasi Kasir Parkir - Silahkan Login untuk melanjutkan</p>
</div>

<div class="container">
    <div class="login-container">
        <h3 class="text-center mb-4">Login</h3>
        <?php if($error): ?>
            <div class="alert alert-danger"><?= $error ?></div>
        <?php endif; ?>
        <form method="POST" action="">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" name="login" class="btn btn-primary w-100">Login</button>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
