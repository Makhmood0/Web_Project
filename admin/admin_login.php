<?php
session_start();
if (isset($_SESSION['admin_logged_in'])) {
    header("Location: admin_home.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Login</title>
  <link rel="stylesheet" href="../css/admin.css">
</head>
<body>
  <div class="admin-container">
    <h2>Admin Login</h2>
    <form action="admin_auth.php" method="POST" class="admin-form">
      <input type="text" name="username" placeholder="Username" required>
      <input type="password" name="password" placeholder="Password" required>
      <button type="submit">Login</button>
    </form>

    <a href="../root/index.html" class="exit-btn">Exit Admin Page</a>
  </div>
</body>
</html>
