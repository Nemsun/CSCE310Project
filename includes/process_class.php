<?php
session_start();
include_once 'dbh.inc.php';

error_log(print_r($_POST, true));

function redirectWithMessage($location, $message) {
    $_SESSION['message'] = $message;
    header("Location: $location");
    exit();
}

// Handle Class Update/Delete
if (isset($_POST['action']) && $_POST['type'] === 'class') {
    $classId = $_POST['Class_ID'];

    if ($_POST['action'] === 'edit') {
        $className = $_POST['class_name'];
        $classDescription = $_POST['class_description'];

        $stmt = $conn->prepare("UPDATE Classes SET Name = ?, Description = ? WHERE Class_ID = ?");
        $stmt->bind_param("ssi", $className, $classDescription, $classId);

        if ($stmt->execute()) {
            redirectWithMessage("../pages/progress_tracking.php", "Class updated successfully");
        } else {
            redirectWithMessage("../pages/edit_class.php?CE_Num=$classId", "Error updating class: " . $stmt->error);
        }
    } elseif ($_POST['action'] === 'delete') {
        $stmt = $conn->prepare("DELETE FROM Classes WHERE Class_ID = ?");
        $stmt->bind_param("i", $classId);

        if ($stmt->execute()) {
            redirectWithMessage("../pages/progress_tracking.php", "Class deleted successfully");
        } else {
            redirectWithMessage("../pages/progress_tracking.php", "Error deleting class: " . $stmt->error);
        }
    }

    $stmt->close();
}

$conn->close();

// Redirect to an error page if no action was handled
redirectWithMessage("../pages/error.php", "Invalid access method");
?>
