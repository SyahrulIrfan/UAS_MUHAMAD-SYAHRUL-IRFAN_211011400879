<?php
session_start();
if (!isset($_SESSION['nim'])) {
    header("Location: login.php");
    exit();
}
include 'config.php';
require('fpdf/fpdf.php');

class PDF extends FPDF {
    // Header
    function Header() {
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(0, 10, 'Data Negara UEFA 2024', 0, 1, 'C');
        $this->Ln(5);
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(10, 10, 'ID', 1);
        $this->Cell(30, 10, 'Grup', 1);
        $this->Cell(40, 10, 'Nama Negara', 1);
        $this->Cell(20, 10, 'Menang', 1);
        $this->Cell(20, 10, 'Seri', 1);
        $this->Cell(20, 10, 'Kalah', 1);
        $this->Cell(20, 10, 'Poin', 1);
        $this->Ln();
    }

    // Footer
    function Footer() {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, 'Halaman ' . $this->PageNo(), 0, 0, 'C');
    }
}

// Ambil data dari tabel countries
$sql = "SELECT countries.id, groups.name AS group_name, countries.country_name, countries.matches_won, countries.matches_drawn, countries.matches_lost, countries.points 
        FROM countries 
        JOIN groups ON countries.group_id = groups.id";
$result = $conn->query($sql);

$pdf = new PDF();
$pdf->AddPage();
$pdf->SetFont('Arial', '', 10);

while($row = $result->fetch_assoc()) {
    $pdf->Cell(10, 10, $row['id'], 1);
    $pdf->Cell(30, 10, $row['group_name'], 1);
    $pdf->Cell(40, 10, $row['country_name'], 1);
    $pdf->Cell(20, 10, $row['matches_won'], 1);
    $pdf->Cell(20, 10, $row['matches_drawn'], 1);
    $pdf->Cell(20, 10, $row['matches_lost'], 1);
    $pdf->Cell(20, 10, $row['points'], 1);
    $pdf->Ln();
}

$pdf->Output();
?>
