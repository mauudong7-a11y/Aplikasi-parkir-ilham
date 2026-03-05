<?php
include '../../functions/auth_check.php';
check_login();
check_role(['admin']);
include '../../config/database.php';

$id = $_GET['id'];
$id_admin = $_SESSION['id_user'];
$user = mysqli_fetch_assoc(mysqli_query($conn, "SELECT username FROM tabel_users WHERE id_user='$id'"));

if ($user) {
    mysqli_query($conn, "DELETE FROM tabel_users WHERE id_user='$id'");
    mysqli_query($conn, "INSERT INTO tabel_log_aktivitas (id_user, aktivitas) VALUES ('$id_admin', 'Menghapus user: {$user['username']}')");
}

header("Location: user_read.php");
exit;
?>
