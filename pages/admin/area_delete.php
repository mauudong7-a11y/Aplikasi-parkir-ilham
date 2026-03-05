<?php
include '../../functions/auth_check.php';
check_login();
check_role(['admin']);
include '../../config/database.php';

$id = $_GET['id'];
$data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT nama_area FROM tabel_area_parkir WHERE id_area='$id'"));

if ($data) {
    $delete = mysqli_query($conn, "DELETE FROM tabel_area_parkir WHERE id_area='$id'");
    
    if ($delete) {
        // Log
        $id_admin = $_SESSION['id_user'];
        mysqli_query($conn, "INSERT INTO tabel_log_aktivitas (id_user, aktivitas) VALUES ('$id_admin', 'Menghapus area: {$data['nama_area']}')");
        header("Location: area_read.php?status=deleted");
    } else {
        // Check if error is due to foreign key
        if (mysqli_errno($conn) == 1451) {
            echo "<script>alert('Gagal menghapus! Area ini masih memiliki data transaksi.'); window.location.href='area_read.php';</script>";
        } else {
            echo "<script>alert('Gagal menghapus: " . mysqli_error($conn) . "'); window.location.href='area_read.php';</script>";
        }
        exit;
    }
} else {
    header("Location: area_read.php");
}
exit;

?>
