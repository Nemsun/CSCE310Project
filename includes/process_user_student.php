<!-- Written by Patrick Keating -->

<!-- Handles all functionality needed the student side, including editing their own information and deactivating their account -->
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

//UPDATING STUDENT
if (isset($_POST['update_student_btn'])) {
    $uin = $_SESSION['user_id'];
    $gender = $_POST['gender'];
    $hispanic = $_POST['hispanic'];
    $race = $_POST['race'];
    $citizen = $_POST['citizen'];
    $first_generation = $_POST['first_generation'];
    $dob = $_POST['dob'];
    $gpa = $_POST['gpa'];
    $major = $_POST['major'];
    $minor1 = $_POST['minor1'];
    $minor2 = $_POST['minor2'];
    $expected_graduation = $_POST['expected_graduation'];
    $school = $_POST['school'];
    $classification = $_POST['classification'];
    $phone = $_POST['phone'];

    if (strlen($expected_graduation) !== 4 OR !is_numeric($expected_graduation)) {
        redirectTo("error=invalidgrad", 'Please enter a valid graduation date');
    }

    // ***Phone is Numeric
    if (!is_numeric($phone) OR strlen($phone) !== 10) {
        redirectTo("error=invalidPhone", 'Phone Number should only contain numbers and be 10 characters');
    }

    if (!is_numeric($gpa)) {
        redirectTo("error=invalidGPA", 'Please enter a valid GPA');
    }
    // Database insertion
    $stmt = $conn->prepare("UPDATE college_student SET Gender = ?, Hispanic = ?, Race = ?, Citizen = ?, First_Generation = ?, DoB = ?, GPA = ?, Major = ?, 
                            Minor_1 = ?, Minor_2 = ?, Expected_Graduation = ?, School = ?, Classification = ?, Phone = ? WHERE UIN = ?");
    $stmt->bind_param("sisiisssssissii", $gender, $hispanic, $race, $citizen, $first_generation, $dob, $gpa, $major, $minor1, $minor2, $expected_graduation, 
                     $school, $classification, $phone, $uin);

    if ($stmt->execute()) {
        // Redirect to the desired page
        header("Location: ../pages/student_dashboard.php");
        exit();
    } else {
        if ($result->num_rows !== 0) {
            redirectTo("error=failedcreation", 'Failed to enter information');
        }
    }

    $stmt->close();
    $conn->close();

    header("Location: ../pages/student_dashboard.php");
    exit();

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