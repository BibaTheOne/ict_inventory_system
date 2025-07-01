<?php
include 'db.php';
include 'audit_log.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST["username"];
    $phone = $_POST["phone_number"];
    $email = $_POST["email"];
    $building = $_POST["building"];
    $floor = $_POST["floor"];
    $department = $_POST["department"];

    $stmt = $pdo->prepare("INSERT INTO users (username, phone_number, email, building, floor, department)
                           VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->execute([$username, $phone, $email, $building, $floor, $department]);

    audit_log("User Added", "Added user: $username");

    header("Location: index.php#users");
    exit();
}
