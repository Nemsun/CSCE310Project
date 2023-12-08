<!-- WRITTEN BY: NAMSON PHAM
     UIN: 530003416                         
-->

<?php include '../assets/user_admin_header.php';
include '../assets/navbar.php'; 
include_once '../includes/dbh.inc.php';?>

<div class="main-container margin-left-280">
    <div class="header">
        <h2>Edit User Attendance</h2>
    </div>
    <?php
        // If the edit button is clicked, get the event id and display the event information
        // POST METHOD 
        if (isset($_POST['edit_event_user_btn'])) {
            // Get the event id from the form
            $ETEditNum = $_POST['edit_et_num'];
            // Prepare statement to prevent SQL injection
            $stmt = $conn->prepare("SELECT * FROM event_tracking WHERE ET_Num = ?");
            // Bind parameters to the statement
            $stmt->bind_param("i", $ETEditNum);
            // Execute the statement
            $stmt->execute();
            // Get the result from the statement
            $result = $stmt->get_result();
            // Close the statement
            $stmt->close();
            // Display the event information
            foreach ($result as $row) {
            ?>
            <form class="edit-form flex flex-col flex-start align-start" action="../includes/process_event.php" method="post">
                <input type="hidden" name="et_num" value="<?php echo $row['ET_Num']; ?>">
                <label class="event-label text-black font-size-l pd-10" for="et-num">Event Tracking Number</label>
                <input class="pd-20 border-radius-12 edit-input" id="et-num" type="text" value="<?php echo $row['ET_Num']?>" disabled>

                <label class="event-label text-black font-size-l pd-10" for="event-id">Event ID</label>
                <input class="pd-20 border-radius-12 edit-input" id="event-id" type="text" placeholder="Event ID" name="edit_tracking_id" value="<?php echo $row['Event_Id']?>">
                
                <label class="event-label text-black font-size-l pd-10" for="uin-id">UIN</label>
                <input class="pd-20 border-radius-12 edit-input" id="uin-id" type="text" placeholder="UIN" name="edit_tracking_uin" value="<?php echo $row['UIN']?>">

                <div class="flex space-between width-24">
                    <button type="submit" class="add-btn margin-top-20" name="update_tracking_btn">Update</button>
                    <a href="event_admin.php" class="cancel-btn margin-top-20">Cancel</a>
                </div>
            </form>
        <?php 
            } 
        } 
    ?>
</div>