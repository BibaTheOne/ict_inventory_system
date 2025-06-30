<?php
include 'auth.php';
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $equipment_id = $_POST['equipment_id'];
    $user_id = $_POST['user_id'];
    $date_issued = $_POST['date_issued'];

    $stmt = $pdo->prepare("INSERT INTO assignments (equipment_id, user_id, date_issued) VALUES (?, ?, ?)");
    if ($stmt->execute([$equipment_id, $user_id, $date_issued])) {
        header("Location: index.php"); // Redirect back to the main page
        exit();
    } else {
        echo "Error adding assignment.";
    }
}
?>
