<?php
include 'db.php';

if (isset($_GET['id'])) {
    $equipment_id = $_GET['id'];
    $stmt = $pdo->prepare("DELETE FROM equipments WHERE equipment_id=?");
    if ($stmt->execute([$equipment_id])) {
        header("Location: index.php"); // Redirect back to the main page
        exit();
    } else {
        echo "Error deleting equipment.";
    }
}
?>
