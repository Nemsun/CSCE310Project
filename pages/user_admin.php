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
                console.log("Error found");
                echo '<div class="alert alert-danger" role="alert" id="alert">' . $_SESSION['error'] . '<span class="alert-close-btn" onclick="closeAlert()">&times;</span>' . '</div>';
                unset($_SESSION['error']);
            }
        ?>
    <div class="header">
        <h2>Manage Users</h2>
    </div>
    <div class="table-wrapper">
    <div class="flex flex-col align-end">
        <button class="add-btn" id="open-user-modal">Add User</button>
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

<dialog id="user-dialog" class="modal modal-event">
    <div class="modal-header">
        <h3>Add User</h3>
        <button autofocus id="close-user-modal" class="close-modal-btn">&times;</button>
    </div>
    <form class="flex flex-col" action="../includes/process_user.php" method="post">
        <label class="event-label margin-left-24" for="UIN">UIN: </label>
        <input class="modal-input" id="UIN" type="text" placeholder="UIN" name="UIN" required>

        <label class="event-label margin-left-24" for="First_name">First Name: </label>
        <input class="modal-input" id="first_name" type="text" placeholder="First Name" name="first_name" required>

        <label class="event-label margin-left-24" for="M_Initial">Middle Initial: </label>
        <input class="modal-input" id="m_initial" type="text" placeholder="Middle Initial" name="m_initial" required>

        <label class="event-label margin-left-24" for="Last_Name">Last Name: </label>
        <input class="modal-input" id="last_name" type="text" placeholder="Last Name" name="last_name" required>

        <label class="event-label margin-left-24" for="User_Type">User Type: </label>
        <select name="user_type" id="user_type">
            <option value="Admin">Admin </option>
            <option value="User">User </option>
        </select>

        <label class="event-label margin-left-24" for="Email">Email: </label>
        <input class="modal-input" id="email" type="text" placeholder="Email" name="email" required>

        <label class="event-label margin-left-24" for="Discord">Discord: </label>
        <input class="modal-input" id="discord" type="text" placeholder="Discord" name="discord" required>

        <label class="event-label margin-left-24" for="Username">Username: </label>
        <input class="modal-input" id="username" type="text" placeholder="Username" name="username" required>

        <label class="event-label margin-left-24" for="Password">Password: </label>
        <input class="modal-input" id="password" type="text" placeholder="Password" name="password" required>
        
        <button type="submit" class="add-btn center margin-top-10" name="add_user_btn">Add</button>
    </form>
</dialog>

<script src="../js/user.js"></script>
<script src="../js/index.js"></script>