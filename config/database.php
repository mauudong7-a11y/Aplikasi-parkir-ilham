<?php
// Load environment variables for Vercel/Aiven
$host = getenv('DB_HOST') ?: 'localhost';
$user = getenv('DB_USER') ?: 'root';
$pass = getenv('DB_PASSWORD') ?: '';
$db   = getenv('DB_NAME') ?: 'ilham_parkir';
$port = getenv('DB_PORT') ?: '3306';

// Initialize connection
$conn = mysqli_init();

// SSL Handle for Aiven
$ca_cert = getenv('DB_SSL_CA');
if (!empty($ca_cert)) {
    // Vercel is read-only except /tmp, write CA there if provided as string
    $ca_path = '/tmp/aiven-ca.pem';
    file_put_contents($ca_path, $ca_cert);
    mysqli_ssl_set($conn, NULL, NULL, $ca_path, NULL, NULL);
}

// Connect
if (!mysqli_real_connect($conn, $host, $user, $pass, $db, $port)) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}
?>
