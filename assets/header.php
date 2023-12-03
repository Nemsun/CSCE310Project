<!--WRITTEN BY: NAMSON PHAM
    UIN: 530003416                         
-->
<!DOCTYPE html>
<html>
    <head>
        <title>Home</title>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="../css/navbar.css">
        <link rel="stylesheet" href="../css/style.css">
    </head>
    <body>
        
<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    // Redirect to the login page
    header("Location: ../index.php");
    exit();
}
?>