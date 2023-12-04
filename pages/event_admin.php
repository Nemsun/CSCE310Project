<!--WRITTEN BY: NAMSON PHAM
    UIN: 530003416                         
-->
<?php include '../assets/event_admin_header.php'; 
include '../assets/navbar.php'; 
include_once '../includes/dbh.inc.php'; 
session_start();

function getEventTrackingData($conn, $eventId) {
    $stmt = $conn->prepare("SELECT * FROM event_tracking WHERE Event_Id = ?");
    $stmt->bind_param("i", $eventId);
    $stmt->execute();    
    $result = $stmt->get_result();
    $data = array();
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    $stmt->close();
    return $data;
}
?>

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
        <h2>Manage Events</h2>
    </div>
    <div class="table-wrapper">
    <div class="flex flex-col align-end min-width-180">
        <button class="add-btn" id="open-event-modal">Add Event</button>
    </div>
        <h3>Event List</h3>
        <?php
            $stmt = $conn->prepare("SELECT * FROM event");
            $stmt->execute();
            $result = $stmt->get_result();
            $stmt->close();
        ?>
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
                                <button type="button" name="view_btn" class="table-btn view-btn" onclick="showEventTrackingDetails(<?php echo $row['Event_Id']; ?>)">VIEW</button>
                                <input type="hidden" id="eventTrackingData <?php echo $row['Event_Id']; ?>" 
                                    value='<?php echo json_encode(getEventTrackingData($conn, $row['Event_Id'])); ?>'
                                >
                            </td>
                        </tr>
                        <?php
                    }
                } else {
                    echo "No record found";
                }
                ?>
            </tbody>
        </table>
    </div>
    <div id="event-tracking" class="table-wrapper margin-top-40">
        <div class="flex flex-col align-end">
            <button class="add-btn" id="open-event-user-modal">Add User</button>
        </div>
        <h3>Event Tracking List</h3>
        <table>
            <thead>
                <tr>
                    <th>Event Tracking Number</th>
                    <th>Event ID</th>
                    <th>UIN</th>
                    <th class="hidden">.</th>
                </tr>
            </thead>
            <tbody id="eventTrackingTableBody">
                <!-- Populate table -->
            </tbody>
        </table>
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
        <input class="modal-input" id="program-num" type="text" placeholder="Program Number (1-5)" name="program_num" required>
        
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

<dialog id="event-user-dialog" class="modal modal-event-user">
    <div class="modal-header">
        <h3>Add User</h3>
        <button autofocus id="close-event-user-modal" class="close-modal-btn">&times;</button>
    </div>
    <form class="flex flex-col" action="../includes/process_event.php" method="post">
        <label class="event-label margin-left-24" for="event-id">Event ID</label>
        <input class="modal-input" id="event-id" type="text" placeholder="Event ID" name="Event_Id" required>

        <label class="event-label margin-left-24" for="user-id">User ID</label>
        <input class="modal-input" id="user-id" type="text" placeholder="User ID" name="UIN" required>
        
        <button type="submit" class="add-btn center margin-top-10" name="add_user_btn">Add</button>
    </form>
</dialog>

<script src="../js/index.js"></script>
<script src="../js/event.js"></script>