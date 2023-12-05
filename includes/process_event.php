<!-- WRITTEN BY: NAMSON PHAM
     UIN: 530003416                         
-->
<?php
session_start();
include_once 'dbh.inc.php';
include 'helper.php';
include 'event_helper.php';

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
    /* Check the user is not a college student */
    // Prepare statement to prevent SQL injections
    $stmt = $conn->prepare("SELECT * FROM college_student WHERE UIN = ?");
    // Bind parameters to the statement
    $stmt->bind_param("i", $uin);
    // Execute the statement and check if it was successful
    // If the user is a college student, redirect to the event admin page with an error
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            redirectTo("event_admin", "error=invaliduser", 'User is a college student');
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
} 

if (isset($_POST['add_user_btn'])) {
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
} 

if (isset($_POST['delete_btn'])) {
    // Get the data from the form
    $eventDeleteID = $_POST['delete_id'];
    // Delete the event from the event table
    deleteEvent($conn, $eventDeleteID);
} 

if (isset($_POST['delete_event_user_btn'])) {
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
} 

if (isset($_POST['update_btn'])) {
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
    // User must not be a college student
    // Prepare statement to prevent SQL injections
    $stmt = $conn->prepare("SELECT * FROM college_student WHERE UIN = ?");
    // Bind parameters to the statement
    $stmt->bind_param("i", $editUIN);
    // Execute the statement and check if it was successful
    $stmt->execute();
    // If the user is a college student, redirect to the event admin page with an error
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        redirectTo("event_admin", "error=invaliduser", 'User is a college student');
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
}