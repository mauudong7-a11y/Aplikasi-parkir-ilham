<?php
include '../../functions/auth_check.php';
check_login();
check_role(['petugas']);
include '../../config/database.php';

if (isset($_POST['masuk'])) {
    $plat_nomor = strtoupper(htmlspecialchars($_POST['plat_nomor']));
    $id_kendaraan = $_POST['id_kendaraan'];
    $id_area = $_POST['id_area'];
    $id_user = $_SESSION['id_user'];
    $jam_masuk = date('Y-m-d H:i:s');

    // Cek kapasitas
    $area = mysqli_fetch_assoc(mysqli_query($conn, "SELECT kapasitas, 
        (SELECT COUNT(*) FROM tabel_transaksi WHERE id_area = tabel_area_parkir.id_area AND status = 'masuk') as terisi 
        FROM tabel_area_parkir WHERE id_area = '$id_area'"));

    if ($area['terisi'] >= $area['kapasitas']) {
        echo "<script>alert('Area parkir penuh!');</script>";
    } else {
        $query = "INSERT INTO tabel_transaksi (plat_nomor, id_kendaraan, id_area, id_user, jam_masuk, status) 
                  VALUES ('$plat_nomor', '$id_kendaraan', '$id_area', '$id_user', '$jam_masuk', 'masuk')";
        
        if (mysqli_query($conn, $query)) {
             // Print struk masuk optional, usually redirect to list
             echo "<script>alert('Kendaraan berhasil masuk!'); window.location.href='parkir_masuk.php';</script>";
        } else {
            echo "<script>alert('Gagal: " . mysqli_error($conn) . "');</script>";
        }
    }
}

include '../../includes/header.php';
include '../../includes/sidebar.php';
?>

<div class="flex-grow-1 bg-light">
    <?php include '../../includes/navbar.php'; ?>
    <div class="content">
        <h2 class="mb-4">Parkir Masuk</h2>
        <div class="row">
            <div class="col-md-6">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <form action="" method="POST">
                            <div class="mb-3">
                                <label class="form-label">Nomor Polisi (Plat Nomor)</label>
                                <input type="text" name="plat_nomor" class="form-control" placeholder="Contoh: AA 1234 BB" required autofocus>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Jenis Kendaraan</label>
                                <select name="id_kendaraan" class="form-select" required>
                                    <?php
                                    $kendaraan = mysqli_query($conn, "SELECT * FROM tabel_kendaraan");
                                    while($k = mysqli_fetch_assoc($kendaraan)) {
                                        echo "<option value='{$k['id_kendaraan']}'>{$k['nama_kendaraan']}</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Area Parkir</label>
                                <select name="id_area" class="form-select" required>
                                    <?php
                                    $area = mysqli_query($conn, "SELECT * FROM tabel_area_parkir");
                                    while($a = mysqli_fetch_assoc($area)) {
                                        // Tampilkan sisa kapasitas
                                        $terisi = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM tabel_transaksi WHERE id_area='{$a['id_area']}' AND status='masuk'"));
                                        $sisa = $a['kapasitas'] - $terisi;
                                        echo "<option value='{$a['id_area']}'>{$a['nama_area']} (Sisa: $sisa)</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <button type="submit" name="masuk" class="btn btn-primary w-100">Proses Masuk</button>
                        </form>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6">
                 <div class="card bg-info text-white">
                     <div class="card-body">
                         <h5>Informasi</h5>
                         <p>Pastikan Nomor Polisi dimasukkan dengan benar. Pilih jenis kendaraan yang sesuai agar tarif dapat dihitung dengan tepat.</p>
                     </div>
                 </div>
            </div>
        </div>
    </div>
</div>

<?php include '../../includes/footer.php'; ?>
