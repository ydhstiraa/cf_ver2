<?php
$page = isset($_GET['page']) ? $_GET['page'] : 'variabel';

switch ($page) {
    case 'dashboard':
        include 'dashboard.php';
        break;
    case 'gejala':
        include 'gejala.php';
        break;
    case 'penyakit':
        include 'penyakit.php';
        break;
    case 'rule':
        include 'rule.php';
        break;
    case 'testing':
        include 'testing.php';
        break;
    case 'login':
        include '../../index.php';
        break;
    case 'logout':
        include 'logout.php';
        break;
    default:
        include 'dashboard.php';
}