<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
require '../backend/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'] ?? null;
    $description = $_POST['description'] ?? null;
    $imageName = $_POST['image'] ?? null;

    
    if ($title && $description && $imageName) {
        
        $imagePath = "../images/" . basename($imageName);

        $stmt = $pdo->prepare("INSERT INTO programmes (title, description, image) VALUES (?, ?, ?)");
        $stmt->execute([$title, $description, $imagePath]);
        echo "<p style='color: green;'>✅ Programme added successfully!</p>";
    } else {
        echo "<p style='color: red;'>❌ Missing title, description, or image filename.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Programme</title>
    <link rel="stylesheet" href="../css/admin.css">
</head>
<body>

<div class="admin-header">
    <h1>Add Programme</h1>
    <a href="admin_home.php" class="back-btn">⬅ Back to Dashboard</a>
</div>

<div class="form-container">
    <form method="POST">
        <label>Programme Title:</label>
        <input type="text" name="title" required>

        <label>Description:</label>
        <textarea name="description" required></textarea>

        <label>Image Filename (e.g. cs_ai.jpg):</label>
        <input type="text" name="image" required>

        <button type="submit">Add Programme</button>
    </form>
</div>

</body>
</html>
