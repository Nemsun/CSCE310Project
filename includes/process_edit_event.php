<!-- WRITTEN BY: NAMSON PHAM
     UIN: 530003416                         
-->
<?php 
session_start();
include_once 'dbh.inc.php';

function validateDateTime($startDate, $startTime, $endDate, $endTime) {
    $startDateTime = new DateTime($startDate . ' ' . $startTime);
    $endDateTime = new DateTime($endDate . ' ' . $endTime);

    return $startDateTime < $endDateTime;
}

if (isset($_POST['update_btn'])) {
    $editEventID = $_POST['edit_id'];
    $editUIN = $_POST['edit_UIN'];
    $editProgramNum = $_POST['edit_program_num'];
    $editStartDate = $_POST['edit_start_date'];
    $editStartTime = $_POST['edit_start_time'];
    $editLocation = $_POST['edit_location'];
    $editEndDate = $_POST['edit_end_date'];
    $editEndTime = $_POST['edit_end_time'];
    $editEventType = $_POST['edit_event_type'];

    /* Error checking */
    // Program number must be between 1 and 5 (TODO: check if program number exists)
    if ($editProgramNum < 1 || $editProgramNum > 5) {
        $_SESSION['error'] = "Program number must be between 1 and 5";
        header("Location: ../pages/event_admin.php");
        exit();
    }
    // Start date must be before end date
    if (!validateDateTime($editStartDate, $editStartTime, $editEndDate, $editEndTime)) {
        $_SESSION['error'] = "Start date must be before end date";
        header("Location: ../pages/event_admin.php");
        exit();
    }
    // User must be numbers
    if (!is_numeric($editUIN)) {
        $_SESSION['error'] = "UIN must be a number";
        header("Location: ../pages/event_admin.php");
        exit();
    }

    // User must exist
    $stmt = $conn->prepare("SELECT * FROM users WHERE UIN = ?");
    $stmt->bind_param("i", $editUIN);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows == 0) {
        $_SESSION['error'] = "User does not exist";
        header("Location: ../pages/event_admin.php");
        exit();
    }

    $stmt = $conn->prepare("UPDATE event SET UIN = ?, Program_Num = ?, Start_Date = ?, Start_Time = ?, Location = ?, End_Date = ?, End_Time = ?, Event_Type = ? WHERE Event_Id = '$editEventID'");
    $stmt->bind_param("iissssss", $editUIN, $editProgramNum, $editStartDate, $editStartTime, $editLocation, $editEndDate, $editEndTime, $editEventType);

    if ($stmt->execute()) {
        $_SESSION['success'] = "Event updated successfully";
        header("Location: ../pages/event_admin.php");
        $stmt->close();
        exit();
    } else {
        $_SESSION['error'] = "Event not updated";
        header("Location: ../pages/event_admin.php");
        $stmt->close();
        exit();
    }
}