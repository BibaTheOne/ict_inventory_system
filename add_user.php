<?php
include 'auth.php';
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $phone_number = $_POST['phone_number'];
    $email = $_POST['email'];
    $building = $_POST['building'];
    $floor = $_POST['floor'];
    $department = $_POST['department'];

    $stmt = $pdo->prepare("INSERT INTO users (username, phone_number, email, building, floor, department) VALUES (?, ?, ?, ?, ?, ?)");
    if ($stmt->execute([$username, $phone_number, $email, $building, $floor, $department])) {
        header("Location: index.php"); // Redirect back to the main page
        exit();
    } else {
        echo "Error adding user.";
    }
}
?>
