<?php
session_start();
require '../backend/db.php';

$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

$stmt = $pdo->prepare("SELECT * FROM admin_users WHERE username = ?");
$stmt->execute([$username]);
$admin = $stmt->fetch();

if ($admin && hash('sha256', $password) === $admin['password_hash']) {
    $_SESSION['admin_logged_in'] = true;
    header("Location: admin_home.php");
    exit;
} else {
    echo "<p style='color:red;'>Invalid login. <a href='admin_login.php'>Try again</a></p>";
}
