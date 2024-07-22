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

    <!-- Rule Table -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No.</th>
                <th>Kode Penyakit</th>
                <th>Kode Gejala</th>
                <th>MB</th>
                <th>MD</th>
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
                    </tr>
                <?php endforeach; ?>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
