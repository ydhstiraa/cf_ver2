<?php
include('connect.php');

// Mengambil data gejala
$gejala = [];
$sql = "SELECT * FROM gejala";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $gejala[$row['kode_gejala']] = $row['nama_gejala'];
    }
}

// Mengambil data penyakit
$penyakit = [];
$sql = "SELECT * FROM penyakit";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $penyakit[$row['kode_penyakit']] = [
            'nama_penyakit' => $row['nama_penyakit'],
            'deskripsi' => $row['deskripsi'],
            'pengobatan' => $row['pengobatan']
        ];
    }
}

// Mengambil data rule
$rules = [];
$sql = "SELECT * FROM rule";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $rules[] = [
            'kode_penyakit' => $row['kode_penyakit'],
            'kode_gejala' => $row['kode_gejala'],
            'mb' => $row['mb'],
            'md' => $row['md']
        ];
    }
}

//var_dump($penyakit);

// Fungsi untuk menghitung CF
function hitungCF($rules, $inputGejala) {
    $cfPenyakit = [];

    foreach ($rules as $rule) {
        $kodePenyakit = $rule['kode_penyakit'];
        $kodeGejala = $rule['kode_gejala'];
        $mb = $rule['mb'];
        $md = $rule['md'];

        if (in_array($kodeGejala, $inputGejala)) {
            $cf = $mb - $md;
            if (isset($cfPenyakit[$kodePenyakit])) {
                $cfPenyakit[$kodePenyakit] = $cfPenyakit[$kodePenyakit] + $cf * (1 - $cfPenyakit[$kodePenyakit]);
            } else {
                $cfPenyakit[$kodePenyakit] = $cf;
            }
        }
    }

    return $cfPenyakit;
}

// Contoh input gejala dari user
//$inputGejala = ['G09', 'G10', 'G06'];

// Menghitung CF
//$cfPenyakit = hitungCF($rules, $inputGejala);

// // Menampilkan hasil dengan CF tertinggi
// arsort($cfPenyakit);
// $cfTertinggi = reset($cfPenyakit); // Mendapatkan nilai CF tertinggi

// echo "Penyakit dengan CF tertinggi:<br><br>";

// $hasDisease = false;
// foreach ($cfPenyakit as $kodePenyakit => $cf) {
//     if ($cf == $cfTertinggi && $cf > 0) {
//         $hasDisease = true;
//         echo "Penyakit: " . $penyakit[$kodePenyakit]['nama_penyakit'] . "<br>";
//         echo "Deskripsi: " . $penyakit[$kodePenyakit]['deskripsi'] . "<br>";
//         echo "Pengobatan: " . $penyakit[$kodePenyakit]['pengobatan'] . "<br>";
//         echo "CF: " . $cf . "<br><br>";
//     }
// }

// if (!$hasDisease) {
//     echo "Tidak ada penyakit yang terdeteksi dengan gejala yang diberikan.<br>";
// }

// Menampilkan hasil
// arsort($cfPenyakit);
// foreach ($cfPenyakit as $kodePenyakit => $cf) {
//     echo "Penyakit: " . $penyakit[$kodePenyakit]['nama_penyakit'] . "<br>";
//     echo "Deskripsi: " . $penyakit[$kodePenyakit]['deskripsi'] . "<br>";
//     echo "Pengobatan: " . $penyakit[$kodePenyakit]['pengobatan'] . "<br>";
//     echo "CF: " . $cf . "<br><br>";
// }
