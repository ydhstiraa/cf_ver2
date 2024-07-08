<?php
// Fetch Gejala
$sql = "SELECT * FROM gejala";
$result = $conn->query($sql);

// Handle Submit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $selectedGejala = isset($_POST['gejala']) ? $_POST['gejala'] : [];

    // Simpan hasil checkbox dalam session (atau bisa juga disimpan ke database)
    $_SESSION['selectedGejala'] = $selectedGejala;

    // Redirect ke halaman hasil (atau tetap di halaman ini dengan menampilkan hasil)

    header('Location: ?page=testing');
    exit();
}
?>

<div class="container-fluid">
    <h2>Testing Gejala</h2>
    <div class="card mb-4">
        <div class="card-header">Daftar Gejala</div>
        <div class="card-body">
            <form method="POST" action="?page=testing">
                <div class="form-group">
                    <label>Pilih Gejala:</label><br>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="gejala[]" value="<?php echo $row['kode_gejala']; ?>" id="gejala<?php echo $row['id_gejala']; ?>">
                            <label class="form-check-label" for="gejala<?php echo $row['id_gejala']; ?>">
                                <?php echo $row['nama_gejala']; ?>
                            </label>
                        </div>
                    <?php endwhile; ?>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
            
            
        </div>
    </div>
    <?php if (isset($_SESSION['selectedGejala'])): ?>
    <div class="card shadow success mb-4">
        <div class="card-header"><div class="font-weight-bold text-success"> Hasil Pakar </div></div>
        <div class="card-body">
        <h6 class='m-0'>Gejala Terpilih:</h6>
        <ul>
            <?php foreach ($_SESSION['selectedGejala'] as $gejalaId): ?>
                <?php
                $sqlGejala = "SELECT nama_gejala FROM gejala WHERE kode_gejala = '$gejalaId'";
                $resultGejala = $conn->query($sqlGejala);
                $rowGejala = $resultGejala->fetch_assoc();
                ?>
                <li><?php echo $rowGejala['nama_gejala']; ?></li>
            <?php endforeach; ?>
        </ul>
            <?php 
                // var_dump($_SESSION['selectedGejala']);
                $cfPenyakit = hitungCF($rules, $_SESSION['selectedGejala']);
                arsort($cfPenyakit);
                $cfTertinggi = reset($cfPenyakit); // Mendapatkan nilai CF tertinggi
                $hasDisease = false;
                foreach ($cfPenyakit as $kodePenyakit => $cf) {
                    if ($cf == $cfTertinggi && $cf > 0) {
                        $hasDisease = true;
                        echo "<h6 class='m-0'>Diagnosa Penyakit : " . $penyakit[$kodePenyakit]['nama_penyakit']. "</h6>";
                        echo "<h6 class='m-0'>Deskripsi : " . $penyakit[$kodePenyakit]['deskripsi'] . "</h6>";
                        echo "<h6 class='m-0'>Pengobatan : " . $penyakit[$kodePenyakit]['pengobatan'] . "</h6>";
                        echo "<h6 class='m-0'>Nilai Keyakinan (CF) : " . ($cf*100) . "%<br><br>";
                    }
                }

                if (!$hasDisease) {
                    echo "Tidak ada penyakit yang terdeteksi dengan gejala yang diberikan.<br>";
                }
            ?>
        </div>
    </div>
    <?php endif; ?>
    <?php unset($_SESSION['selectedGejala']); ?>
</div>