<!--WRITTEN BY: NAMSON PHAM
    UIN: 530003416                         
-->
<?php include '../assets/student_app_header.php'; 
include '../assets/student_navbar.php'; 
include_once '../includes/dbh.inc.php';  
session_start();?>

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
        <h2>Manage Applications</h2>
    </div>
    <div class="table-wrapper">
    <div class="flex flex-col align-end min-width-180">
        <button class="add-btn" id="open-app-modal">Add Application</button>
    </div>
        <h3>Applications</h3>
        <?php
            $stmt = $conn->prepare("SELECT * FROM applications");
            $stmt->execute();
            $result = $stmt->get_result();
            $stmt->close();
        ?>
        <div class="table-container">
            <table id="app-table">
                <thead>
                    <tr>
                        <th>Application</th>
                        <th>Program</th>
                        <th>Uncompleted Certifications</th>
                        <th>Completed Certifications</th>
                        <th>Purpose Statement</th>
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
                                <td><?php echo $row['App_Num']; ?></td>
                                <td><?php echo $row['Program_Num'] ?></td>
                                <td><?php echo $row['Uncom_Cert']; ?></td>
                                <td><?php echo $row['Com_Cert']; ?></td>
                                <td><?php echo $row['Purpose_Statement']; ?></td>
                                <td>
                                    <form action="view_application_information.php" method="POST">
                                        <input type="hidden" name="view_app_id" value="<?php echo $row['App_Num']; ?>">
                                        <button type="submit" name="view_app_btn" class="table-btn view-btn">VIEW</button>
                                    </form>
                                </td>
                                <td>
                                    <form action="../includes/process_user_applications.php" method="POST">
                                        <input type="hidden" name="delete_app_id" value="<?php echo $row['App_Num']; ?>">
                                        <button type="submit" name="delete_app_btn" class="table-btn delete-btn">DELETE</button>
                                    </form>
                                </td>
                                
                            </tr>
                            <?php
                        }
                    } else {
                        $_SESSION['error'] = "No applications found in the database";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Dialogs -->
<dialog id="application-dialog" class="modal modal-app">
    <div class="modal-header">
        <h3>Add Application</h3>
        <button autofocus id="close-app-modal" class="close-modal-btn">&times;</button>
    </div>
    <form class="flex flex-col" action="../includes/process_user_applications.php" method="post">
            
        <input type="hidden" name="uin" value="<?php echo $_SESSION['user_id'] ?>">

        <label class="event-label margin-left-24" for="program-num">Program Number</label>
        <input class="modal-input" id="program-num" type="text" placeholder="Program Number" name="program_num" required>

        <label class="event-label margin-left-24" for="uncom-cert">Uncompleted Certifications</label>
        <input class="modal-input" id="uncom-cert" type="text" placeholder="Uncompleted Certifications" name="uncom_cert">

        <label class="event-label margin-left-24" for="com-cert">Completed Certifications</label>
        <input class="modal-input" id="com-cert" type="text" placeholder="Completed Certifications" name="com_cert">

        <label class="event-label margin-left-24" for="purpose-stmt">Purpose Statement</label>
        <input class="modal-input" id="purpose-stmt" type="text" placeholder="Purpose Statement" name="purpose_stmt" required>
        
        <button type="submit" class="add-btn center margin-top-10" name="add_app_btn">Add</button>
    </form>
</dialog>

<script src="../js/index.js"></script>
<script src="../js/user_application.js"></script>
