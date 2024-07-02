<?php
session_start();

if (!isset($_SESSION['nim'])) {
  header("Location: login.php");
  exit();
}

include 'config.php';

$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $group_id = $_POST['group_id'];
  $country_name = $_POST['country_name'];
  $matches_won = $_POST['matches_won'];
  $matches_drawn = $_POST['matches_drawn'];
  $matches_lost = $_POST['matches_lost'];
  $points = $_POST['points'];

  // Prepare statement
  $stmt = $conn->prepare("INSERT INTO countries (group_id, country_name, matches_won, matches_drawn, matches_lost, points) VALUES (?, ?, ?, ?, ?, ?)");
  $stmt->bind_param("isiiii", $group_id, $country_name, $matches_won, $matches_drawn, $matches_lost, $points);

  // Execute statement
  if ($stmt->execute()) {
    header("Location: view_data.php");
    exit();
  } else {
    $error = "Gagal menambahkan data";
  }

  // Tutup statement
  $stmt->close();
}

// Ambil data grup (hanya Grup A, Grup B, dan Grup C)
$groups = $conn->query("SELECT id, group_name FROM groups WHERE group_name IN ('Grup A', 'Grup B', 'Grup C')");
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Input Data - UEFA 2024</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
  <h2>Input Data Negara UEFA 2024</h2>
  <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <label for="group_id">Grup:</label>
    <select id="group_id" name="group_id" required>
      <?php while ($group = $groups->fetch_assoc()): ?>
        <option value="<?php echo $group['id']; ?>"><?php echo $group['group_name']; ?></option>
      <?php endwhile; ?>
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

    <button type="submit">Simpan</button>

    <?php if ($error): ?>
      <p class="error"><?php echo $error; ?></p>
    <?php endif; ?>
  </form>
</div>
</body>
</html>
