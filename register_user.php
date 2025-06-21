<?php
session_start();
include('connect.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = htmlspecialchars(trim($_POST['username']));
    $email = htmlspecialchars(trim($_POST['email']));
    $password = trim($_POST['password']);
    $confirmPassword = trim($_POST['confirmpassword']);

    // Clear previous errors
    unset($_SESSION['errors']);

    // Validation
    $errors = [];
    if (empty($username) || empty($email) || empty($password) || empty($confirmPassword)) {
        $errors[] = "All fields are required.";
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format.";
    }

    if ($password !== $confirmPassword) {
        $errors[] = "Passwords do not match.";
    }

    if (strlen($password) < 8) {
        $errors[] = "Password must be at least 8 characters long.";
    }

    // Check for existing user
    if (empty($errors)) {
        $checkStmt = $conn->prepare("SELECT id FROM users WHERE email = ? OR username = ?");
        $checkStmt->bind_param("ss", $email, $username);
        $checkStmt->execute();
        $checkStmt->store_result();

        if ($checkStmt->num_rows > 0) {
            $errors[] = "The username or email is already registered.";
        }
        $checkStmt->close();
    }

    // Handle errors
    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        header("Location: registration.php");
        exit();
    }

    // Insert user (INSECURE - plain text password)
    try {
        $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $email, $password);

        if ($stmt->execute()) {
            $_SESSION['success'] = "Registration successful! Please login.";
            header("Location: index.php");
            exit();
        } else {
            $_SESSION['errors'] = ["Database error: " . $conn->error];
            header("Location: registration.php");
            exit();
        }
    } catch (Exception $e) {
        $_SESSION['errors'] = ["An unexpected error occurred: " . $e->getMessage()];
        header("Location: registration.php");
        exit();
    }

    $conn->close();
}