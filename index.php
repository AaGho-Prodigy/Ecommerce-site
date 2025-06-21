<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Store</title>
    <link rel="stylesheet" href="homepage.css">
    <link rel="stylesheet" href="header.css">
</head>

<body>
   <?php include 'header.php'?>

    <section class="hero">
        <div class="container">
            <h1>Find Your Product Here!</h1>
            <p>We provide you with the most affordable electronic goods on the market.</p>
            <a href="shop.html" class="btn">Shop Now</a>
        </div>
    </section>

    <div>
        <h2 style="text-align: center">Featured Products</h2>
        <div class="product-container">
        <?php
        require_once 'connect.php';
        
        try {
            $sql = "SELECT p.* 
                    FROM (
                        SELECT *, 
                            ROW_NUMBER() OVER (PARTITION BY category ORDER BY RAND()) AS category_rank
                        FROM products
                    ) p
                    WHERE p.category_rank = 1
                    ORDER BY RAND()
                    LIMIT 3";
            
            $result = $conn->query($sql);
            
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<div class="product-card" data-category="' . htmlspecialchars($row["category"]) . '">';
                    echo '   <img src="' . htmlspecialchars($row["image_url"]) . '" alt="' . htmlspecialchars($row["title"]) . '">';
                    echo '   <h3>' . htmlspecialchars($row["title"]) . '</h3>';
                    echo '   <p class="description">' . htmlspecialchars($row["description"]) . '</p>';
                    echo '   <p class="category">' . htmlspecialchars($row["category"]) . '</p>';
                    echo '   <p>Stock: ' . htmlspecialchars($row["quantity"]) . '</p>';
                    echo '   <div class="price">NRP. ' . number_format($row["price"], 2) . '</div>';
                    echo '   <button class="add-to-cart" data-id="' . $row["id"] . '" data-title="' . $row["title"] . '" data-price="' . $row["price"] . '">Add to Cart</button>';
                    echo '</div>';
                }
            } else {
                echo '<p>No products available.</p>';
            }
        } catch (Exception $e) {
            echo '<p>Error loading products: ' . $e->getMessage() . '</p>';
        }
        
        $conn->close();
        ?>
        </div>
    </div>

    <?php include 'footer.php'?>    

    <script>
document.addEventListener("DOMContentLoaded", () => {
    const addToCartButtons = document.querySelectorAll(".add-to-cart");

    addToCartButtons.forEach(button => {
        button.addEventListener("click", () => {
            const productId = button.getAttribute("data-id");
            const productTitle = button.getAttribute("data-title");
            const productPrice = parseFloat(button.getAttribute("data-price"));

            let cart = JSON.parse(localStorage.getItem("cart")) || [];

            const existingProductIndex = cart.findIndex(item => item.id === productId);
            if (existingProductIndex !== -1) {
                cart[existingProductIndex].quantity += 1;
            } else {
                cart.push({
                    id: productId,
                    title: productTitle,
                    price: productPrice,
                    quantity: 1
                });
            }

            localStorage.setItem("cart", JSON.stringify(cart));

            alert(`${productTitle} has been added to your cart!`);
        });
    });
});
</script>

</body>
</html>
