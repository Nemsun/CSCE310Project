<?php
session_start();
include_once 'dbh.inc.php';

function redirectTo($location, $error) {
    $_SESSION['error'] = $error;
    header("Location: ../pages/user_admin.php?$location");
    exit();
}


//CREATING USER
if (isset($_POST['add_user_btn'])) {
    $uin = $_POST['UIN'];
    $firstName = $_POST['first_name'];
    $middleInitial = $_POST['m_initial'];
    $lastName = $_POST['last_name'];
    $email = $_POST['email'];
    $discord = $_POST['discord'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $usertype = $_POST['user_type'];

    if (strlen($middleInitial) !== 1) {
        redirectTo("error=invalidminitial", 'Middle Initial should be 1 character');
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

    $stmt = $conn->prepare("INSERT INTO users (UIN, First_name, M_Initial, Last_Name, Username, Passwords, User_Type, Email, Discord) 
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("issssssss", $uin, $firstName, $middleInitial, $lastName, $username, $password, $usertype, $email, $discord);

    if ($stmt->execute()) {
        $_SESSION['success'] = 'User added successfully!';
        header("Location: ../pages/user_admin.php?adduser=success");
        $stmt->close();
        exit();
    } else {
        redirectTo("adduser=failure", 'User failed to add!');
        $stmt->close();
    }

    $conn->close();
}