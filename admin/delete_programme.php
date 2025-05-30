<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin_login.php");
    exit;
}
require '../backend/db.php';

$id = $_POST['id'];
$stmt = $pdo->prepare("DELETE FROM programmes WHERE id = ?");
$stmt->execute([$id]);

header("Location: manage_programmes.php");
