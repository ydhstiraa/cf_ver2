<?php
// Handle Create
if (isset($_POST['create'])) {
    $username = $_POST['username'];
    $password = md5($_POST['password']); // Enkripsi password dengan md5
    $level = $_POST['level'];
    $nama = $_POST['nama'];

    $sql = "INSERT INTO users (username, password, level, nama) VALUES ('$username', '$password', '$level', '$nama')";
    if ($conn->query($sql) === TRUE) {
        $_SESSION['message'] = "User berhasil ditambah";
        $_SESSION['msg_type'] = "success";
    } else {
        $_SESSION['message'] = "Error: " . $conn->error;
        $_SESSION['msg_type'] = "danger";
    }
    header('Location: ?page=users');
    exit();
}

// Handle Update
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $username = $_POST['username'];
    $password = $_POST['password'] ? md5($_POST['password']) : $_POST['old_password']; // Cek apakah password diubah
    $level = $_POST['level'];
    $nama = $_POST['nama'];

    $sql = "UPDATE users SET username='$username', password='$password', level='$level', nama='$nama' WHERE id=$id";
    if ($conn->query($sql) === TRUE) {
        $_SESSION['message'] = "User berhasil diubah";
        $_SESSION['msg_type'] = "success";
    } else {
        $_SESSION['message'] = "Error: " . $conn->error;
        $_SESSION['msg_type'] = "danger";
    }
    header('Location: ?page=users');
    exit();
}

// Handle Delete
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];

    $sql = "DELETE FROM users WHERE id=$id";
    if ($conn->query($sql) === TRUE) {
        $_SESSION['message'] = "User berhasil dihapus";
        $_SESSION['msg_type'] = "success";
    } else {
        $_SESSION['message'] = "Error: " . $conn->error;
        $_SESSION['msg_type'] = "danger";
    }
    header('Location: ?page=users');
    exit();
}

// Fetch All Users
$sql = "SELECT * FROM users";
$result = $conn->query($sql);
?>

<div class="container-fluid">
    <h2 class="mb-4">Data User</h2>

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
        Tambah User
    </button>

    <!-- Create Modal -->
    <div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="createModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createModalLabel">Tambah User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="?page=users">
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" class="form-control" id="username" name="username" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <div class="form-group">
                            <label for="level">Level</label>
                            <select class="form-control" id="level" name="level" required>
                                <option value="admin">Admin</option>
                                <option value="user">User</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="nama">Nama</label>
                            <input type="text" class="form-control" id="nama" name="nama" required>
                        </div>
                        <button type="submit" name="create" class="btn btn-primary">Tambah</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- User Table -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No.</th>
                <th>Username</th>
                <th>Level</th>
                <th>Nama</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $i=1; while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $i; ?></td>
                    <td><?php echo $row['username']; ?></td>
                    <td><?php echo ucfirst($row['level']); ?></td>
                    <td><?php echo $row['nama']; ?></td>
                    <td>
                        <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editModal<?php echo $row['id']; ?>">Edit</button>
                        <a href="?page=users&delete=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm">Hapus</a>

                        <!-- Edit Modal -->
                        <div class="modal fade" id="editModal<?php echo $row['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editModalLabel">Edit User</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form method="POST" action="?page=users">
                                            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                            <div class="form-group">
                                                <label for="username">Username</label>
                                                <input type="text" class="form-control" id="username" name="username" value="<?php echo $row['username']; ?>" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="password">Password (biarkan kosong jika tidak ingin mengubah)</label>
                                                <input type="password" class="form-control" id="password" name="password">
                                                <input type="hidden" name="old_password" value="<?php echo $row['password']; ?>">
                                            </div>
                                            <div class="form-group">
                                                <label for="level">Level</label>
                                                <select class="form-control" id="level" name="level" required>
                                                    <option value="admin" <?php echo $row['level'] == 'admin' ? 'selected' : ''; ?>>Admin</option>
                                                    <option value="user" <?php echo $row['level'] == 'user' ? 'selected' : ''; ?>>User</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="nama">Nama</label>
                                                <input type="text" class="form-control" id="nama" name="nama" value="<?php echo $row['nama']; ?>" required>
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
