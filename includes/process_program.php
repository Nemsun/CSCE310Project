<?php
session_start();
include_once 'dbh.inc.php';

error_log(print_r($_POST, true));

function redirectWithMessage($location, $message) {
    $_SESSION['message'] = $message;
    header("Location: $location");
    exit();
}

if (isset($_POST['submit-program'])) {
    $programName = $_POST['program_name'];
    $programDescription = $_POST['program_description'];

    if ($_POST['action'] === 'add') {
        $stmt = $conn->prepare("INSERT INTO Programs (Name, Description) VALUES (?, ?)");
        $stmt->bind_param("ss", $programName, $programDescription);

        if ($stmt->execute()) {
            redirectWithMessage("../pages/program_management.php", "Program added successfully");
        } else {
            redirectWithMessage("../pages/add_program.php", "Error adding program: " . $stmt->error);
        }

        $stmt->close();

    } elseif ($_POST['action'] === 'edit') {
        $programId = $_POST['program_num'];

        $stmt = $conn->prepare("UPDATE Programs SET Name = ?, Description = ? WHERE Program_Num = ?");
        $stmt->bind_param("ssi", $programName, $programDescription, $programId);

        if ($stmt->execute()) {
            redirectWithMessage("../pages/program_management.php", "Program updated successfully");
        } else {
            redirectWithMessage("../pages/add_program.php", "Error updating program: " . $stmt->error);
        }

        $stmt->close();
    }

    $conn->close();

} elseif (isset($_POST['delete_program'])) {
    $programId = $_POST['program_num'];

    $stmt = $conn->prepare("DELETE FROM Programs WHERE Program_Num = ?");
    $stmt->bind_param("i", $programId);

    if ($stmt->execute()) {
        redirectWithMessage("../pages/program_management.php", "Program deleted successfully");
    } else {
        redirectWithMessage("../pages/program_management.php", "Error deleting program: " . $stmt->error);
    }

    $stmt->close();
    $conn->close();

} else {
    redirectWithMessage("../pages/error.php", "Invalid access method");
}
?>
