<?php
session_start();
include_once 'dbh.inc.php';

function redirectTo($location, $error) {
    $_SESSION['error'] = $error;
    header("Location: ../pages/create_account.php?$location");
    exit();
}

//NEED TO FIX ALERTS

if (isset($_POST['create_account'])) {
    $uin = $_POST['UIN'];
    $firstName = $_POST['first_name'];
    $middleInitial = $_POST['m_initial'];
    $lastName = $_POST['last_name'];
    $email = $_POST['email'];
    $discord = $_POST['discord'];
    $username = $_POST['account_username'];
    $password = $_POST['account_password'];
    $usertype = "Student";

    if (strlen($middleInitial) !== 1) {
        redirectTo("error=invalidminitial", 'Middle Initial should be 1 character');
    }

    if (strlen($uin) !== 9) {
        redirectTo("error=invaliduinlength", 'UIN should be 9 numbers');
    }

    if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
        redirectTo("error=invalidemail", 'Please enter a valid email');
    }

    // ***UIN is Numeric
    if (!is_numeric($uin)) {
        redirectTo("error=invalidUIN", 'UIN should only contain numbers');
    }


    // ***No duplicate usernames!
    $stmt = $conn->prepare("SELECT * FROM users WHERE Username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows !== 0) {
        redirectTo("error=invaliduser", 'Duplicate username, try a new one');
    }

    // ***No duplicate UINs (PK)
    $stmt = $conn->prepare("SELECT * FROM users WHERE UIN = ?");
    $stmt->bind_param("i", $UIN);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows !== 0) {
        redirectTo("error=invalidUIN", 'This user is already registered');
    }

    // Everything besides email and password should be alphanumeric
    // Email should be alphanumeric + @ and periods
    // Password can be whatever
    
    // Database insertion
    $stmt = $conn->prepare("INSERT INTO users (UIN, First_name, M_Initial, Last_Name, Username, Passwords, User_Type, Email, Discord) 
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("issssssss", $uin, $firstName, $middleInitial, $lastName, $username, $password, $usertype, $email, $discord);

    if ($stmt->execute()) {
        $_SESSION['message'] = "Account created successfully";
    } else {
        $_SESSION['message'] = "Account was not created, please recheck for valid inputs";
    }

    $stmt->close();
    $conn->close();
    echo '<script>alert("' . $_SESSION['message'] . '");</script>';
    unset($_SESSION['message']);

    header("Location: ../");
    exit();
    
} else {
    header("Location: error.php");
    exit();
}
?>