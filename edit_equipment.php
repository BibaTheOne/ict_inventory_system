<?php
include 'auth.php';
include 'db.php';
if (!is_logged_in() || (!is_ict() && !is_hod())) {
    header("Location: unauthorized.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $equipment_id = $_POST['equipment_id'];
    $equipment_type = $_POST['equipment_type'];
    $equipment_name = $_POST['equipment_name'];
    $serial_no = $_POST['serial_no'];
    $barcode_no = $_POST['barcode_no'];

    $stmt = $pdo->prepare("UPDATE equipments SET equipment_type=?, equipment_name=?, serial_no=?, barcode_no=? WHERE equipment_id=?");
    if ($stmt->execute([$equipment_type, $equipment_name, $serial_no, $barcode_no, $equipment_id])) {
        header("Location: index.php"); // Redirect back to the main page
        exit();
    } else {
        echo "Error updating equipment.";
    }
} else {
    $equipment_id = $_GET['id'];
    $stmt = $pdo->prepare("SELECT * FROM equipments WHERE equipment_id=?");
    $stmt->execute([$equipment_id]);
    $equipment = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Edit Equipment</title>
</head>
<body>
    <h2>Edit Equipment</h2>
    <form method="POST" action="edit_equipment.php">
        <input type="hidden" name="equipment_id" value="<?php echo $equipment['equipment_id']; ?>">
        <input type="text" name="equipment_type" value="<?php echo $equipment['equipment_type']; ?>" required>
        <input type="text" name="equipment_name" value="<?php echo $equipment['equipment_name']; ?>" required>
        <input type="text" name="serial_no" value="<?php echo $equipment['serial_no']; ?>" required>
        <input type="text" name="barcode_no" value="<?php echo $equipment['barcode_no']; ?>" required>
        <button type="submit">Update Equipment</button>
    </form>
</body>
</html>
