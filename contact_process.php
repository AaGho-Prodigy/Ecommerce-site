<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = htmlspecialchars(trim($_POST['name']));
    $email = htmlspecialchars(trim($_POST['email']));
    $subject = htmlspecialchars(trim($_POST['subject']));
    $message = htmlspecialchars(trim($_POST['message']));

    // Basic validation
    $errors = [];

    if (empty($name)) {
        $errors[] = "Name is required";
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format";
    }

    if (empty($subject)) {
        $errors[] = "Subject is required";
    }

    if (empty($message)) {
        $errors[] = "Message is required";
    }

    if (empty($errors)) {
        // Process the message (you should implement actual email sending here)
        // For now, just store in session
        $_SESSION['contact_success'] = "Thank you for your message! We'll respond within 24 hours.";
    } else {
        $_SESSION['contact_errors'] = $errors;
        $_SESSION['form_data'] = $_POST;
    }

    header("Location: contact.php");
    exit();
}