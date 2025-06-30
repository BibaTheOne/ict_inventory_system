<?php
include 'auth.php';
include 'db.php';

if (isset($_GET['id'])) {
    $user_id = $_GET['id'];
    $stmt = $pdo->prepare("DELETE FROM users WHERE user_id=?");
    if ($stmt->execute([$user_id])) {
        header("Location: index.php"); // Redirect back to the main page
        exit();
    } else {
        echo "Error deleting user.";
    }
}
?>
