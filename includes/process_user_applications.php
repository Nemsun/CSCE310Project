<?php
session_start();
include_once 'dbh.inc.php';

function redirectTo($location, $error) {
    $_SESSION['error'] = $error;
    header("Location: ../pages/application_information.php?$location");
    exit();
}
function addApplication($conn, $uin, $programNum, $uncomCert, $comCert, $purposeStmt) {
    $stmt = $conn->prepare("INSERT INTO applications (UIN, Program_Num, Uncom_Cert, Com_Cert, Purpose_Statement) 
                            VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("iisss", $uin, $programNum, $uncomCert, $comCert, $purposeStmt);
    
    if ($stmt->execute()) {
        $_SESSION['success'] = 'Application added successfully!';
        header("Location: ../pages/application_information.php?addapp=success");
        $stmt->close();
        exit();
    } else {
        redirectTo("addapp=failure", 'Application failed to add!');
        $stmt->close();
    }
}
if (isset($_POST['add_app_btn'])) {
    $userUIN = $_POST['uin'];
    $programNum = $_POST['program_num'];
    $uncomCert = $_POST['uncom_cert'];
    $comCert = $_POST['com_cert'];
    $purposeStmt = $_POST['purpose_stmt'];

    /* Error checking */
    /* Check if UIN exists in the student table */
    $stmt = $conn->prepare("SELECT * FROM college_student WHERE UIN = ?");
    $stmt->bind_param("i", $userUIN);
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        if ($result->num_rows == 0) {
            redirectTo("error=invaliduser", 'User does not exist');
        }
        $stmt->close();
    }
    
    /* Check if program number exists in program table */
    $stmt = $conn->prepare("SELECT * FROM programs WHERE Program_Num = ?");
    $stmt->bind_param("i", $programNum);
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        if ($result->num_rows == 0) {
            redirectTo("error=invalidprogram", 'Program does not exist');
        }
        $stmt->close();
    }
    
    addApplication($conn, $userUIN, $programNum, $uncomCert, $comCert, $purposeStmt);
} else if (isset($_POST['delete_app_btn'])) {
    $appToBeDeleted = $_POST['delete_app_id'];
    $studentUIN = $_SESSION['user_id'];

    $stmt = $conn->prepare("DELETE FROM applications WHERE App_Num = ? AND UIN = ?");
    $stmt->bind_param("ii", $appToBeDeleted, $studentUIN);
    if ($stmt->execute()) {
        $_SESSION['success'] = 'Application deleted successfully!';
        header("Location: ../pages/application_information.php?deleteapp=success");
        $stmt->close();
        exit();
    } else {
        redirectTo("deleteapp=failure", 'Application failed to delete!');
        $stmt->close();
    }
}