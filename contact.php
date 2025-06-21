<?php
session_start(); // Start the session to check login status
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - Tech & Gadget E-Pasal</title>
    <link rel="stylesheet" href="contact.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="header.css">
    <link rel="stylesheet" href="footer.css">
</head>
<body>
    <?php include 'header.php'; ?>

    <div class="contact-container">
        <div class="contact-info">
            <!-- Existing contact info remains the same -->
            <h2>Get in Touch</h2>
            <div class="info-box">
                <div class="icon">
                    <i class="fas fa-map-marker-alt"></i>
                </div>
                <div class="details">
                    <h3>Address</h3>
                    <p>Baneshwor, Kathmandu<br>Nepal</p>
                </div>
            </div>

            <div class="info-box">
                <div class="icon">
                    <i class="fas fa-phone-alt"></i>
                </div>
                <div class="details">
                    <h3>Phone</h3>
                    <p>+977-987654321</p>
                </div>
            </div>

            <div class="info-box">
                <div class="icon">
                    <i class="fas fa-envelope"></i>
                </div>
                <div class="details">
                    <h3>Email</h3>
                    <p>contact@epasal.com</p>
                </div>
            </div>

            <div class="social-media">
                <h3>Follow Us</h3>
                <div class="social-icons">
                    <a href="https://facebook.com"><i class="fab fa-facebook-f"></i></a>
                    <a href="https://x.com"><i class="fab fa-twitter"></i></a>
                    <a href="https://instagram.com"><i class="fab fa-instagram"></i></a>
                    <a href="https://linkedin.com"><i class="fab fa-linkedin-in"></i></a>
                </div>
            </div>
        </div>

        <!-- Image Section -->
        <div class="image-container">
            <img src="login.jpeg"  class="service-image">
        </div>
    </div>

  

    <?php include 'footer.php'; ?>
</body>
</html>