<?php
include 'auth.php';
include 'db.php';
if (!is_logged_in() || (!is_ict() && !is_hod())) {
    header("Location: unauthorized.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $equipment_id = $_POST['equipment_id'];
    $user_id = $_POST['user_id'];
    $date_issued = date('Y-m-d'); // auto-assign today

    $stmt = $pdo->prepare("INSERT INTO assignments (equipment_id, user_id, date_issued) VALUES (?, ?, ?)");
    if ($stmt->execute([$equipment_id, $user_id, $date_issued])) {
        header("Location: index.php");
        exit();
    } else {
        echo "Error adding assignment.";
    }
}
