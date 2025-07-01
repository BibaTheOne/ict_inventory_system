<?php
include 'db.php';

$q = $_GET['q'] ?? '';

$stmt = $pdo->prepare("SELECT user_id, username, department FROM users WHERE username LIKE ? LIMIT 10");
$stmt->execute(["%$q%"]);

$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

header('Content-Type: application/json');
echo json_encode($results);
