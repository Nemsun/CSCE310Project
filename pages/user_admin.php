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
        <button class="add-btn" id="openUserButton">Add User</button>
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
                                        <button type="submit" name="delete_btn" class="table-btn full-delete-btn">FULL DELETE</button>
                                    </form>
                                </td>
                            </tr>
                            <?php
                        }
                    } else {
                        echo "No Users Found";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<dialog id="user-dialog" class="modal modal-event-user">
    <div class="modal-header">
        <h3>Add User</h3>
        <button autofocus id="close-user-modal" class="close-modal-btn">&times;</button>
    </div>
    <form class="flex flex-col" action="../includes/process_event.php" method="post">
        <label class="event-label margin-left-24" for="event-id">Event ID</label>
        <input class="modal-input" id="event-id" type="text" placeholder="Event ID" name="Event_Id" required>

        <label class="event-label margin-left-24" for="user-id">User ID</label>
        <input class="modal-input" id="user-id" type="text" placeholder="User ID" name="UIN" required>
        
        <button type="submit" class="add-btn center margin-top-10" name="add_user_btn">Add</button>
    </form>
</dialog>

<script src="../js/user.js"></script>
<script src="../js/index.js"></script>