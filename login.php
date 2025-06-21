<?php
session_start();
include('connect.php');

ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(0);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if (empty($username) || empty($password)) {
        $_SESSION['error'] = "Both username and password are required.";
        header("Location: login.php");
        exit();
    }

    $stmt = $conn->prepare("SELECT id, username, password, role FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        if ($password === $user['password']) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['user_role'] = $user['role'];
            
            $redirect = ($user['role'] === 'admin') ? 'admin.php' : 'index.php';
            header("Location: $redirect");
            exit();
        } else {
            $_SESSION['error'] = "Invalid credentials.";
        }
    } else {
        $_SESSION['error'] = "User not found.";
    }

    $stmt->close();
    header("Location: login.php");
    exit();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="login.css">
    <link rel="stylesheet" href="header.css">
</head>
<body>
    <?php include 'header.php'; ?>

    <div class="background">
        <div class="login-container">
            <h2 style="color:white;" >Login</h2>
            <?php if (isset($_SESSION['error'])): ?>
                <p class="error-message"><?= htmlspecialchars($_SESSION['error']) ?></p>
                <?php unset($_SESSION['error']); ?>
            <?php endif; ?>
            <form method="POST" action="login.php">
                <div class="input-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" 
                           value="<?= isset($_POST['username']) ? htmlspecialchars($_POST['username']) : '' ?>" 
                           required>
                </div>
                <div class="input-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <button type="submit" class="login-btn">Login</button>
                <p style="color:white;" class="register-link">Don't have an account? <a href="registration.php">Sign Up</a></p>
            </form>
        </div>
    </div>
</body>
</html>
