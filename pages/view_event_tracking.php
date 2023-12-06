<!-- WRITTEN BY: NAMSON PHAM
     UIN: 530003416 -->
<?php include '../assets/user_admin_header.php';
include '../assets/navbar.php'; 
include_once '../includes/dbh.inc.php';
include '../includes/event_helper.php';?>

<div class="main-container margin-left-280">
    <?php include '../assets/alerts.php'; ?>
    <div class="header">
        <h2>Edit Event Attendance</h2>
    </div>
    <?php
        $eventID = "";
        // If the edit button is clicked, get the ET num and display the event information
        // List all attendees for the event
        // POST METHOD
        if (isset($_POST['view_btn'])) {
            // Get the event tracking number from the form
            $eventID = $_POST['view_id'];
            // Prepare statement to prevent SQL injection
            $stmt = $conn->prepare("SELECT * FROM event_tracking WHERE Event_Id = ?");
            // Bind parameters to the statement
            $stmt->bind_param("i", $eventID);
            // Execute the statement
            $stmt->execute();
            $result = $stmt->get_result();
            $stmt->close();
        }
    ?>
    <div class="table-wrapper margin-top-40">
        <div class="flex flex-col align-end">
            <button class="add-btn" id="open-event-tracking-modal">Add User</button>
        </div>
        <h3>Attendance List</h3>
        <div class="table-container">
            <table id="eventTracking" class ="table-container">
                <thead>
                    <tr>
                        <th>Event Tracking Number</th>
                        <th>Event ID</th>
                        <th>UIN</th>
                        <th class="hidden">.</th>
                        <th class="hidden">.</th>
                </thead>
                <tbody>
                    <?php
                    // Populate table with data from database
                    // Loop through each row in the result set
                    if(mysqli_num_rows($result) > 0) {
                        while($row = mysqli_fetch_assoc($result)) {
                            $userType = getUserType($conn, $row['UIN']);
                            $hostUIN = getUserHostUIN($conn, $row['Event_Id']);
                            ?>
                            <tr>
                                <td><?php echo $row['ET_Num']; ?></td>
                                <td><?php echo $row['Event_Id']; ?></td>
                                <td><?php echo $row['UIN']; ?></td>
                                <td>
                                    <form action="edit_event_tracking.php" method="post">
                                        <input type="hidden" name="edit_et_num" value="<?php echo $row['ET_Num']; ?>">
                                        <button type="submit" id="edit-user-btn" name="edit_event_user_btn" class="table-btn edit-btn">EDIT</button>
                                    </form>
                                </td>
                                <?php if ($userType['User_Type'] != 'Admin' || $hostUIN['UIN'] != $row['UIN']) { ?>
                                    <td>
                                        <form action="../includes/process_event.php" method="post">
                                            <input type="hidden" name="delete_et_num" value="<?php echo $row['ET_Num']; ?>">
                                            <button type="submit" id="delete-user-btn" name="delete_event_user_btn" class="table-btn delete-btn">DELETE</button>
                                        </form>
                                    </td>
                                <?php } else { ?>
                                <td> </td>
                                <?php } ?>
                            </tr>
                            <?php
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="flex flex-row justify-end margin-top-10">
        <a href="event_admin.php" class="cancel-btn margin-top-20">Back</a>
    </div>
</div> 

<!-- Dialog -->
<dialog id="event-tracking-dialog" class="modal modal-event-user">
    <div class="modal-header">
        <h3>Add User</h3>
        <button autofocus id="close-event-tracking-modal" class="close-modal-btn">&times;</button>
    </div>
    <form class="flex flex-col" action="../includes/process_event.php" method="post">
        <input type="hidden" name="Event_Id" value="<?php echo $eventID; ?>">

        <label class="event-label margin-left-24" for="user-id">User ID</label>
        <input class="modal-input" id="user-id" type="text" placeholder="User ID" name="UIN" required>
        
        <button type="submit" class="add-btn center margin-top-10" name="add_user_btn">Add</button>
    </form>
</dialog>

<script src="../js/index.js"></script>
<script>
    // Grabbing the event tracking dialog and the open and close buttons
    const eventUserDialog = document.getElementById('event-tracking-dialog');
    const openEventUserModal = document.getElementById('open-event-tracking-modal');
    const closeEventUserModal = document.getElementById('close-event-tracking-modal');

    // Adding event listeners to the open and close buttons
    openEventUserModal.addEventListener('click', () => {
        eventUserDialog.showModal();
    });

    closeEventUserModal.addEventListener('click', () => {
        eventUserDialog.close();
    });
</script>