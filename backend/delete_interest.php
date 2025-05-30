<?php
header('Content-Type: application/json');
require 'db.php';

$data = json_decode(file_get_contents("php://input"), true);
$email = $data['email'];
$programme_id = $data['programme_id'];

try {
    $stmt = $pdo->prepare("DELETE FROM interests WHERE email = ? AND programme_id = ?");
    $stmt->execute([$email, $programme_id]);

    if ($stmt->rowCount()) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false, "message" => "No matching record found."]);
    }
} catch (Exception $e) {
    echo json_encode(["success" => false, "message" => $e->getMessage()]);
}
?>
