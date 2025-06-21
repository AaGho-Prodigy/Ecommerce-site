<?php
session_start();
require 'connect.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

$query = $conn->prepare("SELECT username, email FROM users WHERE id = ?");
$query->bind_param("i", $user_id);
$query->execute();
$user = $query->get_result()->fetch_assoc();

$success = $_GET['success'] ?? null;
$error = $_GET['error'] ?? null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Settings</title>
    <link rel="stylesheet" href="header.css">
    <link rel="stylesheet" href="profile.css">

</head>
<body>
    <?php include 'header.php'; ?>
    
    <div class="profile-container">
        <?php if ($success): ?>
            <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
        <?php endif; ?>
        
        <?php if ($error): ?>
            <div class="alert alert-error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <h2>Update Profile</h2>
        <form class="profile-form" action="update_profile.php" method="POST">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" 
                       id="username" 
                       name="username" 
                       value="<?= htmlspecialchars($user['username']) ?>" 
                       required>
            </div>

            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" 
                       id="email" 
                       name="email" 
                       value="<?= htmlspecialchars($user['email']) ?>" 
                       required>
            </div>

            <div class="form-group">
                <label for="password">Confirm Password</label>
                <input type="password" 
                       id="password" 
                       name="password" 
                       placeholder="Enter current password to confirm changes" 
                       required>
            </div>

            <button type="submit">Save Changes</button>
        </form>
    </div>
    <a href="user_confirm_delivery.php"><button style="padding: 10px; background-color: blue; color: white; border-radius: 5px; margin-left: 1010px; cursor: pointer;">My Orders</button></a>

</body>
</html>