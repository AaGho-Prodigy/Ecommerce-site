<?php // Stripe Config
session_start();
$username = isset($_SESSION['username']) ? htmlspecialchars($_SESSION['username']) : '';
?>
<!DOCTYPE html> 
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout Page</title>
    <link rel="stylesheet" href="styles.css">
    <script src="https://js.stripe.com/v3/"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
        }
        .checkout-container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background: white;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
        h1, h2 {
            text-align: center;
            color: #333;
        }
        label {
            display: block;
            margin: 10px 0 5px;
            font-weight: bold;
        }
        input, textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }
        textarea {
            resize: vertical;
            min-height: 80px;
        }
        .cart-items, .payment-info {
            margin-top: 20px;
            padding: 10px;
            background: #f9f9f9;
            border-radius: 5px;
        }
        .cart-item {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #ddd;
        }
        .cart-total {
            font-size: 18px;
            font-weight: bold;
            text-align: right;
            margin-top: 10px;
        }
        button {
            width: 100%;
            padding: 12px;
            background: #28a745;
            color: white;
            font-size: 18px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.3s;
        }
        button:hover {
            background: #218838;
        }
        #card-element {
            border: 1px solid #ccc;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 15px;
        }
        #card-errors {
            color: #dc3545;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>

<div class="checkout-container"> 
    <h1>Checkout</h1>
    
    <form id="checkout-form">
        <section class="billing-info">
            <h2>Billing Information</h2>
            <label for="name">Full Name:</label>
            <input type="text" id="name" name="username" value="<?php echo $username; ?>" readonly>
            
            <label for="email">Email Address:</label>
            <input type="email" id="email" name="email" required>
            
            <label for="address">Shipping Address:</label>
            <textarea id="address" name="address" required></textarea>
            
            <label for="phone">Phone Number:</label>
            <input type="tel" id="phone" name="phone" required>
        </section>
        
        <section class="cart-items">
            <h2>Your Cart</h2>
            <div id="cart-items"></div>
            <div class="cart-total" id="cart-total">Total: NRP. 0.00</div>
            <input type="hidden" name="cart_data" id="cart_data">
        </section>

        <section class="payment-info">
            <h2>Payment Information</h2>
            <div id="card-element"></div>
            <div id="card-errors" role="alert"></div>
        </section>

        <button type="submit" id="submit-button">Pay Now</button>
    </form>
</div>

<script>
    document.addEventListener("DOMContentLoaded", () => {
        const stripe = Stripe('Public Key');// Public Key rakha
        
        const elements = stripe.elements();
        const cardElement = elements.create('card');
        cardElement.mount('#card-element');
        
        const form = document.getElementById('checkout-form');
        const submitButton = document.getElementById('submit-button');
        
        const cart = JSON.parse(localStorage.getItem("cart")) || [];
        const cartItemsContainer = document.getElementById("cart-items");
        const cartTotalElement = document.getElementById("cart-total");
        const cartDataInput = document.getElementById("cart_data");
        
        function renderCart() {
            cartItemsContainer.innerHTML = "";
            let total = 0;
            if (cart.length === 0) {
                cartItemsContainer.innerHTML = "<p>Your cart is empty.</p>";
                cartTotalElement.textContent = "Total: $0.00";
                return;
            }
            cart.forEach((item) => {
                const itemTotal = item.price * item.quantity;
                total += itemTotal;
                
                const cartItem = document.createElement("div");
                cartItem.classList.add("cart-item");
                cartItem.innerHTML = `
                    <h4>${item.title} (x${item.quantity})</h4>
                    <span class="price">NRP. ${itemTotal.toFixed(2)}</span>
                `;
                cartItemsContainer.appendChild(cartItem);
            });
            cartTotalElement.textContent = `Total: NRP. ${total.toFixed(2)}`;
            cartDataInput.value = JSON.stringify(cart);
        }

        renderCart();

        form.addEventListener('submit', async (event) => {
            event.preventDefault();
            
            submitButton.disabled = true;
            submitButton.textContent = 'Processing...';
            
            const billingDetails = {
                name: document.getElementById('name').value,
                email: document.getElementById('email').value,
                address: document.getElementById('address').value,
                phone: document.getElementById('phone').value
            };
            
            try {
                const response = await fetch('create_payment_intent.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        amount: calculateTotalAmount(), 
                        currency: 'npr', 
                        billingDetails: billingDetails,
                        cart: cart
                    })
                });
                
                const { clientSecret } = await response.json();
                
                const { error, paymentIntent } = await stripe.confirmCardPayment(clientSecret, {
                    payment_method: {
                        card: cardElement,
                        billing_details: billingDetails
                    }
                });
                
                if (error) {
                    const errorElement = document.getElementById('card-errors');
                    errorElement.textContent = error.message;
                    submitButton.disabled = false;
                    submitButton.textContent = 'Pay Now';
                } else {
                    localStorage.removeItem("cart"); 
                    window.location.href = 'success.php?payment_id=' + paymentIntent.id;
                }
            } catch (err) {
                console.error('Error:', err);
                document.getElementById('card-errors').textContent = 'An error occurred. Please try again.';
                submitButton.disabled = false;
                submitButton.textContent = 'Pay Now';
            }
        });
        
        function calculateTotalAmount() {
            const cart = JSON.parse(localStorage.getItem("cart")) || [];
            const total = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
            return Math.round(total * 100); 
        }
    });
</script>
</body>
</html>