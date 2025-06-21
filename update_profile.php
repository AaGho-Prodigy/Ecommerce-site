<?php
session_start();
require 'connect.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$new_username = trim($_POST['username']);
$new_email = trim($_POST['email']);
$password = $_POST['password'];

$query = $conn->prepare("SELECT email, password FROM users WHERE id = ?");
$query->bind_param("i", $user_id);
$query->execute();
$current_user = $query->get_result()->fetch_assoc();

if ($password !== $current_user['password']) {
    die("Incorrect password.");
}

$email_check = $conn->prepare("SELECT id FROM users WHERE email = ? AND id != ?");
$email_check->bind_param("si", $new_email, $user_id);
$email_check->execute();
if ($email_check->get_result()->num_rows > 0) {
    die("Email is already taken.");
}

$update = $conn->prepare("UPDATE users SET username = ?, email = ? WHERE id = ?");
$update->bind_param("ssi", $new_username, $new_email, $user_id);
$update->execute();

if ($new_email !== $current_user['email']) {
    mail($current_user['email'], "Email Changed", "Your email was changed to: $new_email");
    mail($new_email, "Email Updated", "Your new email is now active.");
}

echo "Profile updated successfully.";
?>
