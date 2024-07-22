<?php
// Fetch Gejala
$sql = "SELECT * FROM gejala";
$result = $conn->query($sql);

// Handle Submit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $selectedGejala = isset($_POST['gejala']) ? $_POST['gejala'] : [];

    // Simpan hasil checkbox dalam session (atau bisa juga disimpan ke database)
    $_SESSION['selectedGejala'] = $selectedGejala;

    // Redirect ke halaman hasil
    header('Location: ?page=testing');
    exit();
}
?>

<div class="container-fluid">
    <?php if (!isset($_SESSION['selectedGejala'])): ?>
        <h2>Testing Gejala</h2>
        <div class="card mb-4">
            <div class="card-header">Daftar Gejala</div>
            <div class="card-body">
                <form method="POST" action="?page=testing">
                    <div class="form-group">
                        <label>Pilih Gejala:</label><br>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="gejala[]" value="<?php echo $row['kode_gejala']; ?>" id="gejala<?php echo $row['kode_gejala']; ?>">
                                <label class="form-check-label" for="gejala<?php echo $row['kode_gejala']; ?>">
                                    <?php echo $row['nama_gejala']; ?>
                                </label>
                            </div>
                        <?php endwhile; ?>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    <?php else: ?>
        <div class="card shadow success mb-4" id="hasilPakarCard">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div class="font-weight-bold text-success">Hasil Pakar</div>
                <div>
                    <button class="btn btn-success" onclick="printCard()">Print</button>
                    <a href="?page=testing" class="btn btn-danger">Kembali</a>
                </div>
            </div>
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
                    // Hitung CF dan tampilkan hasil
                    $cfPenyakit = hitungCF($rules, $_SESSION['selectedGejala']);
                    arsort($cfPenyakit);
                    $cfTertinggi = arsort($cfPenyakit); // Mendapatkan nilai CF tertinggi
                    $hasDisease = false;
                    foreach ($cfPenyakit as $kodePenyakit => $cf) {
                        if ($cf == $cfTertinggi && $cf > 0) {
                            $hasDisease = true;
                            echo "<h6 class='m-0 text-danger'>Diagnosa Penyakit : <b>" . $penyakit[$kodePenyakit]['nama_penyakit']. "</b></h6>";
                            echo "<h6 class='m-0'>Deskripsi : " . $penyakit[$kodePenyakit]['deskripsi'] . "</h6>";
                            echo "<h6 class='m-0'>Pengobatan : " . $penyakit[$kodePenyakit]['pengobatan'] . "</h6>";
                            echo "<h6 class='m-0 text-success'>Nilai Keyakinan (CF) : <b>" . ($cf*100) . "%</b><br><hr><br>";
                        }
                    }

                    if (!$hasDisease) {
                        echo "Tidak ada penyakit yang terdeteksi dengan gejala yang diberikan.<br>";
                    }
                ?>
            </div>
            <div class="card-footer text-right">
                <a href="?page=testing" class="btn btn-danger">Kembali</a>
            </div>
        </div>
    <?php endif; ?>
    <?php unset($_SESSION['selectedGejala']); ?>
</div>

<script>
function printCard() {
    var printWindow = window.open('', '', 'height=600,width=800');
    var content = document.getElementById('hasilPakarCard').innerHTML;
    printWindow.document.write('<html><head><title>Print Hasil Pakar</title>');
    printWindow.document.write('<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">');
    printWindow.document.write('</head><body >');
    printWindow.document.write(content);
    printWindow.document.write('</body></html>');
    printWindow.document.close();
    printWindow.focus();
    printWindow.print();
}
</script>

<style>
@media print {
    .d-flex, .btn, .btn-secondary {
        display: none !important;
    }
}
</style>
