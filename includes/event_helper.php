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
        $_SESSION['success'] = 'Event added successfully!';
        header("Location: ../pages/event_admin.php?addevent=success");
        $stmt->close();
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
    exit();
}

/**
 * This function deletes a user from an event tracking table
 * @param $conn - the connection to the database
 * @param $UIN - the UIN of the user to be deleted
 */
function deleteUserFromEvent($conn, $ETNum) {
    // Prepare statement to prevent SQL injections
    $stmt = $conn->prepare("DELETE FROM event_tracking WHERE ET_Num = ?");
    // Bind parameters to the statement
    $stmt->bind_param("i", $ETNum);
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

/**
 * This function updates an event in the event table
 * @param $conn - the connection to the database
 * @param $UIN - the UIN of the student
 * @param $ProgramNum - the program number of the program the student is applying to
 * @param $StartDate - the start date of the event
 * @param $EndDate - the end date of the event
 * @param $Location - the location of the event
 * @param $EndDate - the end date of the event
 * @param $EndTime - the end time of the event
 * @param $EventType - the event type
 */
function updateEvent($conn, $UIN, $ProgramNum, $StartDate, $StartTime, $Location, $EndDate, $EndTime, $EventType, $EventID) {
    // Prepare statement to prevent SQL injections
    $stmt = $conn->prepare("UPDATE event SET UIN = ?, Program_Num = ?, Start_Date = ?, Start_Time = ?, Location = ?, End_Date = ?, End_Time = ?, Event_Type = ? WHERE Event_Id = '$EventID'");
    // Bind parameters to the statement
    $stmt->bind_param("iissssss", $UIN, $ProgramNum, $StartDate, $StartTime, $Location, $EndDate, $EndTime, $EventType);
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

/**
 * This function updates an event in the event tracking table
 * @param $conn - the connection to the database
 * @param $ETNum - the event tracking number of the event to be updated
 * @param $EventID - the event ID of the event to be updated
 * @param $UIN - the UIN of the user to be updated
 */
function updateTracking($conn, $ETNum, $EventID, $UIN) {
    // Prepare statement to prevent SQL injections
    $stmt = $conn->prepare("UPDATE event_tracking SET Event_Id = ?, UIN = ? WHERE ET_Num = '$ETNum'");
    // Bind parameters to the statement
    $stmt->bind_param("ii", $EventID, $UIN);
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


/**
 * This function gets the user type of a user
 * @param $conn - the connection to the database
 * @param $UIN - the UIN of the user
 * @return mixed - the user type of the user
 */
function getUserType($conn, $UIN) {
    // Prepare statement to prevent SQL injections
    $stmt = $conn->prepare("SELECT User_Type FROM users WHERE UIN = ?");
    // Bind parameters to the statement
    $stmt->bind_param("i", $UIN);
    // Execute the statement
    $stmt->execute();
    // Get the result from the statement
    $result = $stmt->get_result();
    $data = $result->fetch_assoc();
    // Close the statement
    $stmt->close();
    // Return the result
    return $data;
}

/**
 * This function gets the user host uin
 * @param $conn - the connection to the database
 * @param $EventID - the event ID of the event
 * @return mixed - the user host uin of the event
 */
function getUserHostUIN($conn, $EventID) {
    // Prepare statement to prevent SQL injections
    $stmt = $conn->prepare("SELECT UIN FROM event WHERE Event_Id = ?");
    // Bind parameters to the statement
    $stmt->bind_param("i", $EventID);
    // Execute the statement
    $stmt->execute();
    // Get the result from the statement
    $result = $stmt->get_result();
    $data = $result->fetch_assoc();
    // Close the statement
    $stmt->close();
    // Return the result
    return $data;
}

// ERROR CHECKING FUNCTIONS BELOW

/**
 * This function checks if the user is already tracking the event
 * @param $conn - the connection to the database
 * @param $eventID - the event ID of the event to be checked
 * @param $UIN - the UIN of the user to be checked
 * @return bool - true if the user is already tracking the event, false otherwise
 */
function checkUserAttending($conn, $eventID, $UIN) {
    // Prepare statement to prevent SQL injections
    $stmt = $conn->prepare("SELECT * FROM event_tracking WHERE Event_Id = ? AND UIN = ?");
    // Bind parameters to the statement
    $stmt->bind_param("ii", $eventID, $UIN);
    // Execute the statement
    $stmt->execute();
    // Get the result from the statement
    $result = $stmt->get_result();
    $stmt->close();
    return mysqli_num_rows($result) > 0;
}

/**
 * This function checks if the user is hosting an event
 * @param $conn - the connection to the database
 * @param $ET_Num - the event tracking number of the event to be checked
 * @return bool - true if the user is hosting an event, false otherwise
 */
function checkUserHost($conn, $ET_Num) {
    // Prepare statement to prevent SQL injections
    $stmt = $conn->prepare("SELECT * FROM event_tracking WHERE ET_Num = ?");
    // Bind parameters to the statement
    $stmt->bind_param("i", $ET_Num);
    // Execute the statement
    $stmt->execute();
    // Get the result from the statement
    $result = $stmt->get_result();
    $data = $result->fetch_assoc();
    $stmt->close();
    $uin = $data['UIN'];
    // Prepare statement to prevent SQL injections
    $stmt = $conn->prepare("SELECT * FROM event WHERE UIN = ?");
    // Bind parameters to the statement
    $stmt->bind_param("i", $uin);
    // Execute the statement
    $stmt->execute();
    // Get the result from the statement
    $result = $stmt->get_result();
    $stmt->close();
    return mysqli_num_rows($result) > 0;
}

/**
 * This function checks if the event exists
 * @param $conn - the connection to the database
 * @param $eventID - the event ID of the event to be checked
 * @return bool - true if the event exists, false otherwise
 */
function checkEventExists($conn, $eventID) {
    // Prepare statement to prevent SQL injections
    $stmt = $conn->prepare("SELECT * FROM event WHERE Event_Id = ?");
    // Bind parameters to the statement
    $stmt->bind_param("i", $eventID);
    // Execute the statement
    $stmt->execute();
    // Get the result from the statement
    $result = $stmt->get_result();
    $stmt->close();
    return mysqli_num_rows($result) > 0;
}