<?php
session_start();

// Function to check if user is logged in
// $path_to_login: relative path to login.php from the calling script
function check_login($path_to_login = '../../login.php') {
    if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
        header("Location: " . $path_to_login);
        exit;
    }
}

// Function to redirect if already logged in (for login page)
function redirect_if_login() {
    if (isset($_SESSION['login']) && $_SESSION['login'] === true) {
        if ($_SESSION['role'] == 'admin') {
            header("Location: pages/admin/user_read.php"); // Default admin page
        } elseif ($_SESSION['role'] == 'petugas') {
            header("Location: pages/petugas/parkir_masuk.php");
        } elseif ($_SESSION['role'] == 'owner') {
            header("Location: pages/owner/laporan.php");
        }
        // Fallback
        header("Location: index.php");
        exit;
    }
}

// Function to check role permission
function check_role($allowed_roles) {
    if (!in_array($_SESSION['role'], $allowed_roles)) {
         // JavaScript fallback mostly for UX, but exit is key
        echo "<script>alert('Anda tidak memiliki akses ke halaman ini!'); window.history.back();</script>";
        exit;
    }
}
?>
