<?php
include 'db.php';

if (isset($_GET['id'])) {
    $assignment_id = $_GET['id'];
    $stmt = $pdo->prepare("DELETE FROM assignments WHERE assignment_id=?");
    if ($stmt->execute([$assignment_id])) {
        header("Location: index.php"); // Redirect back to the main page
        exit();
    } else {
        echo "Error deleting assignment.";
    }
}
?>
