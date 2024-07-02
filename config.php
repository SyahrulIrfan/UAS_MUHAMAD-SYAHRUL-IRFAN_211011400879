<?php
$host = 'localhost'; // Sesuaikan dengan host MySQL Anda
$username = 'root'; // Sesuaikan dengan username MySQL Anda
$password = ''; // Sesuaikan dengan password MySQL Anda
$database = 'ueafa2024'; // Sesuaikan dengan nama database yang Anda buat

// Membuat koneksi
$conn = new mysqli($host, $username, $password, $database);

// Memeriksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>
