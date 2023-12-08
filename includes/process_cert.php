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
    $certId = $_POST['certe_num'];

    $stmt = $conn->prepare("DELETE FROM cert_enrollment WHERE CertE_Num = ?");
    $stmt->bind_param("i", $certId);

    if ($stmt->execute()) {
        redirectWithMessage("../pages/progress_tracking.php", "Certification deleted successfully");
    } else {
        redirectWithMessage("../pages/progress_tracking.php", "Error deleting certification: " . $stmt->error);
    }
    $stmt->close();
    $conn->close();
} else {
    redirectWithMessage("../pages/error.php", "Invalid access method");
}
?>
