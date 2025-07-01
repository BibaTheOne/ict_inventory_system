<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include 'db.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    $stmt = $pdo->prepare("SELECT * FROM admin WHERE username = ?");
    $stmt->execute([$username]);
    $admin = $stmt->fetch();

    if ($admin && password_verify($password, $admin['password'])) {
        $_SESSION['admin'] = $admin['username'];
        $_SESSION['role'] = $admin['role'];
        header("Location: index.php");
        exit();
    } else {
        $error = "Invalid username or password.";
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Admin Login</title>
    <style>
        body {
            background: #f2f2f2;
            font-family: Arial, sans-serif;
        }

        .login-container {
            max-width: 400px;
            margin: 80px auto;
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #333;
        }

        .form-group {
            margin-bottom: 20px;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 6px;
        }

        button {
            background: #3498db;
            color: #fff;
            padding: 12px;
            width: 100%;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 16px;
        }

        button:hover {
            background: #2980b9;
        }

        .error {
            color: red;
            margin-bottom: 15px;
            text-align: center;
        }

        .form-footer {
            text-align: center;
            margin-top: 10px;
        }

        .show-password {
            display: flex;
            align-items: center;
            margin-top: -15px;
            margin-bottom: 20px;
        }

        .show-password input[type="checkbox"] {
            margin-right: 8px;
        }
    </style>
</head>

<body>

    <div class="login-container">
        <h2>Admin Login</h2>

        <?php if (!empty($error)): ?>
            <div class="error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form method="POST" autocomplete="off">
            <div class="form-group">
                <input type="text" name="username" placeholder="Username" required autofocus>
            </div>

            <div class="form-group">
                <input type="password" id="password" name="password" placeholder="Password" required>
            </div>

            <div class="show-password">
                <input type="checkbox" onclick="togglePassword()"> <label for="password">Show Password</label>
            </div>

            <button type="submit">Login</button>
        </form>

        <div class="form-footer">
            <a href="forgot_password.php">Forgot Password?</a>
        </div>
    </div>

    <script>
        function togglePassword() {
            var pwd = document.getElementById("password");
            if (pwd.type === "password") {
                pwd.type = "text";
            } else {
                pwd.type = "password";
            }
        }
    </script>

</body>

</html>