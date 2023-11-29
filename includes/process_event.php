<?php 
session_start();
include_once 'dbh.inc.php';

$sql = "SELECT * FROM event;";
$result = mysqli_query($conn, $sql);

if (isset($_POST['add_btn'])) {
    $uin = $_POST['uin'];
    $programNum = $_POST['program_num'];
    $startDate = $_POST['start_date'];
    $startTime = $_POST['start_time'];
    $location = $_POST['location'];
    $endDate = $_POST['end_date'];
    $endTime = $_POST['end_time'];
    $eventType = $_POST['event_type'];

    // TODO: Error Checking
    // ***Start date is before end date
    $startDateTime = new DateTime($startDate . ' ' . $startTime);
    $endDateTime = new DateTime($endDate . ' ' . $endTime);
    if ($startDateTime >= $endDateTime) {
        header("Location: ../pages/event_admin.php?error=startdateafterenddate");
        echo "Start date is after end date";
        exit();
    }
    // ***Program number should be between 1-5 (FK)
    if ($programNum < 1 || $programNum > 5) {
        header("Location: ../pages/event_admin.php?error=invalidprogramnum");
        echo "Program number should be between 1-5";
        exit();
    }
    // Database insertion
    $stmt = $conn->prepare("INSERT INTO event (UIN, Program_Num, Start_Date, Start_Time, Location, End_Date, End_Time, Event_Type) 
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("iissssss", $uin, $programNum, $startDate, $startTime, $location, $endDate, $endTime, $eventType);
    $stmt->execute();

    $stmt->close();
    $conn->close();

    header("Location: ../pages/event_admin.php?addevent=success");
    exit();

} else {
    header("Location: error.php");
    exit();
}
?>