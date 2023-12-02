<?php
session_start();
include_once 'dbh.inc.php';

function validateDateTime($startDate, $startTime, $endDate, $endTime) {
    $startDateTime = new DateTime($startDate . ' ' . $startTime);
    $endDateTime = new DateTime($endDate . ' ' . $endTime);

    return $startDateTime < $endDateTime;
}

function redirectTo($location, $error) {
    $_SESSION['error'] = $error;
    header("Location: ../pages/event_admin.php?$location");
    exit();
}

function addEvent($conn, $uin, $programNum, $startDate, $startTime, $location, $endDate, $endTime, $eventType) {
    $stmt = $conn->prepare("INSERT INTO event (UIN, Program_Num, Start_Date, Start_Time, Location, End_Date, End_Time, Event_Type) 
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("iissssss", $uin, $programNum, $startDate, $startTime, $location, $endDate, $endTime, $eventType);
    
    if ($stmt->execute()) {
        $eventID = $stmt->insert_id;
        addEventTracking($conn, $eventID, $uin);
        $stmt->close();
    } else {
        redirectTo("addevent=failure", 'Event failed to add!');
        $stmt->close();
    }
}

function addEventTracking($conn, $eventID, $uin) {
    $stmt = $conn->prepare("INSERT INTO event_tracking (Event_Id, UIN) VALUES (?, ?)");
    $stmt->bind_param("ii", $eventID, $uin);
    if ($stmt->execute()) {
        $_SESSION['success'] = 'Event added successfully!';
        header("Location: ../pages/event_admin.php?addevent=success");
        $stmt->close();
        exit();
    } else {
        redirectTo("addevent=failure", 'Event failed to add!');
        $stmt->close();
    }
}

function addUserToEvent($conn, $eventID, $uin) {
    $stmt = $conn->prepare("INSERT INTO event_tracking (Event_Id, UIN) VALUES (?, ?)");
    $stmt->bind_param("ii", $eventID, $uin);
    if ($stmt->execute()) {
        $_SESSION['success'] = 'User added successfully!';
        header("Location: ../pages/event_admin.php?adduser=success");
        $stmt->close();
        exit();
    } else {
        redirectTo("adduser=failure", 'User failed to add!');
        $stmt->close();
    }
}

function deleteEvent($conn, $eventID) {
    /* Check for other dependencies in other tables */
    $dependencyStmt = $conn->prepare("SELECT * FROM event_tracking WHERE Event_Id = ?");
    $dependencyStmt->bind_param("i", $eventID);
    $dependencyStmt->execute();
    $dependencyResult = $dependencyStmt->get_result();

    if ($dependencyResult->num_rows > 0) {
        /* Delete those dependencies */
        $dependencyDeleteStmt = $conn->prepare("DELETE FROM event_tracking WHERE Event_Id = ?");
        $dependencyDeleteStmt->bind_param("i", $eventID);
        $dependencyDeleteStmt->execute();
        if ($dependencyDeleteStmt->affected_rows > 0) {
            $_SESSION['success'] = 'Event deleted successfully!';
            header("Location: ../pages/event_admin.php?deleteevent=success");
        } else {
            redirectTo("deleteevent=failure", 'Event failed to delete!');
        }
        $dependencyDeleteStmt->close();
    }
    /* No dependencies found, proceed with a normal delete */
    $stmt = $conn->prepare("DELETE FROM event WHERE Event_Id = ?");
    $stmt->bind_param("i", $eventID);
    $stmt->execute();
    if ($stmt->affected_rows > 0) {
        $_SESSION['success'] = 'Event deleted successfully!';
        header("Location: ../pages/event_admin.php?deleteevent=success");
    } else {
        redirectTo("deleteevent=failure", 'Event failed to delete!');
    }
    $stmt->close();
    $dependencyStmt->close();
    exit();
}
function deleteUserFromEvent($conn, $UIN) {
    $stmt = $conn->prepare("DELETE FROM event_tracking WHERE UIN = ?");
    $stmt->bind_param("i", $UIN);
    if ($stmt->execute()) {
        $_SESSION['success'] = 'User deleted successfully!';
        header("Location: ../pages/event_admin.php?deleteuser=success");
        $stmt->close();
        exit();
    } else {
        redirectTo("deleteuser=failure", 'User failed to delete!');
        $stmt->close();
    }
}

if (isset($_POST['add_btn'])) {
    $uin = $_POST['UIN'];
    $programNum = filter_var($_POST['program_num'], FILTER_VALIDATE_INT);
    $startDate = $_POST['start_date'];
    $startTime = $_POST['start_time'];
    $location = $_POST['location'];
    $endDate = $_POST['end_date'];
    $endTime = $_POST['end_time'];
    $eventType = $_POST['event_type'];

    /* Error checking */
    /* Check the start date + start time is before the end date + end time */
    if (!validateDateTime($startDate, $startTime, $endDate, $endTime)) {
        redirectTo("error=startdateafterenddate", 'Start date is after end date');
    }
    /* Check the program number*/
    if ($programNum < 1 || $programNum > 5) {
        redirectTo("error=invalidprogramnum", 'Program number should be between 1-5');
    }

    addEvent($conn, $uin, $programNum, $startDate, $startTime, $location, $endDate, $endTime, $eventType);

} else if (isset($_POST['add_user_btn'])) {
    $eventID = $_POST['Event_Id'];
    $uin = $_POST['UIN'];
    /* Error checking */
    /* Check if the user is already tracking the event */
    $stmt = $conn->prepare("SELECT * FROM event_tracking WHERE Event_Id = ? AND UIN = ?");
    $stmt->bind_param("ii", $eventID, $uin);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        redirectTo("error=alreadytracking", 'User is already tracking this event');
    }
    /* Check if the user exists */
    $stmt = $conn->prepare("SELECT * FROM users WHERE UIN = ?");
    $stmt->bind_param("i", $uin);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows == 0) {
        redirectTo("error=invaliduser", 'User does not exist');
    }
    /* Check if the event exists */
    $stmt = $conn->prepare("SELECT * FROM event WHERE Event_Id = ?");
    $stmt->bind_param("i", $eventID);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows == 0) {
        redirectTo("error=invalidevent", 'Event does not exist');
    }
    
    addUserToEvent($conn, $eventID, $uin);

} elseif (isset($_POST['delete_btn'])) {
    $eventDeleteID = $_POST['delete_id'];
    deleteEvent($conn, $eventDeleteID);

} elseif (isset($_POST['delete_event_user_btn'])) {
    $UINDeleteID = $_POST['delete_uin_id'];
    /* Check for dependencies in event table */
    $stmt = $conn->prepare("SELECT * FROM event_tracking WHERE UIN = ?");
    $stmt->bind_param("i", $UINDeleteID);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        redirectTo("error=dependencies", 'User is hosting event and cannot be deleted');
    }
    deleteUserFromEvent($conn, $UINDeleteID);
} else {
    redirectTo("error.php", 'Invalid request');
}
?>