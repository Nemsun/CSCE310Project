<!--WRITTEN BY: NAMSON PHAM
    UIN: 530003416                         
-->
<?php include '../assets/user_admin_header.php'; 
include '../assets/navbar.php'; 
include_once '../includes/dbh.inc.php'; 
include '../includes/event_helper.php';
?>

<div class="main-container margin-left-280">
    <?php include '../assets/alerts.php'; ?>
    <div class="header">
        <h2>Manage Events</h2>
    </div>
    <div class="table-wrapper">
    <div class="flex flex-col align-end min-width-180">
        <button class="add-btn" id="open-event-modal">Add Event</button>
    </div>
        <h3>Event List</h3>
        <?php
            // Get all events from database
            // Prepare statement to prevent SQL injection
            $stmt = $conn->prepare("SELECT * FROM event");
            // Execute the statement
            $stmt->execute();
            // Get the result from the statement
            $result = $stmt->get_result();
            $stmt->close();
        ?>
        <div class="table-container">
            <table id="eventTable">
                <thead>
                    <tr>
                        <th>Event ID</th>
                        <th>UIN</th>
                        <th>Program</th>
                        <th>Start Date</th>
                        <th>Start Time</th>
                        <th>Location</th>
                        <th>End Date</th>
                        <th>End Time</th>
                        <th>Event Type</th>
                        <th class="hidden">.</th>
                        <th class="hidden">.</th>
                        <th class="hidden">.</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Populate table with data from database
                    // Loop through each row in the result set
                    if(mysqli_num_rows($result) > 0) {
                        while($row = mysqli_fetch_assoc($result)) {
                            ?>
                            <tr>
                                <td><?php echo $row['Event_Id']; ?></td>
                                <td><?php echo $row['UIN']; ?></td>
                                <td><?php echo $row['Program_Num']; ?></td>
                                <td><?php echo $row['Start_Date']; ?></td>
                                <td><?php echo $row['Start_Time']; ?></td>
                                <td><?php echo $row['Location']; ?></td>
                                <td><?php echo $row['End_Date']; ?></td>
                                <td><?php echo $row['End_Time']; ?></td>
                                <td><?php echo $row['Event_Type']; ?></td>
                                <td>
                                    <form action="edit_event_admin.php" method="POST">
                                        <input type="hidden" name="edit_id" value="<?php echo $row['Event_Id']; ?>">
                                        <button type="submit" name="edit_btn" class="table-btn edit-btn">EDIT</button>
                                    </form>
                                </td> 
                                <td>
                                    <form action="../includes/process_event.php" method="POST">
                                        <input type="hidden" name="delete_id" value="<?php echo $row['Event_Id']; ?>">
                                        <button type="submit" name="delete_btn" class="table-btn delete-btn">DELETE</button>
                                    </form>
                                </td>
                                <td>
                                    <form action="view_event_tracking.php" method="POST">
                                        <input type="hidden" name="view_id" value="<?php echo $row['Event_Id']?>">
                                        <button type="submit" name="view_btn" class="table-btn view-btn">VIEW</button>
                                    </form>
                                </td>
                            </tr>
                            <?php
                        }
                    } else {
                        $_SESSION['error'] = "No events found in the database";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Dialogs -->
<dialog id="event-dialog" class="modal modal-event">
    <div class="modal-header">
        <h3>Add Event</h3>
        <button autofocus id="close-event-modal" class="close-modal-btn">&times;</button>
    </div>
    <form class="flex flex-col" action="../includes/process_event.php" method="post">
        <label class="event-label margin-left-24" for="uin-id">UIN</label>
        <input class="modal-input" id="uin-id" type="text" placeholder="UIN" name="UIN" required>

        <label class="event-label margin-left-24" for="program-num">Program Number</label>
        <input class="modal-input" id="program-num" type="text" placeholder="Program Number" name="program_num" required>
        
        <label class="event-label margin-left-24" for="start-date">Start Date</label>
        <input class="modal-input" id="start-date" type="date" name="start_date" required>

        <label class="event-label margin-left-24" for="start-time">Start Time</label>
        <input class="modal-input" id="start-time" type="time" name="start_time" required>

        <label class="event-label margin-left-24" for="location-id">Location</label>
        <input class="modal-input" id="location-id" type="text" placeholder="Location" name="location" required>

        <label class="event-label margin-left-24" for="end-date">End Date</label>
        <input class="modal-input" id="end-date" type="date" name="end_date" required>

        <label class="event-label margin-left-24" for="end-time">End Time</label>
        <input class="modal-input" id="end-time" type="time" name="end_time" required>

        <label class="event-label margin-left-24" for="event-type">Event Type</label>
        <input class="modal-input" id="event-type" type="text" placeholder="Event Type" name="event_type" required>
        
        <button type="submit" class="add-btn center margin-top-10" name="add_event_btn">Add</button>
    </form>
</dialog>

<script>
    const eventDialog = document.getElementById('event-dialog');
    const openEventModal = document.getElementById('open-event-modal');
    const closeEventModal = document.getElementById('close-event-modal');

    // Adding event listeners to the open and close buttons
    openEventModal.addEventListener('click', () => {
        eventDialog.showModal();
    });

    closeEventModal.addEventListener('click', () => {
        eventDialog.close();
});
</script>

<script src="../js/index.js"></script>