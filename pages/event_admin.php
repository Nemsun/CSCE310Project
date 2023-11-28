<?php include '../assets/header.php'; ?>
<?php include '../assets/navbar.php'; ?>
<?php include '../includes/dbh.inc.php'; ?>
<?php session_start(); ?>

<div class="main-container">
    <div class="header">
        <h2>Manage Events</h2>
        <button class="add-btn">Add Event</button>
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