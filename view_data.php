<?php
session_start();
if (!isset($_SESSION['nim'])) {
    header("Location: login.php");
    exit();
}
include 'config.php';

// Menghapus data
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $sql = "DELETE FROM countries WHERE id='$delete_id'";
    if ($conn->query($sql) === TRUE) {
        header("Location: view_data.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Ambil data dari tabel countries
$sql = "SELECT countries.id, groups.group_name AS group_name, countries.country_name, countries.matches_won, countries.matches_drawn, countries.matches_lost, countries.points 
        FROM countries 
        JOIN groups ON countries.group_id = groups.id";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Negara UEFA 2024</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Data Negara UEFA 2024</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Grup</th>
                    <th>Nama Negara</th>
                    <th>Menang</th>
                    <th>Seri</th>
                    <th>Kalah</th>
                    <th>Poin</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result && $result->num_rows > 0): ?>
                    <?php while($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo $row['group_name']; ?></td>
                            <td><?php echo $row['country_name']; ?></td>
                            <td><?php echo $row['matches_won']; ?></td>
                            <td><?php echo $row['matches_drawn']; ?></td>
                            <td><?php echo $row['matches_lost']; ?></td>
                            <td><?php echo $row['points']; ?></td>
                            <td>
                                <a href="edit_data.php?id=<?php echo $row['id']; ?>">Edit</a>
                                <a href="view_data.php?delete_id=<?php echo $row['id']; ?>" onclick="return confirm('Anda yakin ingin menghapus data ini?')">Hapus</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8">Tidak ada data yang ditemukan</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
        <a href="dashboard.php">Kembali ke Dashboard</a>
        <a href="print_pdf.php" target="_blank">Cetak PDF</a>
    </div>
</body>
</html>
