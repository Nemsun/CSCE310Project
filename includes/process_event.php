<!-- WRITTEN BY: NAMSON PHAM
     UIN: 530003416                         
-->
<?php
session_start();
include_once 'dbh.inc.php';
include 'helper.php';

/**
 * This function adds an application to the applications table in the database
 * @param $conn - the connection to the database
 * @param $uin - the UIN of the student
 * @param $programNum - the program number of the program the student is applying to
 * @param $startDate - the start date of the program the student is applying to
 * @param $endDate - the end date of the program the student is applying to
 * @param $location - the location of the program the student is applying to
 * @param $endDate - the end date of the program the student is applying to
 * @param $endTime - the end time of the program the student is applying to
 * @param $eventType - the event type of the program the student is applying to
 */
function addEvent($conn, $uin, $programNum, $startDate, $startTime, $location, $endDate, $endTime, $eventType) {
    // Prepare statement to prevent SQL injections
    $stmt = $conn->prepare("INSERT INTO event (UIN, Program_Num, Start_Date, Start_Time, Location, End_Date, End_Time, Event_Type) 
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    // Bind parameters to the statement
    $stmt->bind_param("iissssss", $uin, $programNum, $startDate, $startTime, $location, $endDate, $endTime, $eventType);
    // Execute the statement and check if it was successful, if so, add the event to the event tracking table
    // if not redirect to the event admin page with an error
    if ($stmt->execute()) {
        $eventID = $stmt->insert_id;
        addEventTracking($conn, $eventID, $uin);
        $stmt->close();
    } else {
        redirectTo("event_admin", "addevent=failure", 'Event failed to add!');
        $stmt->close();
    }
}

/**
 * This function adds an event to an event tracking table
 * @param $conn - the connection to the database
 * @param $eventID - the event ID of the event to be added to
 * @param $uin - the UIN of the user to be added
 */
function addEventTracking($conn, $eventID, $uin) {
    // Prepare statement to prevent SQL injections
    $stmt = $conn->prepare("INSERT INTO event_tracking (Event_Id, UIN) VALUES (?, ?)");
    // Bind parameters to the statement
    $stmt->bind_param("ii", $eventID, $uin);
    // Execute the statement and check if it was successful, if so, redirect to the event admin page with a success message
    // if not redirect to the event admin page with an error
    if ($stmt->execute()) {
        $_SESSION['success'] = 'Event added successfully!';
        header("Location: ../pages/event_admin.php?addevent=success");
        $stmt->close();
        exit();
    } else {
        redirectTo("event_admin", "addevent=failure", 'Event failed to add!');
        $stmt->close();
    }
}

/**
 * This function adds a user to an event tracking table
 * @param $conn - the connection to the database
 * @param $eventID - the event ID of the event to be added to
 * @param $uin - the UIN of the user to be added
 */
function addUserToEvent($conn, $eventID, $uin) {
    // Prepare statement to prevent SQL injections
    $stmt = $conn->prepare("INSERT INTO event_tracking (Event_Id, UIN) VALUES (?, ?)");
    // Bind parameters to the statement
    $stmt->bind_param("ii", $eventID, $uin);
    // Execute the statement and check if it was successful, if so, redirect to the event admin page with a success message
    // if not redirect to the event admin page with an error
    if ($stmt->execute()) {
        $_SESSION['success'] = 'User added successfully!';
        header("Location: ../pages/event_admin.php?adduser=success");
        $stmt->close();
        exit();
    } else {
        redirectTo("event_admin", "adduser=failure", 'User failed to add!');
        $stmt->close();
    }
}

/**
 * This function deletes an event from the event table
 * @param $conn - the connection to the database
 * @param $eventID - the event ID of the event to be deleted
 */
function deleteEvent($conn, $eventID) {
    /* Check for other dependencies in other tables
     * Check if the event is being tracked by any users
     * If so, delete those dependencies first
     * If not, proceed with a normal delete */

    // Prepare statement to prevent SQL injections
    $dependencyStmt = $conn->prepare("SELECT * FROM event_tracking WHERE Event_Id = ?");
    // Bind parameters to the statement
    $dependencyStmt->bind_param("i", $eventID);
    // Execute the statement and check if it was successful, if so, check if there are any dependencies
    $dependencyStmt->execute();
    // Get the result of the statement
    $dependencyResult = $dependencyStmt->get_result();
    // If there are dependencies, delete them first
    if ($dependencyResult->num_rows > 0) {
        /* Delete those dependencies */
        // Prepare statement to prevent SQL injections
        $dependencyDeleteStmt = $conn->prepare("DELETE FROM event_tracking WHERE Event_Id = ?");
        // Bind parameters to the statement
        $dependencyDeleteStmt->bind_param("i", $eventID);
        // Execute the statement and check if it was successful
        $dependencyDeleteStmt->execute();
        // If the statement was successful redirect to the event admin page with a success message
        // if not redirect to the event admin page with an error
        if ($dependencyDeleteStmt->affected_rows > 0) {
            $_SESSION['success'] = 'Event deleted successfully!';
            header("Location: ../pages/event_admin.php?deleteevent=success");
        } else {
            redirectTo("event_admin", "deleteevent=failure", 'Event failed to delete!');
        }
        $dependencyDeleteStmt->close();
    }
    /* No dependencies found, proceed with a normal delete */
    // Prepare statement to prevent SQL injections
    $stmt = $conn->prepare("DELETE FROM event WHERE Event_Id = ?");
    // Bind parameters to the statement
    $stmt->bind_param("i", $eventID);
    // Execute the statement and check if it was successful
    $stmt->execute();
    // If the statement was successful redirect to the event admin page with a success message
    // if not redirect to the event admin page with an error
    if ($stmt->affected_rows > 0) {
        $_SESSION['success'] = 'Event deleted successfully!';
        header("Location: ../pages/event_admin.php?deleteevent=success");
    } else {
        redirectTo("event_admin", "deleteevent=failure", 'Event failed to delete!');
    }
    $stmt->close();
    $dependencyStmt->close();
    exit();
}

/**
 * This function deletes a user from an event tracking table
 * @param $conn - the connection to the database
 * @param $UIN - the UIN of the user to be deleted
 */
function deleteUserFromEvent($conn, $UIN) {
    // Prepare statement to prevent SQL injections
    $stmt = $conn->prepare("DELETE FROM event_tracking WHERE UIN = ?");
    // Bind parameters to the statement
    $stmt->bind_param("i", $UIN);
    // Execute the statement and check if it was successful, if so, redirect to the event admin page with a success message
    // if not redirect to the event admin page with an error
    if ($stmt->execute()) {
        $_SESSION['success'] = 'User deleted successfully!';
        header("Location: ../pages/event_admin.php?deleteuser=success");
        $stmt->close();
        exit();
    } else {
        redirectTo("event_admin", "deleteuser=failure", 'User failed to delete!');
        $stmt->close();
    }
}

/* ALL POST REQUESTS
 * ADD EVENT
 * ADD USER TO EVENT
 * DELETE EVENT
 * DELETE USER FROM EVENT
 * UPDATE EVENT
*/
if (isset($_POST['add_event_btn'])) {
    // Get the data from the form
    // Validate the data make sure it is in the correct format
    $uin = filter_var($_POST['UIN'], FILTER_VALIDATE_INT);
    $programNum = filter_var($_POST['program_num'], FILTER_VALIDATE_INT);
    $startDate = $_POST['start_date'];
    $startTime = $_POST['start_time'];
    $location = filter_var($_POST['location'], FILTER_SANITIZE_STRING);
    $endDate = $_POST['end_date'];
    $endTime = $_POST['end_time'];
    $eventType = filter_var($_POST['event_type'], FILTER_SANITIZE_STRING);

    /* Error checking */
    /* Check the start date + start time is before the end date + end time */
    if (!validateDateTime($startDate, $startTime, $endDate, $endTime)) {
        redirectTo("event_admin", "error=startdateafterenddate", 'Start date is after end date');
    }

    /* Check the UIN is 9 numbers */
    if (strlen($uin) != 9) {
        redirectTo("event_admin", "error=invaliduinlength", 'UIN should be 9 numbers');
    }

    /* Check the user exists in the user table */
    // Prepare statement to prevent SQL injections
    $stmt = $conn->prepare("SELECT * FROM users WHERE UIN = ?");
    // Bind parameters to the statement
    $stmt->bind_param("i", $uin);
    // Execute the statement and check if it was successful
    // If the user does not exist, redirect to the event admin page with an error
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        if ($result->num_rows == 0) {
            redirectTo("event_admin", "error=invaliduser", 'User does not exist');
        }
        $stmt->close();
    }

    /* Check the program number exists in program table */
    // Prepare statement to prevent SQL injections
    $stmt = $conn->prepare("SELECT * FROM programs WHERE Program_Num = ?");
    // Bind parameters to the statement
    $stmt->bind_param("i", $programNum);
    // Execute the statement and check if it was successful
    // If the program does not exist, redirect to the event admin page with an error
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        if ($result->num_rows == 0) {
            redirectTo("event_admin", "error=invalidprogram", 'Program does not exist');
        }
        $stmt->close();
    }

    // If all error checking passes, add the event to the event table
    addEvent($conn, $uin, $programNum, $startDate, $startTime, $location, $endDate, $endTime, $eventType);

} else if (isset($_POST['add_user_btn'])) {
    // Get the data from the form
    // Validate the data make sure it is in the correct format
    $eventID = filter_var($_POST['Event_Id'], FILTER_VALIDATE_INT);
    $uin = filter_var($_POST['UIN'], FILTER_VALIDATE_INT);
    /* Error checking */
    /* Check if the user is already tracking the event */
    // Prepare statement to prevent SQL injections
    $stmt = $conn->prepare("SELECT * FROM event_tracking WHERE Event_Id = ? AND UIN = ?");
    // Bind parameters to the statement
    $stmt->bind_param("ii", $eventID, $uin);
    // Execute the statement and check if it was successful
    $stmt->execute();
    $result = $stmt->get_result();
    // If the user is already tracking the event, redirect to the event admin page with an error
    if ($result->num_rows > 0) {
        redirectTo("error=alreadytracking", 'User is already tracking this event');
    }

    /* Check if the user exists */
    // Prepare statement to prevent SQL injections
    $stmt = $conn->prepare("SELECT * FROM users WHERE UIN = ?");
    // Bind parameters to the statement
    $stmt->bind_param("i", $uin);
    // Execute the statement and check if it was successful
    $stmt->execute();
    // If the user does not exist, redirect to the event admin page with an error
    $result = $stmt->get_result();
    if ($result->num_rows == 0) {
        redirectTo("event_admin", "error=invaliduser", 'User does not exist');
    }

    /* Check if the event exists */
    // Prepare statement to prevent SQL injections
    $stmt = $conn->prepare("SELECT * FROM event WHERE Event_Id = ?");
    // Bind parameters to the statement
    $stmt->bind_param("i", $eventID);
    // Execute the statement and check if it was successful
    $stmt->execute();
    // If the event does not exist, redirect to the event admin page with an error
    $result = $stmt->get_result();
    if ($result->num_rows == 0) {
        redirectTo("event_admin", "error=invalidevent", 'Event does not exist');
    }
    
    // If all error checking passes, add the user to the event
    addUserToEvent($conn, $eventID, $uin);

} else if (isset($_POST['delete_btn'])) {
    // Get the data from the form
    $eventDeleteID = $_POST['delete_id'];
    // Delete the event from the event table
    deleteEvent($conn, $eventDeleteID);

} else if (isset($_POST['delete_event_user_btn'])) {
    // Get the data from the form
    $UINDeleteID = $_POST['delete_uin_id'];

    /* Check for dependencies in event table */
    // Prepare statement to prevent SQL injections
    $stmt = $conn->prepare("SELECT * FROM event WHERE UIN = ?");
    // Bind parameters to the statement
    $stmt->bind_param("i", $UINDeleteID);
    // Execute the statement and check if it was successful
    $stmt->execute();
    // If the user is hosting an event, redirect to the event admin page with an error
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        redirectTo("event_admin", "error=hasdependents", 'User is hosting the event');
    }
    
    // If no dependencies are found, delete the user from the event tracking table
    deleteUserFromEvent($conn, $UINDeleteID);

} else if (isset($_POST['update_btn'])) {
    // Get the data from the form
    // Validate the data make sure it is in the correct format
    $editEventID = $_POST['edit_id'];
    $editUIN = filter_var($_POST['edit_UIN'], FILTER_VALIDATE_INT);
    $editProgramNum = filter_var($_POST['edit_program_num'], FILTER_VALIDATE_INT);
    $editStartDate = $_POST['edit_start_date'];
    $editStartTime = $_POST['edit_start_time'];
    $editLocation = filter_var($_POST['edit_location'], FILTER_SANITIZE_STRING);
    $editEndDate = $_POST['edit_end_date'];
    $editEndTime = $_POST['edit_end_time'];
    $editEventType = filter_var($_POST['edit_event_type'], FILTER_SANITIZE_STRING);

    /* Error checking */
    // Program number must be a number greater than 0
    // If not redirect to the event admin page with an error
    if ($editProgramNum < 1) {
        redirectTo("event_admin", "error=invalidprogram", 'Program number must be greater than 0');
        exit();
    }

    // Start date must be before end date
    // If not redirect to the event admin page with an error
    if (!validateDateTime($editStartDate, $editStartTime, $editEndDate, $editEndTime)) {
        redirectTo("event_admin", "error=startdateafterenddate", 'Start date is after end date');
        exit();
    }

    // User must exist in the user table
    // Prepare statement to prevent SQL injections
    $stmt = $conn->prepare("SELECT * FROM users WHERE UIN = ?");
    // Bind parameters to the statement
    $stmt->bind_param("i", $editUIN);
    // Execute the statement and check if it was successful
    $stmt->execute();
    // If the user does not exist, redirect to the event admin page with an error
    $result = $stmt->get_result();
    if ($result->num_rows == 0) {
        redirectTo("event_admin", "error=invaliduser", 'User does not exist');
        exit();
    }
    
    // Program must exist in the program table
    // Prepare statement to prevent SQL injections
    $stmt = $conn->prepare("SELECT * FROM programs WHERE Program_Num = ?");
    // Bind parameters to the statement
    $stmt->bind_param("i", $editProgramNum);
    // Execute the statement and check if it was successful
    $stmt->execute();
    // If the program does not exist, redirect to the event admin page with an error
    $result = $stmt->get_result();
    if ($result->num_rows == 0) {
        redirectTo("event_admin", "error=invalidprogram", 'Program does not exist');
        exit();
    }

    // If all error checking passes, update the event in the event table
    // Prepare statement to prevent SQL injections
    $stmt = $conn->prepare("UPDATE event SET UIN = ?, Program_Num = ?, Start_Date = ?, Start_Time = ?, Location = ?, End_Date = ?, End_Time = ?, Event_Type = ? WHERE Event_Id = '$editEventID'");
    // Bind parameters to the statement
    $stmt->bind_param("iissssss", $editUIN, $editProgramNum, $editStartDate, $editStartTime, $editLocation, $editEndDate, $editEndTime, $editEventType);
    // Execute the statement and check if it was successful
    // If the statement was successful redirect to the event admin page with a success message
    // if not redirect to the event admin page with an error
    if ($stmt->execute()) {
        $_SESSION['success'] = "Event updated successfully";
        header("Location: ../pages/event_admin.php");
        $stmt->close();
        exit();
    } else {
        redirectTo("event_admin", "error=updatefailure", 'Event failed to update!');
        $stmt->close();
        exit();
    }
} else {
    // If the user tries to access this page without submitting a form, redirect to the event admin page with an error
    redirectTo("event_admin", "error=invalidaction", 'Invalid action!');
}
?>