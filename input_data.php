<?php
session_start();
if (!isset($_SESSION['nim'])) {
    header("Location: login.php");
    exit();
}
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $group_id = $_POST['group_id'];
    $country_name = $_POST['country_name'];
    $matches_won = $_POST['matches_won'];
    $matches_drawn = $_POST['matches_drawn'];
    $matches_lost = $_POST['matches_lost'];
    $points = $_POST['points'];

    $sql = "INSERT INTO countries (group_id, country_name, matches_won, matches_drawn, matches_lost, points) VALUES ('$group_id', '$country_name', '$matches_won', '$matches_drawn', '$matches_lost', '$points')";
    
    if ($conn->query($sql) === TRUE) {
        echo "Data berhasil dimasukkan!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$nim = $_SESSION['nim'];
$group = ($nim[-1] % 2 == 0) ? 'A' : 'B'; // Mahasiswa Laki-laki nim belakang ganjil menginput data grup B
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Input Data Negara UEFA 2024</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h2>Input Data Negara UEFA 2024</h2>
    <form method="post" action="input_data.php">
        <label for="group_id">Grup:</label>
        <select id="group_id" name="group_id">
            <option value="1">Grup A</option>
            <option value="2">Grup B</option>
            <option value="3">Grup C</option>
            <option value="4">Grup D</option>
        </select>
        <label for="country_name">Nama Negara:</label>
        <input type="text" id="country_name" name="country_name" required>
        <label for="matches_won">Jumlah Menang:</label>
        <input type="number" id="matches_won" name="matches_won" required>
        <label for="matches_drawn">Jumlah Seri:</label>
        <input type="number" id="matches_drawn" name="matches_drawn" required>
        <label for="matches_lost">Jumlah Kalah:</label>
        <input type="number" id="matches_lost" name="matches_lost" required>
        <label for="points">Jumlah Poin:</label>
        <input type="number" id="points" name="points" required>
        <button type="submit">Simpan Data</button>
    </form>
</body>
</html>
