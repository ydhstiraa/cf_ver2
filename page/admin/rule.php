<?php
// Handle Create
if (isset($_POST['create'])) {
    $kode_penyakit = $_POST['kode_penyakit'];
    $kode_gejala = $_POST['kode_gejala'];
    $mb = $_POST['mb'];
    $md = $_POST['md'];

    $sql = "INSERT INTO rule (kode_penyakit, kode_gejala, mb, md) VALUES ('$kode_penyakit', '$kode_gejala', '$mb', '$md')";
    if ($conn->query($sql) === TRUE) {
        $_SESSION['message'] = "Data berhasil ditambah";
        $_SESSION['msg_type'] = "success";
    } else {
        $_SESSION['message'] = "Error: " . $conn->error;
        $_SESSION['msg_type'] = "danger";
    }
    header('Location: ?page=rule');
    exit();
}

// Handle Update
if (isset($_POST['update'])) {
    $id_rule = $_POST['id_rule'];
    $kode_penyakit = $_POST['kode_penyakit'];
    $kode_gejala = $_POST['kode_gejala'];
    $mb = $_POST['mb'];
    $md = $_POST['md'];

    $sql = "UPDATE rule SET kode_penyakit='$kode_penyakit', kode_gejala='$kode_gejala', mb='$mb', md='$md' WHERE id_rule=$id_rule";
    if ($conn->query($sql) === TRUE) {
        $_SESSION['message'] = "Data berhasil diubah";
        $_SESSION['msg_type'] = "success";
    } else {
        $_SESSION['message'] = "Error: " . $conn->error;
        $_SESSION['msg_type'] = "danger";
    }
    header('Location: ?page=rule');
    exit();
}

// Handle Delete
if (isset($_GET['delete'])) {
    $id_rule = $_GET['delete'];

    $sql = "DELETE FROM rule WHERE id_rule=$id_rule";
    if ($conn->query($sql) === TRUE) {
        $_SESSION['message'] = "Data berhasil dihapus";
        $_SESSION['msg_type'] = "success";
    } else {
        $_SESSION['message'] = "Error: " . $conn->error;
        $_SESSION['msg_type'] = "danger";
    }
    header('Location: ?page=rule');
    exit();
}

// Fetch All Rules
$sql = "SELECT * FROM rule 
LEFT JOIN gejala
ON rule.kode_gejala = gejala.kode_gejala
LEFT JOIN penyakit
ON penyakit.kode_penyakit = rule.kode_penyakit
ORDER BY rule.kode_penyakit";
$result = $conn->query($sql);

$rules = [];
while ($row = $result->fetch_assoc()) {
    $rules[$row['nama_penyakit']][] = $row;
}

//penomoran tabel
$i = 1;

// Fetch Penyakit and Gejala for dropdown
$sqlPenyakit = "SELECT kode_penyakit, nama_penyakit FROM penyakit";
$resultPenyakit = $conn->query($sqlPenyakit);

$sqlGejala = "SELECT kode_gejala, nama_gejala FROM gejala";
$resultGejala = $conn->query($sqlGejala);
?>

