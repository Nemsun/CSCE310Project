<?php include '../assets/header.php'; ?>
<?php include '../assets/student_navbar.php'; ?>
<?php session_start(); ?>


<div class="main-container">
    <h2> Welcome back <?php echo $_SESSION['first_name']; ?>!</h2>
</div>