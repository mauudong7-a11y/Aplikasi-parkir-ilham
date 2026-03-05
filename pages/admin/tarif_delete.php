<?php
include '../../functions/auth_check.php';
check_login();
check_role(['admin']);
include '../../config/database.php';

$id = $_GET['id'];
$id_admin = $_SESSION['id_user'];

if ($id) {
    mysqli_query($conn, "DELETE FROM tabel_tarif WHERE id_tarif='$id'");
    mysqli_query($conn, "INSERT INTO tabel_log_aktivitas (id_user, aktivitas) VALUES ('$id_admin', 'Menghapus tarif ID: $id')");
}

header("Location: tarif_read.php");
exit;
?>
