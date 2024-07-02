<?php
session_start();
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nim = $_POST['nim'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE nim='$nim'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            $_SESSION['nim'] = $nim;
            header("Location: dashboard.php");
        } else {
            echo "Password salah!";
        }
    } else {
        echo "NIM tidak ditemukan!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login UEFA 2024</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <form method="post" action="login.php">
        <h2>Login</h2>
        <label for="nim">NIM:</label>
        <input type="text" id="nim" name="nim" required>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        <button type="submit">Login</button>
        <p>Belum punya akun? <a href="register.php">Registrasi</a></p>
    </form>
</body>
</html>
