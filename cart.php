<?php
session_start();

if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'user') {
    // Redirect non-admin users to the homepage
    header("Location: index.php");
    exit();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Cart</title>
    <link rel="stylesheet" href="homepage.css">
    <link rel="stylesheet" href="header.css">
    <script src="cart.js" async></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .cart-container {
            max-width: 800px;
            margin: 20px auto;
            background: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .cart-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #ddd;
            padding: 10px 0;
        }
        .cart-item:last-child {
            border-bottom: none;
        }
        .cart-item h4 {
            margin: 0;
            font-size: 18px;
        }
        .cart-item .price {
            font-size: 16px;
            font-weight: bold;
        }
        .cart-item input {
            width: 50px;
            text-align: center;
        }
        .cart-total {
            text-align: right;
            font-size: 18px;
            margin-top: 20px;
            font-weight: bold;
        }
        .cart-actions {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }
        .cart-actions button {
            padding: 10px 20px;
            font-size: 16px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            transition: background-color 0.3s;
        }
        .cart-actions .clear-cart {
            background-color: #e74c3c;
            color: #fff;
        }
        .cart-actions .checkout {
            background-color: #2ecc71;
            color: #fff;
        }
        .cart-actions button:hover {
            opacity: 0.9;
        }
    </style>
</head>
<body>

<?php include 'header.php'; ?>

<div class="cart-container">
    <h2>Your Cart</h2>
    <div id="cart-items">
        <!-- Cart items will be dynamically inserted here -->
    </div>
    <div class="cart-total" id="cart-total">
        Total: NRP. 0.00
    </div>
    <div class="cart-actions">
        <button class="clear-cart" id="clear-cart">Clear Cart</button>
        <a href="checkout.php">
            <button class="checkout" id="checkout">Checkout</button>
        </a>
    </div>
</div>
<a href="user_confirm_delivery.php"><button style="padding: 10px; background-color: blue; color: white; border-radius: 5px; margin-left: 1150px; cursor: pointer;">My Orders</button></a>

<?php include 'footer.php'; ?>
<script>
    document.addEventListener("DOMContentLoaded", () => {
        const cart = JSON.parse(localStorage.getItem("cart")) || [];
        const cartItemsContainer = document.getElementById("cart-items");
        const cartTotalElement = document.getElementById("cart-total");
        const clearCartButton = document.getElementById("clear-cart");
        const checkoutButton = document.getElementById("checkout");

        // Render cart items
        function renderCart() {
            cartItemsContainer.innerHTML = ""; // Clear previous items
            let total = 0;

            if (cart.length === 0) {
                cartItemsContainer.innerHTML = "<p>Your cart is empty.</p>";
                cartTotalElement.textContent = "Total: NRP. 0.00";
                checkoutButton.disabled = true;  // Disable checkout if cart is empty
                return;
            }

            cart.forEach((item, index) => {
                const itemTotal = item.price * item.quantity;
                total += itemTotal;

                const cartItem = document.createElement("div");
                cartItem.classList.add("cart-item");

                cartItem.innerHTML = `
                    <h4>${item.title}</h4>
                    <div>
                        <input type="number" min="1" value="${item.quantity}" data-index="${index}" class="quantity-input">
                        <span class="price">NRP. ${itemTotal.toFixed(2)}</span>
                        <button class="remove-item" data-index="${index}">Remove</button>
                    </div>
                `;

                cartItemsContainer.appendChild(cartItem);
            });

            cartTotalElement.textContent = `Total: NRP. ${total.toFixed(2)}`;
            checkoutButton.disabled = false;  // Enable checkout if cart has items
        }

        // Update cart quantity
        cartItemsContainer.addEventListener("input", (e) => {
            if (e.target.classList.contains("quantity-input")) {
                const index = e.target.dataset.index;
                const newQuantity = parseInt(e.target.value, 10);

                if (newQuantity > 0) {
                    cart[index].quantity = newQuantity;
                } else {
                    cart[index].quantity = 1; // Minimum quantity is 1
                    e.target.value = 1;
                }

                localStorage.setItem("cart", JSON.stringify(cart));
                renderCart();
            }
        });

        // Remove item from cart
        cartItemsContainer.addEventListener("click", (e) => {
            if (e.target.classList.contains("remove-item")) {
                const index = e.target.dataset.index;
                cart.splice(index, 1); // Remove the item
                localStorage.setItem("cart", JSON.stringify(cart));
                renderCart();
            }
        });

        // Clear the cart
        clearCartButton.addEventListener("click", () => {
            localStorage.removeItem("cart");
            renderCart();
        });

        // Checkout button logic
        checkoutButton.addEventListener("click", () => {
            if (cart.length === 0) {
                alert("Your cart is empty.");
                return;
            }

            // Redirect to checkout page with cart data (for example)
            window.location.href = "checkout.php";  // Placeholder for actual checkout logic
        });

        // Initial render
        renderCart();
    });
</script>
</body>
</html>
