<?php
// Fetch counts for Gejala, Penyakit, and Rule
$sqlGejalaCount = "SELECT COUNT(*) as count FROM gejala";
$resultGejalaCount = $conn->query($sqlGejalaCount);
$rowGejalaCount = $resultGejalaCount->fetch_assoc();
$gejalaCount = $rowGejalaCount['count'];

$sqlPenyakitCount = "SELECT COUNT(*) as count FROM penyakit";
$resultPenyakitCount = $conn->query($sqlPenyakitCount);
$rowPenyakitCount = $resultPenyakitCount->fetch_assoc();
$penyakitCount = $rowPenyakitCount['count'];

$sqlRuleCount = "SELECT COUNT(*) as count FROM rule";
$resultRuleCount = $conn->query($sqlRuleCount);
$rowRuleCount = $resultRuleCount->fetch_assoc();
$ruleCount = $rowRuleCount['count'];

?>

<body>
    <div class="container-fluid mt-4">
        <h2 class="mb-4">Dashboard</h2>
        <div class="row">
            <!-- Gejala Count Card -->
            <div class="col-md-4">
                <div class="card text-white bg-primary mb-3">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="card-title">Jumlah Gejala</h5>
                                <h3><?php echo $gejalaCount; ?></h3>
                            </div>
                            <div>
                                <i class="fas fa-notes-medical fa-3x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Penyakit Count Card -->
            <div class="col-md-4">
                <div class="card text-white bg-danger mb-3">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="card-title">Jumlah Penyakit</h5>
                                <h3><?php echo $penyakitCount; ?></h3>
                            </div>
                            <div>
                                <i class="fas fa-virus fa-3x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Rule Count Card -->
            <div class="col-md-4">
                <div class="card text-white bg-success mb-3">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="card-title">Jumlah Rule</h5>
                                <h3><?php echo $ruleCount; ?></h3>
                            </div>
                            <div>
                                <i class="fas fa-ruler-combined fa-3x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

