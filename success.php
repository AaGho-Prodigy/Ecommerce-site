<?php
session_start();
$payment_id = $_GET['payment_id'] ?? '';
?>
<!DOCTYPE html>
<html>
<head>
    <title>Payment Successful</title>
    <style>
        body { font-family: Arial, sans-serif; text-align: center; padding: 50px; }
        .success-message { color: #28a745; font-size: 24px; margin-bottom: 20px; }
    </style>
</head>
<body>
    <div class="success-message">Payment Successful! 🎉</div>
    <p>Thank you for your purchase.</p>
    <p>Payment ID: <?php echo htmlspecialchars($payment_id); ?></p>
    <a href="index.php">Return to Home</a>
</body>
</html>