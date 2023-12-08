<!--WRITTEN BY: NAMSON PHAM
    UIN: 530003416                         
-->

<!-- Page to create an initial student account from the login page -->
<?php session_start(); ?>
<!DOCTYPE html>
<html>
    <head>
        <title>Signup</title>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="../css/registration.css">
        <link rel="stylesheet" href="../css/style.css">
    </head>
    <div class = "main-container margin-left-35">
        <!-- Alerts Box -->
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
        <!-- Fields to fill in to create an account-->
        <div class="signup-container">
        <h1>SIGNUP</h1>
            <form action="../includes/process_account.php" method="post">
                <input type="text" placeholder="UIN" id="UIN" name="UIN" required>
                <input type="text" placeholder="First name"id="first_name" name="first_name" required>
                <input type="text" placeholder="Middle initial"id="m_initial" name="m_initial" required>
                <input type="text" placeholder="Last name"id="last_name" name="last_name" required>
                <input type="text" placeholder="Email"id="email" name="email" required>
                <input type="text" placeholder="Discord name"id="discord" name="discord" required>
                <input type="text" placeholder="Account name"id="account_username" name="account_username" required>
                <input type="password" placeholder="Account password" id="account_password" name="account_password" required>
                <span id="signup-text">Already have an account? <a href="../">Login</a></span>
                <button type="submit" name="create_account" id="signup-button">SIGNUP</button>
            </form>
        </div>
    </body>
</html>

<script src="../js/index.js"></script>