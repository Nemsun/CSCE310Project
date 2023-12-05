<?php

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

function redirectTo($page, $location, $error) {
    $_SESSION['error'] = $error;
    header("Location: ../pages/$page.php?$location");
    exit();
}