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
        <h2 class="mb-4">Kelola Area Parkir</h2>
        <a href="area_add.php" class="btn btn-primary mb-3"><i class="fas fa-plus"></i> Tambah Area</a>
        
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>NO</th>
                            <th>Nama Area</th>
                            <th>Kapasitas</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        $query = mysqli_query($conn, "SELECT * FROM tabel_area_parkir ORDER BY id_area ASC");
                        while ($row = mysqli_fetch_assoc($query)) {
                        ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $row['nama_area'] ?></td>
                            <td><?= $row['kapasitas'] ?></td>
                            <td>
                                <a href="area_edit.php?id=<?= $row['id_area'] ?>" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                                <a href="area_delete.php?id=<?= $row['id_area'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus area ini?')"><i class="fas fa-trash"></i></a>
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
