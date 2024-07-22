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

    <!-- Gejala Table -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No.</th>
                <th>Kode Gejala</th>
                <th>Nama Gejala</th>
            </tr>
        </thead>
        <tbody>
            <?php $i=1; while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $i; ?></td>
                    <td><?php echo $row['kode_gejala']; ?></td>
                    <td><?php echo $row['nama_gejala']; ?></td>
                </tr>
            <?php $i++; endwhile; ?>
        </tbody>
    </table>
</div>
