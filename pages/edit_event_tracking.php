<?php include '../assets/user_admin_header.php';
include '../assets/navbar.php'; 
include_once '../includes/dbh.inc.php';?>

<div class="main-container margin-left-280">
    <div class="header">
        <h2>Edit Event Attendance</h2>
    </div>
    <?php
        // If the edit button is clicked, get the ET num and display the event information
        // List all attendees for the event
        // POST METHOD
        if (isset($_POST['edit_event_tracking'])) {
            $eventTrackingNum = $_POST['edit_et_num'];
            echo "<h3>Event Tracking Number: $eventTrackingNum</h3>";
        }
    ?>
</div>  