<?php
session_start();
include_once 'dbh.inc.php';

error_log(print_r($_POST, true));

function redirectWithMessage($location, $message) {
    $_SESSION['message'] = $message;
    header("Location: $location");
    exit();
}

if (isset($_POST['submit-cert'])) {
    $certName = $_POST['cert_name'];
    $certDescription = $_POST['cert_description'];

    if ($_POST['action'] === 'add') {
        $stmt = $conn->prepare("INSERT INTO Certification (Name, Description) VALUES (?, ?)");
        $stmt->bind_param("ss", $certName, $certDescription);

        if ($stmt->execute()) {
            redirectWithMessage("../pages/progress_tracking.php", "Certification added successfully");
        } else {
            redirectWithMessage("../pages/insert_cert.php", "Error adding certification: " . $stmt->error);
        }
        $stmt->close();
    } elseif ($_POST['action'] === 'edit') {
        $certId = $_POST['cert_id'];

        $stmt = $conn->prepare("UPDATE Certification SET Name = ?, Description = ? WHERE Cert_ID = ?");
        $stmt->bind_param("ssi", $certName, $certDescription, $certId);

        if ($stmt->execute()) {
            redirectWithMessage("../pages/progress_tracking.php", "Certification updated successfully");
        } else {
            redirectWithMessage("../pages/insert_cert.php?Cert_ID=$certId", "Error updating certification: " . $stmt->error);
        }
        $stmt->close();
    }

    $conn->close();
} elseif (isset($_POST['delete-cert'])) {
    $certName = $_POST['CertName'];
    $stmt = $conn->prepare("SELECT Cert_ID FROM user_certification_view WHERE CertName = ?");
    $stmt->bind_param("s", $certName);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
        $certId = $row['Cert_ID'];
        $deleteStmt = $conn->prepare("DELETE FROM Cert_Enrollment WHERE Cert_ID = ?");
        $deleteStmt->bind_param("i", $certId);
        $deleteStmt->execute();

        if ($deleteStmt->affected_rows > 0) {
            redirectWithMessage("../pages/progress_tracking.php", "Certification enrollment deleted successfully");
        } else {
            redirectWithMessage("../pages/error.php", "Error deleting certification enrollment: " . $deleteStmt->error);
        }
        $deleteStmt->close();
    } else {
        redirectWithMessage("../pages/error.php", "No certification found with the provided name");
    }
    $stmt->close();
    $conn->close();
} else {
    redirectWithMessage("../pages/error.php", "Invalid access method");
}
?>
