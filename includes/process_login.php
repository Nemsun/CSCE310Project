<?php
session_start();

include_once 'dbh.inc.php';

if (isset($_POST['login'])) {
    $enteredUsername = $_POST['username'];
    $enteredPassword = $_POST['password'];

    //Make sure that username and password don't contain sql injections

    $sql = "SELECT * FROM users WHERE Username = ? AND Passwords = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $enteredUsername, $enteredPassword);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    if ($result->num_rows == 1 AND $user['User_Type'] != 'INACTIVE') {
        $_SESSION['user_id'] = $user['UIN'];
        $_SESSION['user_type'] = $user['User_Type'];

        $stmt->close();
        $conn->close();

        // Redirect based on user type
        if ($_SESSION['user_type'] == 'Admin') {
            header("Location: ../pages/test.php");
        } else {
            header("Location: ../pages/test.php");
        }
    } else {
        header("Location: error_page.php");
        exit();
    }

    $stmt->close();
    $conn->close();
    
} else {
    header("Location: error_page.php");
    exit();
}
?>