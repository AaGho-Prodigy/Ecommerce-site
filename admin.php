<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="header.css">
    <script src="addproduct.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
        }

        .container {
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #333;
        }

        .tabs {
            display: flex;
            border-bottom: 2px solid #ddd;
        }

        .tab {
            padding: 10px 20px;
            cursor: pointer;
            color: #333;
            border: 1px solid #ddd;
            border-bottom: none;
            background: #f9f9f9;
            font-weight: bold;
        }

        .tab.active {
            background: #fff;
            border-top: 2px solid #007bff;
            color: #007bff;
        }

        .tab-content {
            display: none;
        }

        .tab-content.active {
            display: block;
            padding: 20px;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        input, textarea, button, select {
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
        }

        button {
            background: #007bff;
            color: #fff;
            border: none;
            cursor: pointer;
        }

        button:hover {
            background: #0056b3;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 10px;
            text-align: center;
        }

        th {
            background: #f9f9f9;
        }

        #editForm {
            display: none;
            background: #f4f4f9;
            padding: 20px;
            border-radius: 8px;
            margin-top: 20px;
        }
    </style>
    </head>
<?php

session_start();

if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: index.php");
    exit();
}
?>
<body>
    <?php include 'header.php'; ?>
    <div class="container">
        <h1>Admin Panel</h1>

        <div class="tabs">
            <div class="tab active" data-target="#add-product">Add Product</div>
            <div class="tab" data-target="#view-products">View Products</div>
            <div class="tab" data-target="#view-users">View Users</div>
            <div class="tab" data-target="#view-orders">View Orders</div>
        </div>

        <div class="tab-content active" id="add-product">
    <h2>Add New Product</h2>
    <form action="addproduct.php" method="post" enctype="multipart/form-data">
        <input type="text" name="title" placeholder="Title" required>
        <textarea name="description" placeholder="Description" required></textarea>
        <textarea name="category" placeholder="Category" required></textarea>
        <input type="number" name="price" placeholder="Price" required>
        <input type="number" name="quantity" placeholder="Quantity" required> <!-- Add this line -->
        <input type="file" name="image" accept="image/*" required>
        <button type="submit">Submit</button>
    </form>
</div>


<div class="tab-content" id="view-products">
    <h2>Available Products</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Description</th>
                <th>Price</th>
                <th>Quantity</th> 
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $conn = mysqli_connect("localhost", "root", "", "registration");

            if (!$conn) {
                die("Connection failed: " . mysqli_connect_error());
            }

            $sql = "SELECT id, title, description, price, quantity FROM products"; // Include quantity
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                        <td>{$row['id']}</td>
                        <td>{$row['title']}</td>
                        <td>{$row['description']}</td>
                        <td>{$row['price']}</td>
                        <td>{$row['quantity']}</td> <!-- Show quantity -->
                        <td>
                            <button onclick=\"openProductEditForm({$row['id']}, '{$row['title']}', '{$row['description']}', '{$row['price']}', '{$row['quantity']}')\">Edit</button>
                            <form action='delete_product.php' method='post' style='display:inline;'>
                                <input type='hidden' name='id' value='{$row['id']}'>
                                <button type='submit' onclick=\"return confirm('Are you sure?')\">Delete</button>
                            </form>
                        </td>
                    </tr>";
                }
            } else {
                echo "<tr><td colspan='6'>No products found</td></tr>";
            }

            $conn->close();
            ?>
        </tbody>
    </table>
</div>


        <div class="tab-content" id="view-users">
            <h2>Total Registered Users</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $conn = mysqli_connect("localhost", "root", "", "registration");

                    if (!$conn) {
                        die("Connection failed: " . mysqli_connect_error());
                    }

                    $sql = "SELECT id, username, email FROM users";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>
                                <td>{$row['id']}</td>
                                <td>{$row['username']}</td>
                                <td>{$row['email']}</td>
                                <td>
                                    <button onclick=\"openEditForm({$row['id']}, '{$row['username']}', '{$row['email']}')\">Edit</button>
                                    <form action='delete_user.php' method='post' style='display:inline;'>
                                        <input type='hidden' name='id' value='{$row['id']}'>
                                        <button type='submit' onclick=\"return confirm('Are you sure?')\">Delete</button>
                                    </form>
                                </td>
                            </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='4'>No users found</td></tr>";
                    }

                    $conn->close();
                    ?>
                </tbody>
            </table>
        </div>

       <div class="tab-content" id="view-orders">
    <h2>View Orders</h2>
    <table>
        <thead>
            <tr>
                <th>Order ID</th>
                <th>Username</th>
                <th>Email</th>
                <th>Product</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Total Price</th>
                <th>User Confirmed</th>
                <th>Admin Confirmed</th>
            </tr>
        </thead>
        <tbody>
        <?php
