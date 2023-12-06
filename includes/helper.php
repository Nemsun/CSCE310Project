<!-- WRITTEN BY: NAMSON PHAM
     UIN: 530003416 -->
<?php
// GENERAL FUNCTIONS
/**
 * This function validates the start date + start time and end date + end time
 * @param $startDate - the start date
 * @param $startTime - the start time
 * @param $endDate - the end date
 * @param $endTime - the end time
 * @return bool - true if the start date + start time is before the end date + end time
 */
function validateDateTime($startDate, $startTime, $endDate, $endTime) {
    $startDateTime = new DateTime($startDate . ' ' . $startTime);
    $endDateTime = new DateTime($endDate . ' ' . $endTime);

    return $startDateTime < $endDateTime;
}

/**
 * This function redirects the user to the specified page with the specified error message
 * @param $page - the page to redirect to
 * @param $location - the location to redirect to
 * @param $error - the error message to display
 */
function redirectTo($page, $location, $error) {
    $_SESSION['error'] = $error;
    header("Location: ../pages/$page.php?$location");
    exit();
}

/**
 * This function checks if the user is in the database
 * @param $conn - the connection to the database
 * @param $UIN - the UIN of the user
 * @return bool - true if the user is in the database, false otherwise
 */
function checkUser($conn, $UIN) {
    // Prepare statement to prevent SQL injections
    $stmt = $conn->prepare("SELECT * FROM users WHERE UIN = ?");
    // Bind parameters to the statement
    $stmt->bind_param("i", $UIN);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    return mysqli_num_rows($result) > 0;
}

/**
 * This function checks if the user is a student
 * @param $conn - the connection to the database
 * @param $UIN - the UIN of the user
 * @return bool - true if the user is a student, false otherwise
 */
function checkCollegeStudent($conn, $UIN) {
    // Prepare statement to prevent SQL injections
    $stmt = $conn->prepare("SELECT * FROM college_student WHERE UIN = ?");
    // Bind parameters to the statement
    $stmt->bind_param("i", $UIN);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    return mysqli_num_rows($result) > 0;
}

/**
 * This function checks if the program is in the database
 * @param $conn - the connection to the database
 * @param $programNum - the program number of the program
 * @return bool - true if the program is in the database, false otherwise
 */
function checkPrograms($conn, $programNum) {
    // Prepare statement to prevent SQL injections
    $stmt = $conn->prepare("SELECT * FROM programs WHERE Program_Num = ?");
    // Bind parameters to the statement
    $stmt->bind_param("i", $programNum);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    return mysqli_num_rows($result) > 0;
}