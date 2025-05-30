<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
require 'db.php';

// Fetch all programmes
$stmt = $pdo->query("SELECT * FROM programmes");
$rawProgrammes = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Convert 'modules' and 'tutors' to arrays if not null, else use empty arrays
$programmes = [];
foreach ($rawProgrammes as $p) {
    $p['modules'] = $p['modules'] ? json_decode($p['modules'], true) : [];
    $p['tutors'] = $p['tutors'] ? json_decode($p['tutors'], true) : [];
    $programmes[] = $p;
}

header('Content-Type: application/json');
echo json_encode($programmes);
