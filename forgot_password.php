<?php
session_start();
include 'db.php';

$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST['username'];

    $stmt = $pdo->prepare("SELECT * FROM admin WHERE username = ?");
    $stmt->execute([$username]);
    $admin = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($admin) {
        $_SESSION['reset_user'] = $admin['username'];
        header("Location: reset_password.php");
        exit();
    } else {
        $message = "No admin found with that username.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Forgot Password</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<div class="container">
    <h2>Forgot Password</h2>
    <?php if ($message) echo "<p style='color:red;'>$message</p>"; ?>
    <form method="POST">
        <input type="text" name="username" placeholder="Enter your username" required><br>
        <button type="submit">Proceed to Reset</button>
        <p><a href="login.php">Back to Login</a></p>
    </form>
</div>
</body>
</html>
