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
    <title>Manage Programmes</title>
    <link rel="stylesheet" href="../css/admin.css">
</head>
<body>
    <div class="admin-header">
        <h1>Manage Programmes</h1>
        <a href="admin_home.php" class="back-btn">Back to Dashboard</a>
    </div>

    <div class="admin-table-container">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($programmes as $p): ?>
                    <tr>
                        <td><?= $p['id'] ?></td>
                        <td><?= htmlspecialchars($p['title']) ?></td>
                        <td><?= htmlspecialchars($p['description']) ?></td>
                        <td>
                            <form action="delete_programme.php" method="POST" onsubmit="return confirm('Are you sure you want to delete this programme?');">
                                <input type="hidden" name="id" value="<?= $p['id'] ?>">
                                <button type="submit" style="color: red;">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
