<?php
session_start();
if (!isset($_SESSION['nim'])) {
    header("Location: login.php");
    exit();
}
include 'config.php';

$nim = $_SESSION['nim'];
$group = ($nim[-1] % 2 == 0) ? 'A' : 'B'; // Mahasiswa Laki-laki nim belakang ganjil menginput data grup B
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard UEFA 2024</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container dashboard">
        <h2>Selamat Datang, <?php echo $nim; ?></h2>
        <h3>Anda dapat memasukkan data untuk Grup <?php echo $group; ?></h3>
        <a href="input_data.php">Input Data Negara</a>
        <a href="view_data.php">Lihat Data Negara</a>
        <a href="logout.php">Logout</a>
    </div>
</body>
</html>
