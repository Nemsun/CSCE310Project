<!-- WRITTEN BY: NAMSON PHAM
     UIN: 530003416
 -->
<?php
// HELPER FUNCTIONS FOR PROCESSING EVENT ADMIN REQUESTS
/**
 * This function adds an event to the events table in the database
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