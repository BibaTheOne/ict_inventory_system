<?php
function audit_log($action, $description)
{
    include 'db.php';
    $admin = $_SESSION['admin'] ?? 'unknown';
    $stmt = $pdo->prepare("INSERT INTO audit_logs (admin_user, action, description, log_time) VALUES (?, ?, ?, NOW())");
    $stmt->execute([$admin, $action, $description]);
}
