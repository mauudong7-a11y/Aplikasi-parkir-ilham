<?php
include '../../functions/auth_check.php';
check_login();
check_role(['admin']);
include '../../config/database.php';

$id = $_GET['id'];
$data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT nama_kendaraan FROM tabel_kendaraan WHERE id_kendaraan='$id'"));

if ($data) {
    mysqli_query($conn, "DELETE FROM tabel_kendaraan WHERE id_kendaraan='$id'");
    // Log
    $id_admin = $_SESSION['id_user'];
    mysqli_query($conn, "INSERT INTO tabel_log_aktivitas (id_user, aktivitas) VALUES ('$id_admin', 'Menghapus kendaraan: {$data['nama_kendaraan']}')");
}

header("Location: kendaraan_read.php");
exit;
?>
