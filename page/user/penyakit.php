<?php
// Handle Create
if (isset($_POST['create'])) {
    $kode_penyakit = $_POST['kode_penyakit'];
    $nama_penyakit = $_POST['nama_penyakit'];
    $deskripsi = $_POST['deskripsi'];
    $pengobatan = $_POST['pengobatan'];

    $sql = "INSERT INTO penyakit (kode_penyakit, nama_penyakit, deskripsi, pengobatan) VALUES ('$kode_penyakit', '$nama_penyakit', '$deskripsi', '$pengobatan')";
    if ($conn->query($sql) === TRUE) {
        $_SESSION['message'] = "Data berhasil ditambah";
        $_SESSION['msg_type'] = "success";
    } else {
        $_SESSION['message'] = "Error: " . $conn->error;
        $_SESSION['msg_type'] = "danger";
    }
    header('Location: ?page=penyakit');
    exit();
}

// Handle Update
if (isset($_POST['update'])) {
    $id_penyakit = $_POST['id_penyakit'];
    $kode_penyakit = $_POST['kode_penyakit'];
    $nama_penyakit = $_POST['nama_penyakit'];
    $deskripsi = $_POST['deskripsi'];
    $pengobatan = $_POST['pengobatan'];

    $sql = "UPDATE penyakit SET kode_penyakit='$kode_penyakit', nama_penyakit='$nama_penyakit', deskripsi='$deskripsi', pengobatan='$pengobatan' WHERE id_penyakit=$id_penyakit";
    if ($conn->query($sql) === TRUE) {
        $_SESSION['message'] = "Data berhasil diubah";
        $_SESSION['msg_type'] = "success";
    } else {
        $_SESSION['message'] = "Error: " . $conn->error;
        $_SESSION['msg_type'] = "danger";
    }
    header('Location: ?page=penyakit');
    exit();
}

// Handle Delete
if (isset($_GET['delete'])) {
    $id_penyakit = $_GET['delete'];

    $sql = "DELETE FROM penyakit WHERE id_penyakit=$id_penyakit";
    if ($conn->query($sql) === TRUE) {
        $_SESSION['message'] = "Data berhasil dihapus";
        $_SESSION['msg_type'] = "success";
    } else {
        $_SESSION['message'] = "Error: " . $conn->error;
        $_SESSION['msg_type'] = "danger";
    }
    header('Location: ?page=penyakit');
    exit();
}

// Fetch All Penyakit
$sql = "SELECT * FROM penyakit";
$result = $conn->query($sql);

// Generate New Kode Penyakit
$sqlLastPenyakit = "SELECT id_penyakit FROM penyakit ORDER BY id_penyakit DESC LIMIT 1";
$resultLastPenyakit = $conn->query($sqlLastPenyakit);
$rowLastPenyakit = $resultLastPenyakit->fetch_assoc();
$newKodePenyakit = 'P' . str_pad($rowLastPenyakit['id_penyakit'] + 1, 2, '0', STR_PAD_LEFT);

?>
<div class="container-fluid">
    <h2 class="mb-4">Data Penyakit</h2>

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

    <!-- Penyakit Table -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No.</th>
                <th>Kode Penyakit</th>
                <th>Nama Penyakit</th>
                <th>Deskripsi</th>
                <th>Pengobatan</th>
            </tr>
        </thead>
        <tbody>
            <?php $i=1; while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $i; ?></td>
                    <td><?php echo $row['kode_penyakit']; ?></td>
                    <td><?php echo $row['nama_penyakit']; ?></td>
                    <td><?php echo $row['deskripsi']; ?></td>
                    <td><?php echo $row['pengobatan']; ?></td>
                </tr>
            <?php $i++; endwhile; ?>
        </tbody>
    </table>
</div>
