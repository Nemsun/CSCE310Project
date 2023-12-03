<?php include '../assets/event_admin_header.php';
include '../assets/navbar.php'; 
include_once '../includes/dbh.inc.php';
session_start(); ?>

<div class="main-container">
        <?php
            if(isset($_SESSION['success'])) {
                echo '<div class="alert alert-success" role="alert" id="alert">' . $_SESSION['success'] . '<span class="alert-close-btn" onclick="closeAlert()">&times;</span>' . '</div>';
                unset($_SESSION['success']);
            } else if(isset($_SESSION['error'])) {
                echo '<div class="alert alert-danger" role="alert" id="alert">' . $_SESSION['error'] . '<span class="alert-close-btn" onclick="closeAlert()">&times;</span>' . '</div>';
                unset($_SESSION['error']);
            }
        ?>
    <div class="header">
        <h2>Edit Event</h2>
    </div>
    <form class="edit-form flex flex-col flex-start align-start" action="#" method="post">
        <label class="event-label text-black font-size-l pd-10" for="uin-id">UIN</label>
        <input class="pd-20 border-radius-12 edit-input" id="uin-id" type="text" placeholder="UIN" name="UIN">

        <label class="event-label text-black font-size-l pd-10" for="program-num">Program Number</label>
        <input class="pd-20 border-radius-12 edit-input" id="program-num" type="text" placeholder="Program Number (1-5)" name="program_num">
        
        <label class="event-label text-black font-size-l pd-10" for="start-date">Start Date</label>
        <input class="pd-20 border-radius-12 edit-input" id="start-date" type="date" name="start_date">

        <label class="event-label text-black font-size-l pd-10" for="start-time">Start Time</label>
        <input class="pd-20 border-radius-12 edit-input" id="start-time" type="time" name="start_time">

        <label class="event-label text-black font-size-l pd-10" for="location-id">Location</label>
        <input class="pd-20 border-radius-12 edit-input" id="location-id" type="text" placeholder="Location" name="location">

        <label class="event-label text-black font-size-l pd-10" for="end-date">End Date</label>
        <input class="pd-20 border-radius-12 edit-input" id="end-date" type="date" name="end_date">

        <label class="event-label text-black font-size-l pd-10" for="end-time">End Time</label>
        <input class="pd-20 border-radius-12 edit-input" id="end-time" type="time" name="end_time">

        <label class="event-label text-black font-size-l pd-10" for="event-type">Event Type</label>
        <input class="pd-20 border-radius-12 edit-input" id="event-type" type="text" placeholder="Event Type" name="event_type">
        
        <button type="submit" class="add-btn margin-top-20" name="edit_btn">Update</button>
    </form>
</div>