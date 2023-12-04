<?php include '../assets/user_admin_header.php'; ?>
<?php include '../assets/navbar.php'; ?>
<?php include_once '../includes/dbh.inc.php'; ?>
<?php

function getUserData($conn, $UIN) {
    $stmt = $conn->prepare("SELECT * FROM users WHERE UIN = ?");
    $stmt->bind_param("i", $UIN);
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
        <h2>Manage Users</h2>
    </div>
    <div class="table-wrapper">
    <div class="flex flex-col align-end">
        <button class="add-btn" id="open-event-modal">Add User</button>
    </div>
        <h3>User List</h3>
        <?php
            $stmt = $conn->prepare("SELECT * FROM users");
            $stmt->execute();
            $result = $stmt->get_result();
            $stmt->close();
        ?>
        <div class="table-container">
            <table id="userTable">
                <thead>
                    <tr>
                        <th>UIN</th>
                        <th>First Name</th>
                        <th>M Initial</th>
                        <th>Last Name</th>
                        <th>User</th>
                        <th>Email</th>
                        <th>Discord</th>
                        <th>Username</th>
                        <th>Password</th>
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
                                <td><?php echo $row['UIN']; ?></td>
                                <td><?php echo $row['First_name']; ?></td>
                                <td><?php echo $row['M_Initial']; ?></td>
                                <td><?php echo $row['Last_Name']; ?></td>
                                <td><?php echo $row['User_Type']; ?></td>
                                <td><?php echo $row['Email']; ?></td>
                                <td><?php echo $row['Discord']; ?></td>
                                <td><?php echo $row['Username']; ?></td>
                                <td><?php echo $row['Passwords']; ?></td>
                                <td>
                                    <form action="#" method="POST">
                                        <input type="hidden" name="edit_id" value="<?php echo $row['UIN']; ?>">
                                        <button type="submit" name="edit_btn" class="table-btn edit-btn">EDIT</button>
                                    </form>
                                </td> 
                                <td>
                                    <form action="../includes/process_user.php" method="POST">
                                        <input type="hidden" name="delete_id" value="<?php echo $row['UIN']; ?>">
                                        <button type="submit" name="delete_btn" class="table-btn delete-btn">DELETE</button>
                                    </form>
                                </td>
                                <td>
                                    <form action="../includes/process_user.php" method="POST">
                                        <input type="hidden" name="delete_id" value="<?php echo $row['UIN']; ?>">
                                        <button type="submit" name="delete_btn" class="table-btn delete-btn">FULL DELETE</button>
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
</div>

<!-- Dialogs -->
<dialog id="event-dialog" class="modal modal-event">
    <div class="modal-header">
        <h3>Add Event</h3>
        <button autofocus id="close-event-modal" class="close-modal-btn">&times;</button>
    </div>
    <form action="../includes/process_event.php" method="post">
        <label class="event-label" for="uin-id">UIN</label>
        <input id="uin-id" type="text" placeholder="UIN" name="UIN" required>

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
        
        <button type="submit" class="add-btn center margin-top" name="add_event_btn">Add</button>
    </form>
</dialog>

<dialog id="event-user-dialog" class="modal modal-event-user">
    <div class="modal-header">
        <h3>Add User</h3>
        <button autofocus id="close-event-user-modal" class="close-modal-btn">&times;</button>
    </div>
    <form action="../includes/process_event.php" method="post">
        <label class="event-label" for="event-id">Event ID</label>
        <input id="event-id" type="text" placeholder="Event ID" name="Event_Id" required>

        <label class="event-label" for="user-id">User ID</label>
        <input id="user-id" type="text" placeholder="User ID" name="UIN" required>
        
        <button type="submit" class="add-btn center margin-top" name="add_user_btn">Add</button>
    </form>
</dialog>

<script src="../js/index.js"></script>
<script src="../js/event.js"></script>