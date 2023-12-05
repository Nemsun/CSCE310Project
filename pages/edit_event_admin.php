<!-- WRITTEN BY: NAMSON PHAM
     UIN: 530003416                         
-->

<?php include '../assets/event_admin_header.php';
include '../assets/navbar.php'; 
include_once '../includes/dbh.inc.php';
session_start(); ?>

<div class="main-container margin-left-280">
    <div class="header">
        <h2>Edit Event</h2>
    </div>
    <?php
        if (isset($_POST['edit_btn'])) {
            $eventEditID = $_POST['edit_id'];
            $stmt = $conn->prepare("SELECT * FROM event WHERE Event_Id = ?");
            $stmt->bind_param("i", $eventEditID);
            $stmt->execute();
            $result = $stmt->get_result();
            $stmt->close();
            foreach ($result as $row) {
            ?>
            <form class="edit-form flex flex-col flex-start align-start" action="../includes/process_edit_event.php" method="post">
                <input type="hidden" name="edit_id" value="<?php echo $row['Event_Id']; ?>">
                <label class="event-label text-black font-size-l pd-10" for="uin-id">UIN</label>
                <input class="pd-20 border-radius-12 edit-input" id="uin-id" type="text" placeholder="UIN" name="edit_UIN" value="<?php echo $row['UIN']?>">

                <label class="event-label text-black font-size-l pd-10" for="program-num">Program Number</label>
                <input class="pd-20 border-radius-12 edit-input" id="program-num" type="text" placeholder="Program Number" name="edit_program_num" value="<?php echo $row['Program_Num']?>">
                
                <label class="event-label text-black font-size-l pd-10" for="start-date">Start Date</label>
                <input class="pd-20 border-radius-12 edit-input" id="start-date" type="date" name="edit_start_date" value="<?php echo $row['Start_Date']?>">

                <label class="event-label text-black font-size-l pd-10" for="start-time">Start Time</label>
                <input class="pd-20 border-radius-12 edit-input" id="start-time" type="time" name="edit_start_time" value="<?php echo $row['Start_Time']?>">

                <label class="event-label text-black font-size-l pd-10" for="location-id">Location</label>
                <input class="pd-20 border-radius-12 edit-input" id="location-id" type="text" placeholder="Location" name="edit_location" value="<?php echo $row['Location']?>">

                <label class="event-label text-black font-size-l pd-10" for="end-date">End Date</label>
                <input class="pd-20 border-radius-12 edit-input" id="end-date" type="date" name="edit_end_date" value="<?php echo $row['End_Date']?>">

                <label class="event-label text-black font-size-l pd-10" for="end-time">End Time</label>
                <input class="pd-20 border-radius-12 edit-input" id="end-time" type="time" name="edit_end_time" value="<?php echo $row['End_Time']?>">

                <label class="event-label text-black font-size-l pd-10" for="event-type">Event Type</label>
                <input class="pd-20 border-radius-12 edit-input" id="event-type" type="text" placeholder="Event Type" name="edit_event_type" value="<?php echo $row['Event_Type']?>">
                
                <div class="flex space-between width-50">
                    <button type="submit" class="add-btn margin-top-20" name="update_btn">Update</button>
                    <a href="event_admin.php" class="cancel-btn margin-top-20">Cancel</a>
                </div>
            </form>
        <?php 
            } 
        } 
    ?>
</div>