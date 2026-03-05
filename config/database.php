<?php
$host = 'localhost';
$user = 'root'; 
$pass = ''; 
$db   = 'ilham_parkir';

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}
?>
