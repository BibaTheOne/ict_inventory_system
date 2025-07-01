<?php
include 'auth.php';
include 'db.php';
if (!is_logged_in() || (!is_ict() && !is_hod())) {
    header("Location: unauthorized.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_POST['user_id'];
    $username = $_POST['username'];
    $phone_number = $_POST['phone_number'];
    $email = $_POST['email'];
    $building = $_POST['building'];
    $floor = $_POST['floor'];
    $department = $_POST['department'];

    $stmt = $pdo->prepare("UPDATE users SET username=?, phone_number=?, email=?, building=?, floor=?, department=? WHERE user_id=?");
    if ($stmt->execute([$username, $phone_number, $email, $building, $floor, $department, $user_id])) {
        header("Location: index.php"); // Redirect back to the main page
        exit();
    } else {
        echo "Error updating user.";
    }
} else {
    $user_id = $_GET['id'];
    $stmt = $pdo->prepare("SELECT * FROM users WHERE user_id=?");
    $stmt->execute([$user_id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Edit User</title>
</head>

<body>
    <h2>Edit User</h2>
    <form method="POST" action="edit_user.php">
        <input type="hidden" name="user_id" value="<?php echo $user['user_id']; ?>">
        <input type="text" name="username" value="<?php echo $user['username']; ?>" required>
        <input type="text" name="phone_number" value="<?php echo $user['phone_number']; ?>" required>
        <input type="email" name="email" value="<?php echo $user['email']; ?>" required>
        <input type="text" name="building" value="<?php echo $user['building']; ?>" required>
        <input type="text" name="floor" value="<?php echo $user['floor']; ?>" required>
        <input type="text" name="department" value="<?php echo $user['department']; ?>" required>
        <button type="submit">Update User</button>
    </form>
</body>

</html>