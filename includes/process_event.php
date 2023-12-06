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
    if (!checkUser($conn, $uin)) {
        // If the user does not exist, redirect to the event admin page with an error
        redirectTo("event_admin", "error=invaliduser", 'User does not exist');
    }
    /* Check the user is not a college student */
    if (checkCollegeStudent($conn, $uin)) {
        // If the user is a college student, redirect to the event admin page with an error
        redirectTo("event_admin", "error=invaliduser", 'User is a college student');
    }
    /* Check the program number exists in program table */
    if (!checkPrograms($conn, $programNum)) {
        // If the program does not exist, redirect to the event admin page with an error
        redirectTo("event_admin", "error=invalidprogram", 'Program does not exist');
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
    if (checkUserAttending($conn, $eventID, $uin)) {
        // If the user is already tracking the event, redirect to the event admin page with an error
        redirectTo("view_event_tracking", "error=alreadytracking", 'User is already tracking the event');
    }
    /* Check if the user exists */
    if (!checkUser($conn, $uin)) {
        // If the user does not exist, redirect to the event admin page with an error
        redirectTo("view_event_tracking", "error=invaliduser", 'User does not exist');
    }
    /* Check if the event exists */
    if (checkEventExists($conn, $eventID)) {
        // If the event does not exist, redirect to the event admin page with an error
        redirectTo("view_event_tracking", "error=invalidevent", 'Event does not exist');
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
    $ETNumDelete = $_POST['delete_et_num'];
    if (checkUserHost($conn, $ETNumDelete)) {
        // If the user is hosting the event, redirect to the event admin page with an error
        redirectTo("event_admin", "error=hostingevent", 'User is hosting the event');
    }
    // If no dependencies are found, delete the user from the event tracking table
    deleteUserFromEvent($conn, $ETNumDelete);
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
    if (!checkUser($conn, $editUIN)) {
        // If the user does not exist, redirect to the event admin page with an error
        redirectTo("event_admin", "error=invaliduser", 'User does not exist');
        exit();
    }
    // User must not be a college student
    if (checkCollegeStudent($conn, $editUIN)) {
        // If the user is a college student, redirect to the event admin page with an error
        redirectTo("event_admin", "error=invaliduser", 'User is a college student');
        exit();
    }
    // Program must exist in the program table
    if (!checkPrograms($conn, $editProgramNum)) {
        // If the program does not exist, redirect to the event admin page with an error
        redirectTo("event_admin", "error=invalidprogram", 'Program does not exist');
        exit();
    }
    // If all error checking passes, update the event in the event table
    updateEvent($conn, $editUIN, $editProgramNum, $editStartDate, $editStartTime, $editLocation, $editEndDate, $editEndTime, $editEventType, $editEventID);
}
    
if (isset($_POST['update_tracking_btn'])) {
    // Get the data from the form
    // Validate the data make sure it is in the correct format
    $eventTrackingNum = $_POST['et_num'];
    $editEventID = filter_var($_POST['edit_tracking_id'], FILTER_VALIDATE_INT);
    $editUIN = filter_var($_POST['edit_track_uin'], FILTER_VALIDATE_INT);
    /* Error checking */
    if (!checkUser($conn, $editUIN)) {
        // If the user does not exist, redirect to the event admin page with an error
        redirectTo("event_admin", "error=invaliduser", 'User does not exist');
        exit();
    }
    if (checkUserAttending($conn, $editEventID, $editUIN)) {
        // If the user is already tracking the event, redirect to the event admin page with an error
        redirectTo("event_admin", "error=alreadytracking", 'User is already tracking the event');
        exit();
    }
    if (!checkEventExists($conn, $editEventID)) {
        // If the event does not exist, redirect to the event admin page with an error
        redirectTo("event_admin", "error=invalidevent", 'Event does not exist');
        exit();
    }
    // if all error checking passes, update the event in the event tracking table
    updateTracking($conn, $editEventID, $editUIN, $eventTrackingNum);
}