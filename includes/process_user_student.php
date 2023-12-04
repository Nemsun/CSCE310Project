<?php
session_start();
include_once 'dbh.inc.php';

function redirectTo($location, $error) {
    $_SESSION['error'] = $error;
    header("Location: ../pages/user_student.php?$location");
    exit();
}

//UPDATING USER
if (isset($_POST['update_btn'])) {
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
        redirectToUpdate("error=invalidminitial", 'Middle Initial should be 1 character');
    }


    if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
        redirectToUpdate("error=invalidemail", 'Please enter a valid email');
    }


    // ***No duplicate usernames!
    $stmt = $conn->prepare("SELECT * FROM users WHERE Username = ? AND UIN != ?");
    $stmt->bind_param("si", $username, $UIN);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows !== 0) {
        redirectToUpdate("error=invaliduser", 'Duplicate username, try a new one');
    }

    $stmt = $conn->prepare("UPDATE users SET First_name = ?, M_Initial = ?, Last_Name = ?, Username = ?, Passwords = ?, User_Type = ?, Email = ?, Discord = ? WHERE UIN = ?");
    $stmt->bind_param("ssssssssi", $firstName, $middleInitial, $lastName, $username, $password, $usertype, $email, $discord, $uin);

    if ($stmt->execute()) {
        $_SESSION['success'] = 'User successfully updated!';
        header("Location: ../pages/user_student.php?adduser=success");
        $stmt->close();
        exit();
    } else {
        redirectTo("adduser=failure", 'User failed to be updated!');
        $stmt->close();
    }

    $conn->close();
}




//DEACTIVATE ACCOUNT
if (isset($_POST['delete_btn'])) {
    $uin = $_POST['UIN'];

    $stmt = $conn->prepare("UPDATE users SET User_Type = 'Inactive' WHERE UIN = ?");
    $stmt->bind_param("i", $uin);
    if ($stmt->execute()) {
        $_SESSION['success'] = 'User deleted successfully!';
        header("Location: ../index.php?deleteuser=success");
        $stmt->close();
        exit();
    } else {
        redirectTo("deleteuser=failure", 'User failed to delete!');
        $stmt->close();
    }
}