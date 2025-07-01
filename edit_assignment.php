<?php
include 'db.php';
include 'security.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $assignment_id = $_POST['assignment_id'];
    $return_status = $_POST['return_status'];
    $return_date = $_POST['return_date'] ?? null;
    $return_condition = $_POST['return_condition'] ?? null;

    $stmt = $pdo->prepare("UPDATE assignments SET return_status = ?, return_date = ?, return_condition = ? WHERE assignment_id = ?");
    $stmt->execute([$return_status, $return_date, $return_condition, $assignment_id]);

    header("Location: index.php#assignments");
    exit();
}

// After the assignment update
$stmt = $pdo->prepare("UPDATE assignments SET return_status = ?, return_date = ?, return_condition = ? WHERE assignment_id = ?");
$stmt->execute([$return_status, $return_date, $return_condition, $assignment_id]);

// Log history
$stmt2 = $pdo->prepare("
    INSERT INTO equipment_history (equipment_id, user_id, date_issued, return_date, return_condition, action)
    SELECT equipment_id, user_id, date_issued, ?, ?, 'Returned'
    FROM assignments WHERE assignment_id = ?
");
$stmt2->execute([$return_date, $return_condition, $assignment_id]);
