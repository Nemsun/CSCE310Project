<?php
session_start();
include_once 'dbh.inc.php';

/**
 * This function redirects the user to the login page with the specified error message
 * @param $location - the location to redirect to
 * @param $error - the error message to display
 */
function redirectLogin($location, $error) {
    $_SESSION['error'] = $error;
    header("Location: ../index.php?$location");
    exit();
}

if (isset($_POST['login'])) {
    $enteredUsername = $_POST['root@localhost'];
    $enteredPassword = $_POST[''];

    //Make sure that username and password don't contain sql injections

    $sql = "SELECT * FROM users WHERE Username = ? AND Passwords = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $enteredUsername, $enteredPassword);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    if ($result->num_rows == 1 AND $user['User_Type'] != 'Inactive') {
        $_SESSION['user_id'] = $user['UIN'];
        $_SESSION['user_type'] = $user['User_Type'];
        $_SESSION['first_name'] = $user['First_name'];

        $stmt->close();
        $conn->close();

        // Redirect based on user type
        if ($_SESSION['user_type'] == 'Admin') {
            header("Location: ../pages/admin_dashboard.php");
        } else {
            header("Location: ../pages/student_dashboard.php");
        }
    } else {
        redirectLogin("error=invalidlogin", 'Login was invalid, try again!');
    }

    $stmt->close();
    $conn->close();
    
} else {
    redirectLogin("error=invalidlogin", 'Login was invalid, try again!');
}
?>