<div class="container-fluid">
    <h2 class="mb-4">Data Rule</h2>

    <!-- Display Notification -->
    <?php if (isset($_SESSION['message'])): ?>
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

    <!-- Button to Open the Create Modal -->
    <button type="button" class="btn btn-primary mb-4" data-toggle="modal" data-target="#createModal">
        Tambah Rule
    </button>

    <!-- Create Modal -->
    <div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="createModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createModalLabel">Tambah Rule</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="?page=rule">
                        <div class="form-group">
                            <label for="kode_penyakit">Penyakit</label>
                            <select class="form-control" id="kode_penyakit" name="kode_penyakit" required>
                                <?php while ($rowPenyakit = $resultPenyakit->fetch_assoc()): ?>
                                    <option value="<?php echo $rowPenyakit['kode_penyakit']; ?>"><?php echo $rowPenyakit['nama_penyakit']; ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="kode_gejala">Gejala</label>
                            <select class="form-control" id="kode_gejala" name="kode_gejala" required>
                                <?php while ($rowGejala = $resultGejala->fetch_assoc()): ?>
                                    <option value="<?php echo $rowGejala['kode_gejala']; ?>"><?php echo $rowGejala['nama_gejala']; ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="mb">MB ( <i>measure of increased belief</i> )</label>
                            <input type="number" step="0.01" class="form-control" id="mb" name="mb" required>
                        </div>
                        <div class="form-group">
                            <label for="md">MD ( <i>measure of increased disbelief</i> )</label>
                            <input type="number" step="0.01" class="form-control" id="md" name="md" required>
                        </div>
                        <button type="submit" name="create" class="btn btn-primary">Tambah</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Rule Table -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No.</th>
                <th>Kode Penyakit</th>
                <th>Kode Gejala</th>
                <th>MB</th>
                <th>MD</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($rules as $penyakit => $rows): ?>
            <?php $rowspan = count($rows); ?>
                <?php foreach ($rows as $index => $row): ?>
                    <tr>
                        <?php if ($index == 0): ?>
                            <td rowspan="<?php echo $rowspan; ?>"><?php echo $i++; ?></td>
                            <td rowspan="<?php echo $rowspan; ?>"><?php echo $penyakit; ?></td>
                        <?php endif; ?>
                        <td><?php echo $row['nama_gejala']; ?></td>
                        <td><?php echo $row['mb']; ?></td>
                        <td><?php echo $row['md']; ?></td>
                        <td>
                            <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editModal<?php echo $row['id_rule']; ?>">Edit</button>
                            <a href="?page=rule&delete=<?php echo $row['id_rule']; ?>" class="btn btn-danger btn-sm">Hapus</a>

                            <!-- Edit Modal -->
                            <div class="modal fade" id="editModal<?php echo $row['id_rule']; ?>" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editModalLabel">Edit Rule</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form method="POST" action="?page=rule">
                                                <input type="hidden" name="id_rule" value="<?php echo $row['id_rule']; ?>">
                                                <div class="form-group">
                                                    <label for="kode_penyakit">Kode Penyakit</label>
                                                    <select class="form-control" id="kode_penyakit" name="kode_penyakit" required>
                                                        <?php
                                                        $resultPenyakit->data_seek(0); // Reset result set pointer
                                                        while ($rowPenyakit = $resultPenyakit->fetch_assoc()): ?>
                                                            <option value="<?php echo $rowPenyakit['kode_penyakit']; ?>" <?php echo $row['kode_penyakit'] == $rowPenyakit['kode_penyakit'] ? 'selected' : ''; ?>><?php echo $rowPenyakit['nama_penyakit']; ?></option>
                                                        <?php endwhile; ?>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="kode_gejala">Kode Gejala</label>
                                                    <select class="form-control" id="kode_gejala" name="kode_gejala" required>
                                                        <?php
                                                        $resultGejala->data_seek(0); // Reset result set pointer
                                                        while ($rowGejala = $resultGejala->fetch_assoc()): ?>
                                                            <option value="<?php echo $rowGejala['kode_gejala']; ?>" <?php echo $row['kode_gejala'] == $rowGejala['kode_gejala'] ? 'selected' : ''; ?>><?php echo $rowGejala['nama_gejala']; ?></option>
                                                        <?php endwhile; ?>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="mb">MB</label>
                                                    <input type="number" step="0.01" class="form-control" id="mb" name="mb" value="<?php echo $row['mb']; ?>" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="md">MD</label>
                                                    <input type="number" step="0.01" class="form-control" id="md" name="md" value="<?php echo $row['md']; ?>" required>
                                                </div>
                                                <button type="submit" name="update" class="btn btn-primary">Update</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
