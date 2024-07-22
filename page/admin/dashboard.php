<?php

// Ambil jumlah data
$resultGejala = $conn->query("SELECT COUNT(*) as count FROM gejala");
$countGejala = $resultGejala->fetch_assoc()['count'];

$resultPenyakit = $conn->query("SELECT COUNT(*) as count FROM penyakit");
$countPenyakit = $resultPenyakit->fetch_assoc()['count'];

$resultRule = $conn->query("SELECT COUNT(*) as count FROM rule");
$countRule = $resultRule->fetch_assoc()['count'];
?>

<link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-md-4">
            <div class="card text-white bg-primary mb-3">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title">Jumlah Gejala</h5>
                            <p class="card-text display-4"><?php echo $countGejala; ?></p>
                        </div>
                        <div>
                            <i class="fas fa-virus fa-4x"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="?page=gejala" class="text-white">Lihat Detail <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-success mb-3">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title">Jumlah Penyakit</h5>
                            <p class="card-text display-4"><?php echo $countPenyakit; ?></p>
                        </div>
                        <div>
                            <i class="fas fa-stethoscope fa-4x"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="?page=penyakit" class="text-white">Lihat Detail <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-warning mb-3">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title">Jumlah Rule</h5>
                            <p class="card-text display-4"><?php echo $countRule; ?></p>
                        </div>
                        <div>
                            <i class="fas fa-ruler fa-4x"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="?page=rule" class="text-white">Lihat Detail <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

