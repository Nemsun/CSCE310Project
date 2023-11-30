<?php include '../assets/event_admin_header.php'; ?>
<?php include '../assets/navbar.php'; ?>
<?php include_once '../includes/dbh.inc.php'; ?>
<?php session_start(); ?>

<div class="main-container">
        <?php
            if(isset($_SESSION['success'])) {
                echo '<div class="alert alert-success" role="alert" id="alert">' . $_SESSION['success'] . '<span class="alert-close-btn" onclick="closeAlert()">&times;</span>' . '</div>';
                unset($_SESSION['success']);
            }
        ?>
    <div class="header">
        <h2>Manage Events</h2>
        <dialog id="event-dialog">
            <div class="modal-header">
                <h3>Add Event</h3>
                <button autofocus id="close-event-modal" class="close-modal-btn">&times;</button>
            </div>
            <form action="../includes/process_event.php" method="post">
                <label class="event-label" for="uin-id">UIN</label>
                <input id="uin-id" type="text" placeholder="UIN" name="uin" required>

                <label class="event-label" for="program-num">Program Number</label>
                <input id="program-num" type="text" placeholder="Program Number (1-5)" name="program_num" required>
                
                <label class="event-label" for="start-date">Start Date</label>
                <input id="start-date" type="date" name="start_date" required>

                <label class="event-label" for="start-time">Start Time</label>
                <input id="start-time" type="time" name="start_time" required>

                <label class="event-label" for="location-id">Location</label>
                <input id="location-id" type="text" placeholder="Location" name="location" required>

                <label class="event-label" for="end-date">End Date</label>
                <input id="end-date" type="date" name="end_date" required>

                <label class="event-label" for="end-time">End Time</label>
                <input id="end-time" type="time" name="end_time" required>

                <label class="event-label" for="event-type">Event Type</label>
                <input id="event-type" type="text" placeholder="Event Type" name="event_type" required>
                
                <button type="submit" class="add-btn center margin-top" name="add_btn">Add</button>
            </form>
        </dialog>
        <button class="add-btn" id="open-event-modal">Add Event</button>
    </div>
    <div class="table-wrapper">
        <h3>Event List</h3>
        <?php
            $query = "SELECT * FROM event";
            $query_run = mysqli_query($conn, $query);
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
                </tr>
            </thead>
            <tbody>
                <?php
                if(mysqli_num_rows($query_run) > 0) {
                    while($row = mysqli_fetch_assoc($query_run)) {
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
                                <form action="edit_event.php" method="POST">
                                    <input type="hidden" name="edit_id" value="<?php echo $row['Event_Id']; ?>">
                                    <button type="submit" name="edit_btn" class="edit-btn">EDIT</button>
                                </form>
                            </td> 
                            <td>
                                <form action="../includes/process_event.php" method="POST">
                                    <input type="hidden" name="delete_id" value="<?php echo $row['Event_Id']; ?>">
                                    <button type="submit" name="delete_btn" class="delete-btn">DELETE</button>
                                </form>
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
</div>

<script src="../js/index.js"></script>