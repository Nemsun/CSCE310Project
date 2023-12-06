<!-- Written by Patrick Keating -->
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



//SOFT DELETING USER
if (isset($_POST['delete_btn'])) {
    $uin = $_POST['UIN'];

    $stmt = $conn->prepare("UPDATE users SET User_Type = 'Inactive' WHERE UIN = ?");
    $stmt->bind_param("i", $uin);

    $stmt2 = $conn->prepare("UPDATE college_student SET Student_Type = 'Inactive' WHERE UIN = ?");
    $stmt2->bind_param("i", $uin);

    if ($stmt->execute() AND $stmt2->execute()) {
        $_SESSION['success'] = 'User deleted successfully!';
        header("Location: ../pages/user_admin.php?deleteuser=success");
        $stmt->close();
        exit();
    } else {
        redirectTo("deleteuser=failure", 'User failed to delete!');
        $stmt->close();
    }
}


//HARD DELETING BUTTON
if (isset($_POST['hard_delete_btn'])) {
    $uin = $_POST['UIN'];

    $stmt = $conn->prepare("DELETE FROM users WHERE UIN = ?");
    $stmt->bind_param("i", $uin);

    $stmt2 = $conn->prepare("DELETE FROM college_student WHERE UIN = ?");
    $stmt2->bind_param("i", $uin);

    if ($stmt->execute() AND $stmt2->execute()) {
        $_SESSION['success'] = 'User hard deleted successfully!';
        header("Location: ../pages/user_admin.php?deleteuser=success");
        $stmt->close();
        exit();
    } else {
        redirectTo("deleteuser=failure", 'User failed to delete!');
        $stmt->close();
    }
}

function redirectToUpdate($location, $error) {
    $_SESSION['error'] = $error;
    header("Location: ../pages/edit_user_admin.php?$location");
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
    $oldUIN = $_POST['old_uin'];

    if (strlen($middleInitial) !== 1) {
        redirectToUpdate("error=invalidminitial", 'Middle Initial should be 1 character');
    }

    if (strlen($uin) !== 9) {
        redirectToUpdate("error=invaliduinlength", 'UIN should be 9 numbers');
    }

    if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
        redirectToUpdate("error=invalidemail", 'Please enter a valid email');
    }

    // ***UIN is Numeric
    if (!is_numeric($uin)) {
        redirectToUpdate("error=invalidUIN", 'UIN should only contain numbers');
    }


    // ***No duplicate usernames!
    $stmt = $conn->prepare("SELECT * FROM users WHERE Username = ? AND UIN != ?");
    $stmt->bind_param("si", $username, $oldUIN);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows !== 0) {
        redirectToUpdate("error=invaliduser", 'Duplicate username, try a new one');
    }

    $stmt = $conn->prepare("UPDATE users SET UIN = ?, First_name = ?, M_Initial = ?, Last_Name = ?, Username = ?, Passwords = ?, User_Type = ?, Email = ?, Discord = ? WHERE UIN = ?");
    $stmt->bind_param("issssssssi", $uin, $firstName, $middleInitial, $lastName, $username, $password, $usertype, $email, $discord, $oldUIN);

    if ($stmt->execute()) {
        $_SESSION['success'] = 'User successfully updated!';
        header("Location: ../pages/user_admin.php?adduser=success");
        $stmt->close();
        exit();
    } else {
        redirectTo("adduser=failure", 'User failed to be updated!');
        $stmt->close();
    }

    $conn->close();
}
