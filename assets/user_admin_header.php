<!-- WRITTEN BY: NAMSON PHAM, PATRICK KEATING
     UIN: 530003416, 630003608
 -->
<!DOCTYPE html>
<html>
    <head>
        <title>Home</title>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="../css/navbar.css">
        <link rel="stylesheet" href="../css/modal.css">
        <link rel="stylesheet" href="../css/style.css">
    </head>
    <body>

<?php
session_start();
include_once '../includes/dbh.inc.php'; 
if (!isset($_SESSION['user_id'])) {
    // Redirect to the login page
    header("Location: ../index.php");
    exit();
} else {
    $stmt = $conn->prepare("SELECT * FROM users WHERE UIN = ?");
    $stmt->bind_param("s", $_SESSION['user_id']);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = mysqli_fetch_assoc($result);
    if ($row['User_Type'] !== "Admin") {
        header("Location: ../pages/student_dashboard.php");
    }
}
?>