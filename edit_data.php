<?php
session_start();
if (!isset($_SESSION['nim'])) {
    header("Location: login.php");
    exit();
}
include 'config.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM countries WHERE id='$id'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        echo "Data tidak ditemukan";
        exit();
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $group_id = $_POST['group_id'];
    $country_name = $_POST['country_name'];
    $matches_won = $_POST['matches_won'];
    $matches_drawn = $_POST['matches_drawn'];
    $matches_lost = $_POST['matches_lost'];
    $points = $_POST['points'];

    $sql = "UPDATE countries SET group_id='$group_id', country_name='$country_name', matches_won='$matches_won', matches_drawn='$matches_drawn', matches_lost='$matches_lost', points='$points' WHERE id='$id'";
    
    if ($conn->query($sql) === TRUE) {
        header("Location: view_data.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Ambil data grup dari database
$groups = $conn->query("SELECT id, name FROM groups");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Data Negara UEFA 2024</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <form method="post" action="edit_data.php">
            <h2>Edit Data Negara UEFA 2024</h2>
            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
            <label for="group_id">Grup:</label>
            <select id="group_id" name="group_id">
                <?php while($group = $groups->fetch_assoc()): ?>
                    <option value="<?php echo $group['id']; ?>" <?php if ($group['id'] == $row['group_id']) echo 'selected'; ?>><?php echo $group['name']; ?></option>
                <?php endwhile; ?>
            </select>
            <label for="country_name">Nama Negara:</label>
            <input type="text" id="country_name" name="country_name" value="<?php echo $row['country_name']; ?>" required>
            <label for="matches_won">Jumlah Menang:</label>
            <input type="number" id="matches_won" name="matches_won" value="<?php echo $row['matches_won']; ?>" required>
            <label for="matches_drawn">Jumlah Seri:</label>
            <input type="number" id="matches_drawn" name="matches_drawn" value="<?php echo $row['matches_drawn']; ?>" required>
            <label for="matches_lost">Jumlah Kalah:</label>
            <input type="number" id="matches_lost" name="matches_lost" value="<?php echo $row['matches_lost']; ?>" required>
            <label for="points">Jumlah Poin:</label>
            <input type="number" id="points" name="points" value="<?php echo $row['points']; ?>" required>
            <button type="submit">Update</button>
        </form>
        <a href="view_data.php">Kembali</a>
    </div>
</body>
</html>
