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
        <h2 class="mb-4">Kelola Kendaraan</h2>
        <a href="kendaraan_add.php" class="btn btn-primary mb-3"><i class="fas fa-plus"></i> Tambah Kendaraan</a>
        
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>NO</th>
                            <th>Nama Kendaraan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        $query = mysqli_query($conn, "SELECT * FROM tabel_kendaraan ORDER BY id_kendaraan ASC");
                        while ($row = mysqli_fetch_assoc($query)) {
                        ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $row['nama_kendaraan'] ?></td>
                            <td>
                                <a href="kendaraan_edit.php?id=<?= $row['id_kendaraan'] ?>" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                                <a href="kendaraan_delete.php?id=<?= $row['id_kendaraan'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus kendaraan ini?')"><i class="fas fa-trash"></i></a>
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
