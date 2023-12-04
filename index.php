<?php session_start();?>
<!DOCTYPE html>
<html>
    <head>
        <title>Login</title>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="css/registration.css">
        <link rel="stylesheet" href="css/style.css">
    </head>
    <div class = "main-container margin-left-35">
        <?php
            if(isset($_SESSION['success'])) {
                echo '<div class="alert alert-success" role="alert" id="alert">' . $_SESSION['success'] . '<span class="alert-close-btn" onclick="closeAlert()">&times;</span>' . '</div>';
                unset($_SESSION['success']);
            } else if(isset($_SESSION['error'])) {
                echo '<div class="alert alert-danger" role="alert" id="alert">' . $_SESSION['error'] . '<span class="alert-close-btn" onclick="closeAlert()">&times;</span>' . '</div>';
                unset($_SESSION['error']);
            }
        ?>
    </div>
    <body>
        <div class="login-container">
            <h1>LOGIN</h1>
            <form action="includes/process_login.php" method="post">
                <input type="text" placeholder="Username" id="username" name="username" required>
                <input type="password" placeholder="Password" id="password" name="password" required>
                <span id="signup-text">Don't have an account? <a href="pages/create_account.php">Signup</a></span>
                <button type="submit" name="login" id="login-button">LOGIN</button>
            </form>
        </div>
    </body>
</html>

<script src="js/index.js"></script>