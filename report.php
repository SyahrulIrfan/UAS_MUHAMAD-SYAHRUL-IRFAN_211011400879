<?php
session_start();
if (!isset($_SESSION['nim'])) {
    header("Location: login.php");
    exit();
}
include 'config.php';

require 'vendor/autoload.php';

use Dompdf\Dompdf;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $group_id = $_POST['group_id'];
    $sql = "SELECT * FROM countries WHERE group_id='$group_id'";
    $result = $conn->query($sql);
    
    $html = '<h2>Data Negara UEFA 2024</h2>';
    $html .= '<table border="1" cellspacing="0" cellpadding="5">';
    $html .= '<tr><th>Nama Negara</th><th>Menang</th><th>Seri</th><th>Kalah</th><th>Poin</th></tr>';
    while($row = $result->fetch_assoc()) {
        $html .= '<tr>';
        $html .= '<td>'.$row['country_name'].'</td>';
        $html .= '<td>'.$row['matches_won'].'</td>';
        $html .= '<td>'.$row['matches_drawn'].'</td>';
        $html .= '<td>'.$row['matches_lost'].'</td>';
        $html .= '<td>'.$row['points'].'</td>';
        $html .= '</tr>';
    }
    $html .= '</table>';

    $dompdf = new Dompdf();
    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'landscape');
    $dompdf->render();
    $dompdf->stream("report.pdf");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Report UEFA 2024</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h2>Report Negara UEFA 2024</h2>
    <form method="post" action="report.php">
        <label for="group_id">Grup:</label>
        <select id="group_id" name="group_id">
            <option value="1">Grup A</option>
            <option value="2">Grup B</option>
            <option value="3">Grup C</option>
            <option value="4">Grup D</option>
        </select>
        <button type="submit">Cetak PDF</button>
    </form>
</body>
</html>
