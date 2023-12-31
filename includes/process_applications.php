<!-- WRITTEN BY: NAMSON PHAM
     UIN: 530003416
 -->
<?php
session_start();
include_once 'dbh.inc.php';
include 'helper.php';
include 'app_helper.php';

/*
 * ALL POST REQUESTS
 * ADD APPLICATION
 * DELETE APPLICATION
 * UPDATE APPLICATION
*/

if (isset($_POST['add_app_btn'])) {
    // Get all the information from the form
    // Validate the information
    $userUIN = filter_var($_POST['uin'], FILTER_VALIDATE_INT);
    $programNum = filter_var($_POST['program_num'], FILTER_VALIDATE_INT);
    $uncomCert = filter_var($_POST['uncom_cert'], FILTER_SANITIZE_STRING);
    $comCert = filter_var($_POST['com_cert'], FILTER_SANITIZE_STRING);
    $purposeStmt = filter_var($_POST['purpose_stmt'], FILTER_SANITIZE_STRING);
    /* Error checking */
    /* Check if UIN exists in the student table */
    if (!checkCollegeStudent($conn, $userUIN)) {
        // If the user does not exist, redirect to the application_information page with an error
        redirectTo("application_information", "error=invaliduser", 'User does not exist');
        exit();
    }
    /* Check if program number exists in program table */
    if (!checkPrograms($conn, $programNum)) {
        // If the program does not exist, redirect to the application_information page with an error
        redirectTo("application_information", "error=invalidprogram", 'Program does not exist');
        exit();
    }
    /* Check if the program is active */
    if (!checkActiveProgram($conn, $programNum)) {
        // If the program is not active, redirect to the application_information page with an error
        redirectTo("application_information", "error=invalidprogram", "Program is not active");
        exit();
    }
    // If no errors, add the application to the database
    addApplication($conn, $userUIN, $programNum, $uncomCert, $comCert, $purposeStmt);
} 

if (isset($_POST['delete_app_btn'])) {
    // Get the application number from the form
    $appToBeDeleted = $_POST['delete_app_id'];
    $studentUIN = $_SESSION['user_id'];
    // Prepare statement to prevent SQL injection
    $stmt = $conn->prepare("DELETE FROM applications WHERE App_Num = ? AND UIN = ?");
    // Bind parameters to the statement
    $stmt->bind_param("ii", $appToBeDeleted, $studentUIN);
    // Execute the statement
    // If successful, redirect to application_information page with success message
    // If unsuccessful, redirect to application_information page with failure message
    if ($stmt->execute()) {
        $_SESSION['success'] = 'Application deleted successfully!';
        header("Location: ../pages/application_information.php?deleteapp=success");
        $stmt->close();
        exit();
    } else {
        redirectTo("application_information", "deleteapp=failure", 'Application failed to delete!');
        $stmt->close();
    }
} 

if (isset($_POST['update_app_btn'])) {
    // Get all the information from the form
    $editAppID = $_POST['edit_app_id'];
    $editProgramNum = filter_var($_POST['program_num'], FILTER_VALIDATE_INT);
    $editUncomCert = filter_var($_POST['uncom_cert'], FILTER_SANITIZE_STRING);
    $editComCert = filter_var($_POST['com_cert'], FILTER_SANITIZE_STRING);
    $editPurposeStmt = filter_var($_POST['purpose_statement'], FILTER_SANITIZE_STRING);
    /* Error checking */
    /* Check if program number exists in program table */
    if (!checkPrograms($conn, $editProgramNum)) {
        // If the program does not exist, redirect to the application_information page with an error
        redirectTo("application_information", "error=invalidprogram", 'Program does not exist');
        exit();
    }
    // if no errors, update the application in the database
    // Prepare statement to prevent SQL injection
    $stmt = $conn->prepare("UPDATE applications SET Program_Num = ?, Uncom_Cert = ?, Com_Cert = ?, Purpose_Statement = ? WHERE App_Num = '$editAppID'");
    // Bind parameters to the statement
    $stmt->bind_param("isss", $editProgramNum, $editUncomCert, $editComCert, $editPurposeStmt);
    // Execute the statement
    // If successful, redirect to application_information page with success message
    // If unsuccessful, redirect to application_information page with failure message
    if ($stmt->execute()) {
        $_SESSION['success'] = "Application updated successfully";
        header("Location: ../pages/application_information.php?updateapp=success");
        $stmt->close();
        exit();
    } else {
        redirectTo("application_information", "updateapp=failure", 'Application failed to update!');
        $stmt->close();
    }
}