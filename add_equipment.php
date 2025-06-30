<?php
include 'auth.php';
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $equipment_type = $_POST['equipment_type'];
    $equipment_name = $_POST['equipment_name'];
    $serial_no = $_POST['serial_no'];
    $barcode_no = $_POST['barcode_no'];

    $stmt = $pdo->prepare("INSERT INTO equipments (equipment_type, equipment_name, serial_no, barcode_no) VALUES (?, ?, ?, ?)");
    if ($stmt->execute([$equipment_type, $equipment_name, $serial_no, $barcode_no])) {
        header("Location: index.php"); // Redirect back to the main page
        exit();
    } else {
        echo "Error adding equipment.";
    }
}
?>
