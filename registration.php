<?php include('connect.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tech and Gadget Website - User Registration</title>
    <link rel="stylesheet" href="registration.css">
    <link rel="stylesheet" href="header.css">
</head>
<body>

    <?php include('header.php'); ?>

    <div class="container">
        <h2>Register To E-Pasal</h2>
        <form class="registration-form" action="register_user.php" method="post">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required>
            </div>
            
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>

            <div class="form-group">
                <label for="confirmpassword">Confirm Password</label>
                <input type="password" id="confirmpassword" name="confirmpassword" required>
            </div>

            <div class="form-group">
                <button type="submit" class="btn-submit">Register</button>
                <a href="login.php">
                    <button type="button">Proceed to Login</button>
                </a>
            </div>
        </form>
    </div>

</body>
</html>
