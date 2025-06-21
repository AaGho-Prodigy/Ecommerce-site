<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "registration");

if (!$conn) die("Connection failed: " . mysqli_connect_error());

if (!isset($_GET['order_id'])) die("Order ID not provided.");
$order_id = (int)$_GET['order_id'];

// Fetch order details
$order_query = "SELECT o.total_price, o.status, o.payment_status, o.created_at, u.username 
                FROM orders o 
                JOIN users u ON o.user_id = u.id 
                WHERE o.id = ?";
$stmt = mysqli_prepare($conn, $order_query);
mysqli_stmt_bind_param($stmt, 'i', $order_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (!$result) die("Failed to execute order query: " . mysqli_error($conn));
$order = mysqli_fetch_assoc($result);
if (!$order) die("Order not found.");

// Fetch order items
$order_items_query = "SELECT oi.quantity, oi.product_id, p.title AS product_name, p.price 
                      FROM order_items oi 
                      JOIN products p ON oi.product_id = p.id 
                      WHERE oi.order_id = ?";
$stmt_items = mysqli_prepare($conn, $order_items_query);
mysqli_stmt_bind_param($stmt_items, 'i', $order_id);
mysqli_stmt_execute($stmt_items);
$result_items = mysqli_stmt_get_result($stmt_items);

if (!$result_items) die("Failed to execute order items query: " . mysqli_error($conn));

// Handle delivery confirmation
if (isset($_POST['confirm_delivery'])) {
    $update_query = "UPDATE orders SET status = 'user_confirmed' WHERE id = ?";
    $stmt_update = mysqli_prepare($conn, $update_query);
    mysqli_stmt_bind_param($stmt_update, 'i', $order_id);
    if (mysqli_stmt_execute($stmt_update)) {
        header("Location: order_confirmation.php?order_id=$order_id");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="order_confirmation.css">
    <link rel="stylesheet" href="header.css">
</head>
<body>
    <?php include 'header.php'; ?>  
    <div class="container">
        <h1>Order Confirmation</h1>
        
        <div class="order-meta">
            <div class="meta-item">
                <strong>Order ID</strong>
                #<?= $order_id ?>
            </div>
            <div class="meta-item">
                <strong>Username</strong>
                <?= htmlspecialchars($order['username']) ?>
            </div>
            <div class="meta-item">
                <strong>Order Date</strong>
                <?= date('M j, Y g:i A', strtotime($order['created_at'])) ?>
            </div>
            <div class="meta-item">
                <strong>Total Price</strong>
                <span class="price">NRP. <?= number_format($order['total_price'], 2) ?></span>
            </div>
        </div>

        <div class="status-info">
            <div class="meta-item">
                <strong>Order Status</strong>
                <?= ucfirst(htmlspecialchars($order['status'])) ?>
            </div>
            <div class="meta-item">
                <strong>Payment Status</strong>
                <?= ucfirst(htmlspecialchars($order['payment_status'])) ?>
            </div>
        </div>

        <h3>Order Items</h3>
        <table>
            <thead>
                <tr>
                    <th>Product Name</th>
                    <th>Quantity</th>
                    <th>Unit Price</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($item = mysqli_fetch_assoc($result_items)): ?>
                    <tr>
                        <td><?= htmlspecialchars($item['product_name']) ?></td>
                        <td><?= $item['quantity'] ?></td>
                        <td>NRP. <?= number_format($item['price'], 2) ?></td>
                        <td>NRP. <?= number_format($item['price'] * $item['quantity'], 2) ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <?php if ($order['status'] != 'user_confirmed'): ?>
            <form method="POST">
                <button type="submit" name="confirm_delivery">Confirm Delivery</button>
                <p class="hint">Click to confirm you've received this order</p>
            </form>
        <?php else: ?>
            <div class="status-badge">
                ✔️ Order Confirmed
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
<?php mysqli_close($conn); ?>