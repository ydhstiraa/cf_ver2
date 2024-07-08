<?php
// Handle Create
if (isset($_POST['create'])) {
    $kode_gejala = $_POST['kode_gejala'];
    $nama_gejala = $_POST['nama_gejala'];

    $sql = "INSERT INTO gejala (kode_gejala, nama_gejala) VALUES ('$kode_gejala', '$nama_gejala')";
    if ($conn->query($sql) === TRUE) {
        $_SESSION['message'] = "Data berhasil ditambah";
        $_SESSION['msg_type'] = "success";
    } else {
        $_SESSION['message'] = "Error: " . $conn->error;
        $_SESSION['msg_type'] = "danger";
    }
    header('Location: ?page=gejala');
    exit();
}

// Handle Update
if (isset($_POST['update'])) {
    $id_gejala = $_POST['id_gejala'];
    $kode_gejala = $_POST['kode_gejala'];
    $nama_gejala = $_POST['nama_gejala'];

    $sql = "UPDATE gejala SET kode_gejala='$kode_gejala', nama_gejala='$nama_gejala' WHERE id_gejala=$id_gejala";
    if ($conn->query($sql) === TRUE) {
        $_SESSION['message'] = "Data berhasil diubah";
        $_SESSION['msg_type'] = "success";
    } else {
        $_SESSION['message'] = "Error: " . $conn->error;
        $_SESSION['msg_type'] = "danger";
    }
    header('Location: ?page=gejala');
    exit();
}

// Handle Delete
if (isset($_GET['delete'])) {
    $id_gejala = $_GET['delete'];

    $sql = "DELETE FROM gejala WHERE id_gejala=$id_gejala";
    if ($conn->query($sql) === TRUE) {
        $_SESSION['message'] = "Data berhasil dihapus";
        $_SESSION['msg_type'] = "success";
    } else {
        $_SESSION['message'] = "Error: " . $conn->error;
        $_SESSION['msg_type'] = "danger";
    }
    header('Location: ?page=gejala');
    exit();
}

// Fetch All Gejala
$sql = "SELECT * FROM gejala";
$result = $conn->query($sql);

// Generate New Kode Gejala
$sqlLastGejala = "SELECT id_gejala FROM gejala ORDER BY id_gejala DESC LIMIT 1";
$resultLastGejala = $conn->query($sqlLastGejala);
$rowLastGejala = $resultLastGejala->fetch_assoc();
$newKodeGejala = 'G' . str_pad($rowLastGejala['id_gejala'] + 1, 2, '0', STR_PAD_LEFT);

?>
<div class="container-fluid">
    <h2 class="mb-4">Data Gejala</h2>

    <!-- Display Notification -->
    <?php
    if (isset($_SESSION['message'])): ?>
        <div class="alert alert-<?php echo $_SESSION['msg_type']; ?> alert-dismissible fade show" role="alert">
            <?php
            echo $_SESSION['message'];
            unset($_SESSION['message']);
            unset($_SESSION['msg_type']);
            ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>

    <!-- Button to Open the Modal -->
    <button type="button" class="btn btn-primary mb-4" data-toggle="modal" data-target="#createModal">
        Tambah Gejala
    </button>

    <!-- Create Modal -->
    <div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="createModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createModalLabel">Tambah Gejala</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="?page=gejala">
                        <div class="form-group">
                            <label for="kode_gejala">Kode Gejala</label>
                            <input type="text" class="form-control" id="kode_gejala" name="kode_gejala" value="<?php echo $newKodeGejala; ?>" required readonly>
                        </div>
                        <div class="form-group">
                            <label for="nama_gejala">Nama Gejala</label>
                            <input type="text" class="form-control" id="nama_gejala" name="nama_gejala" required>
                        </div>
                        <button type="submit" name="create" class="btn btn-primary">Tambah</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Gejala Table -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No.</th>
                <th>Kode Gejala</th>
                <th>Nama Gejala</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $i=1; while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $i; ?></td>
                    <td><?php echo $row['kode_gejala']; ?></td>
                    <td><?php echo $row['nama_gejala']; ?></td>
                    <td>
                        <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editModal<?php echo $row['id_gejala']; ?>">Edit</button>
                        <a href="?page=gejala&delete=<?php echo $row['id_gejala']; ?>" class="btn btn-danger btn-sm">Hapus</a>

                        <!-- Edit Modal -->
                        <div class="modal fade" id="editModal<?php echo $row['id_gejala']; ?>" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editModalLabel">Edit Gejala</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form method="POST" action="?page=gejala">
                                            <input type="hidden" name="id_gejala" value="<?php echo $row['id_gejala']; ?>">
                                            <div class="form-group">
                                                <label for="kode_gejala">Kode Gejala</label>
                                                <input type="text" class="form-control" id="kode_gejala" name="kode_gejala" value="<?php echo $row['kode_gejala']; ?>" required readonly>
                                            </div>
                                            <div class="form-group">
                                                <label for="nama_gejala">Nama Gejala</label>
                                                <input type="text" class="form-control" id="nama_gejala" name="nama_gejala" value="<?php echo $row['nama_gejala']; ?>" required>
                                            </div>
                                            <button type="submit" name="update" class="btn btn-primary">Update</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
            <?php $i++; endwhile; ?>
        </tbody>
    </table>
</div>
