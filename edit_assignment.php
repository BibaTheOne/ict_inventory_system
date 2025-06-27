<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $assignment_id = $_POST['assignment_id'];
    $return_date = $_POST['return_date'];
    $return_status = $_POST['return_status'];

    $stmt = $pdo->prepare("UPDATE assignments SET return_date=?, return_status=? WHERE assignment_id=?");
    if ($stmt->execute([$return_date, $return_status, $assignment_id])) {
        header("Location: index.php"); // Redirect back to the main page
        exit();
    } else {
        echo "Error updating assignment.";
    }
}
?>