$conn = mysqli_connect("localhost", "root", "", "registration");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$sql = "SELECT 
          o.id AS order_id, 
          u.username, 
          u.email, 
          oi.product_id, 
          oi.quantity, 
          o.total_price, 
          o.status, 
          o.payment_status, 
          o.created_at,
          o.user_confirmed_at,
          o.admin_confirmed_at,
          p.title AS product_name,   
          p.price
        FROM orders o
        JOIN order_items oi ON o.id = oi.order_id
        JOIN users u ON o.user_id = u.id
        JOIN products p ON oi.product_id = p.id
        ORDER BY o.created_at DESC"; 

$result = $conn->query($sql);

if ($result) {
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $userConfirmed = ($row['status'] === 'User_Confirmed') ? 'Yes' : 'No';
            $adminConfirmed = !is_null($row['admin_confirmed_at']) ? 'Yes' : 'No';
            
            $price = number_format($row['price'], 2);
            $totalPrice = number_format($row['total_price'], 2);

            echo "<tr>
                    <td>{$row['order_id']}</td>
                    <td>{$row['username']}</td>
                    <td>{$row['email']}</td>
                    <td>{$row['product_name']}</td>
                    <td>{$row['quantity']}</td>
                    <td>NRP.{$price}</td>
                    <td>NRP.{$totalPrice}</td>
                    <td>{$userConfirmed}</td>
                    <td>{$adminConfirmed}</td>
                    <td>";
if ($adminConfirmed === 'No') {
    $buttonDisabled = ($row['payment_status'] === 'paid') ? 'disabled style=\"background:#ccc\"' : '';
    $buttonText = ($row['payment_status'] === 'paid') ? 'Paid' : 'Mark Paid';
    echo "<form action='process_mark_paid.php' method='POST'>
            <input type='hidden' name='order_id' value='{$row['order_id']}'>
            <button type='submit' {$buttonDisabled}>{$buttonText}</button>
          </form>";
} else {
    echo "<span style='color: gray;'>You Confirmed</span>";
}
echo "</td>";

             echo   "</tr>";
        }
    } else {
        echo "<tr><td colspan='11'>No orders found</td></tr>";
    }
} else {
    echo "<tr><td colspan='11'>Error fetching orders: " . $conn->error . "</td></tr>";
}

$conn->close();
?>
</div>

        </tbody>
    </table>
</div>

        <div id="editForm">
            <h2>Edit Product</h2>
            <form action="edit_product.php" method="post">
                <input type="hidden" name="id" id="edit-product-id">
                <input type="text" name="title" id="edit-title" required>
                <textarea name="description" id="edit-description" required></textarea>
                <input type="number" name="price" id="edit-price" required>
                <button type="submit">Update Product</button>
            </form>
        </div>
    </div>

    <script>
        const tabs = document.querySelectorAll('.tab');
        const tabContents = document.querySelectorAll('.tab-content');

        tabs.forEach(tab => {
            tab.addEventListener('click', () => {
                document.querySelector('.tab.active').classList.remove('active');
                tab.classList.add('active');
                const target = tab.getAttribute('data-target');
                tabContents.forEach(content => {
                    content.classList.remove('active');
                    if (content.id === target.substring(1)) {
                        content.classList.add('active');
                    }
                });
            });
        });

        function openProductEditForm(id, title, description, price) {
            document.getElementById('edit-product-id').value = id;
            document.getElementById('edit-title').value = title;
            document.getElementById('edit-description').value = description;
            document.getElementById('edit-price').value = price;
            document.getElementById('editForm').style.display = 'block';
        }
    </script>
</body>
</html>
