<?php include '../assets/user_admin_header.php'; 
include '../assets/navbar.php'; 
include_once '../includes/dbh.inc.php'; 

function getUserData($conn, $UIN) {
    $stmt = $conn->prepare("SELECT * FROM college_student WHERE UIN = ?");
    $stmt->bind_param("i", $UIN);
    $stmt->execute();    
    $result = $stmt->get_result();
    $data = $result->fetch_assoc();
    return $data;
}
?>

<div class="main-container margin-left-280">
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
                                <?php if ($row['User_Type'] == 'Student') { ?>
                                <td>
                                    <form action="user_admin.php" method="POST">
                                        <input type="hidden" name="UIN" value="<?php echo $row['UIN']?>">
                                        <button type="submit" name="view_btn" class="table-btn view-btn">VIEW</button>
                                    </form>
                                </td>
                                <?php } else { ?>
                                    <td> </td>
                                <?php } ?>
                                <td>
                                    <form action="edit_user_admin.php" method="POST">
                                        <input type="hidden" name="edit_id" value="<?php echo $row['UIN']; ?>">
                                        <button type="submit" name="edit_btn" class="table-btn edit-btn">EDIT</button>
                                    </form>
                                </td> 
                                <td>
                                    <form action="../includes/process_user.php" method="POST">
                                        <input type="hidden" name="UIN" value="<?php echo $row['UIN']; ?>">
                                        <button type="submit" name="delete_btn" class="table-btn delete-btn">DELETE</button>
                                    </form>
                                </td>
                                <td>
                                    <form action="../includes/process_user.php" method="POST">
                                        <input type="hidden" name="UIN" value="<?php echo $row['UIN']; ?>">
                                        <button type="submit" name="hard_delete_btn" class="table-btn full-delete-btn">FULL DELETE</button>
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

    <br>
    <div class="table-wrapper" id="specificTable">
        <h2> View Student </h2>
        <div class="table-container">
            <table id="userTable">
                <thead>
                    <tr>
                        <th>Info</th>
                        <th>Value</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        if (isset($_POST['view_btn'])) {
                            $currentUIN = $_POST['UIN'];
                            $userData = getUserData($conn, $currentUIN);
                            if ($userData) {

                            ?>
                    <tr>
                        <td>UIN</td>
                        <td><?php echo $userData['UIN'];?></td>
                    </tr>
                    <tr>
                        <td>Gender</td>
                        <td><?php echo $userData['Gender'];?></td>
                    </tr>
                    <tr>
                        <td>Hispanic</td>
                        <td><?php echo $userData['Hispanic'];?></td>
                    </tr>
                    <tr>
                        <td>Race</td>
                        <td><?php echo $userData['Race'];?></td>
                    </tr>
                    <tr>
                        <td>Citizen</td>
                        <td><?php echo $userData['Citizen'];?></td>
                    </tr>
                    <tr>
                        <td>First Generation</td>
                        <td><?php echo $userData['First_Generation'];?></td>
                    </tr>
                    <tr>
                        <td>Date of Birth</td>
                        <td><?php echo $userData['DoB'];?></td>
                    </tr>
                    <tr>
                        <td>GPA</td>
                        <td><?php echo $userData['GPA'];?></td>
                    </tr>
                    <tr>
                        <td>Major</td>
                        <td><?php echo $userData['Major'];?></td>
                    </tr>
                    <tr>
                        <td>Minor #1</td>
                        <td><?php echo $userData['Minor_1'];?></td>
                    </tr>
                    <tr>
                        <td>Minor #2</td>
                        <td><?php echo $userData['Minor_2'];?></td>
                    </tr>
                    <tr>
                        <td>Expected Graduation Year</td>
                        <td><?php echo $userData['Expected_Graduation'];?></td>
                    </tr>
                    <tr>
                        <td>School</td>
                        <td><?php echo $userData['School'];?></td>
                    </tr>
                    <tr>
                        <td>Classification</td>
                        <td><?php echo $userData['Classification'];?></td>
                    </tr>
                    <tr>
                        <td>Phone Number</td>
                        <td><?php echo $userData['Phone'];?></td>
                    </tr>
                    <tr>
                        <td>Student Type</td>
                        <td><?php echo $userData['Student_Type'];?></td>
                    </tr>
            </table>
            <?php 
                            } else {
                                echo "Student not selected or hasn't completed information";
                            }
                        }
            ?>
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
            <option value="Admin">Admin</option>
            <option value="Student">Student</option>
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