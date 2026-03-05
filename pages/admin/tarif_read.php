<?php
include '../../functions/auth_check.php';
check_login();
check_role(['admin']);
include '../../config/database.php';
include '../../includes/header.php';
include '../../includes/sidebar.php';
?>

<div class="flex-grow-1 bg-light">
    <?php include '../../includes/navbar.php'; ?>
    
    <div class="content">
        <h2 class="mb-4">Kelola Tarif Parkir</h2>
        <a href="tarif_add.php" class="btn btn-primary mb-3"><i class="fas fa-plus"></i> Tambah Tarif</a>
        
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>NO</th>
                            <th>Jenis Kendaraan</th>
                            <th>Tarif Per Jam</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        $query = mysqli_query($conn, "SELECT * FROM tabel_tarif JOIN tabel_kendaraan ON tabel_tarif.id_kendaraan = tabel_kendaraan.id_kendaraan ORDER BY id_tarif ASC");
                        while ($row = mysqli_fetch_assoc($query)) {
                        ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $row['nama_kendaraan'] ?></td>
                            <td>Rp <?= number_format($row['tarif_per_jam'], 0, ',', '.') ?></td>
                            <td>
                                <a href="tarif_edit.php?id=<?= $row['id_tarif'] ?>" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                                <a href="tarif_delete.php?id=<?= $row['id_tarif'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus tarif ini?')"><i class="fas fa-trash"></i></a>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include '../../includes/footer.php'; ?>
