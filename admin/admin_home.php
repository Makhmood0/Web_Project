<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin_login.php");
    exit;
}
require '../backend/db.php';

// Fetch all programmes
$programmes = $pdo->query("SELECT * FROM programmes")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Dashboard</title>
  <link rel="stylesheet" href="../css/admin.css">
</head>
<body>
  <div class="admin-header">
    <h1>Admin Dashboard</h1>
    <a href="logout.php" class="logout-btn">Logout</a>
  </div>

  <div class="admin-grid">
  <a class="admin-card" href="add_programme.php">
    <h2>Add New Programme</h2>
    <p>Create and list a new academic programme.</p>
  </a>

  <a class="admin-card" href="manage_programmes.php">
    <h2>Manage Programmes</h2>
    <p>View or delete academic programmes.</p>
  </a>

  <a class="admin-card" href="view_interests.php">
    <h2>View Interests</h2>
    <p>See all student course registrations.</p>
  </a>
</div>

</body>
</html>
