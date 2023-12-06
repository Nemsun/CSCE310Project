<!-- Written by Patrick Keating -->

<?php
session_start();
include_once 'dbh.inc.php';

function redirectTo($location, $error) {
    $_SESSION['error'] = $error;
    header("Location: ../pages/user_student_info.php?$location");
    exit();
}

//NEED TO FIX ALERTS

if (isset($_POST['create_student'])) {
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
    $student_type = "Active";

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
    $stmt = $conn->prepare("INSERT INTO college_student (UIN, Gender, Hispanic, Race, Citizen, First_Generation, DoB, GPA, 
                            Major, Minor_1, Minor_2, Expected_Graduation, School, Classification, Phone, Student_Type) 
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("isisiisssssissis", $uin, $gender, $hispanic, $race, $citizen, $first_generation, $dob, $gpa, $major, $minor1, $minor2, $expected_graduation, 
                     $school, $classification, $phone, $student_type);

    if ($stmt->execute()) {
        // Redirect to the desired page
        header("Location: ../pages/student_dashboard.php");
        exit();
    } else {
        redirectTo("error=failedcreation", 'Failed to enter information');
    }

    $stmt->close();
    $conn->close();

    header("Location: ../pages/student_dashboard.php");
    exit();
    
} 

function redirectToAdmin($location, $error) {
    $_SESSION['error'] = $error;
    header("Location: ../pages/user_admin.php?$location");
    exit();
}


if (isset($_POST['update_student'])) {
    $uin = $_POST['stu_uin'];
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
    $student_type = $_POST['student_type'];

    if (strlen($expected_graduation) !== 4 OR !is_numeric($expected_graduation)) {
        redirectToAdmin("error=invalidgrad", 'Please enter a valid graduation date');
    }

    // ***Phone is Numeric
    if (!is_numeric($phone) OR strlen($phone) !== 10) {
        redirectToAdmin("error=invalidPhone", 'Phone Number should only contain numbers and be 10 characters');
    }

    if (!is_numeric($gpa)) {
        redirectToAdmin("error=invalidGPA", 'Please enter a valid GPA');
    }


    $stmt = $conn->prepare("UPDATE college_student SET Gender = ?, Hispanic = ?, Race = ?, Citizen = ?, First_Generation = ?, DoB = ?, GPA = ?, Major = ?, 
                            Minor_1 = ?, Minor_2 = ?, Expected_Graduation = ?, School = ?, Classification = ?, Phone = ?, Student_Type = ? WHERE UIN = ?");
    $stmt->bind_param("sisiisssssissisi", $gender, $hispanic, $race, $citizen, $first_generation, $dob, $gpa, $major, $minor1, $minor2, $expected_graduation, 
                    $school, $classification, $phone, $student_type, $uin);

    if ($stmt->execute()) {
        // Redirect to the desired page
        header("Location: ../pages/user_admin.php");
        exit();
    } else {
        redirectToAdmin("error=failedupdate", 'Failed to update information');
    }
    
    $stmt->close();
    $conn->close();

    header("Location: ../pages/user_admin.php");
    exit();
} 
?>



