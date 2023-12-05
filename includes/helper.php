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

// function redirectTo($location, $error) {
//     $_SESSION['error'] = $error;
//     header("Location: ../pages/event_admin.php?$location");
//     exit();
// }

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