<?php
session_start();
include_once 'dbh.inc.php';

if (isset($_POST['submit-class'])) {
    $isEditMode = $_POST['action'] == 'edit';
    $className = $_POST['class_name'];
    $classDescription = $_POST['class_description'];
    
    if ($isEditMode) {
        $classId = $_POST['class_id'];
        $stmt = $conn->prepare("UPDATE Classes SET Name = ?, Description = ? WHERE Class_ID = ?");
        $stmt->bind_param("ssi", $className, $classDescription, $classId);
    } else {
        $stmt = $conn->prepare("INSERT INTO Classes (Name, Description) VALUES (?, ?)");
        $stmt->bind_param("ss", $className, $classDescription);
    }

    if ($stmt->execute()) {
        $_SESSION['message'] = $isEditMode ? "Class updated successfully" : "New class added successfully";
        header("Location: ../pages/progress_tracking.php");
    } else {
        $_SESSION['message'] = "Error: " . $stmt->error;
        header("Location: " . ($isEditMode ? "edit_class.php?CE_Num=$classId" : "add_class.php"));
    }
    
    $stmt->close();
    $conn->close();
} elseif (isset($_POST['delete-class'])) {
    $classEnrollmentId = $_POST['ce_num'];
    $deleteEnrollmentsStmt = $conn->prepare("DELETE FROM class_enrollment WHERE ce_num = ?");
    $deleteEnrollmentsStmt->bind_param("i", $classEnrollmentId);
    $deleteEnrollmentsStmt->execute();
    $deleteEnrollmentsStmt->close();
    
    $_SESSION['message'] = "Class enrollment deleted successfully";
    header("Location: ../pages/progress_tracking.php");
} else {
    $_SESSION['message'] = "Invalid access method";
    header("Location: ../pages/error.php");
    exit();
}
?>
