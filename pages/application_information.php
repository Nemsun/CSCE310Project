<!--WRITTEN BY: NAMSON PHAM
    UIN: 530003416
-->
<?php include '../assets/header.php';
include '../assets/student_navbar.php';
include_once '../includes/dbh.inc.php';
?>

<div class="main-container margin-left-280">
    <?php include '../assets/alerts.php'; ?>
    <div class="header">
        <h2>Manage Applications</h2>
    </div>
    <div class="table-wrapper">
    <div class="flex flex-col align-end min-width-180">
        <button class="add-btn" id="open-app-modal">Add Application</button>
    </div>
        <h3>Applications</h3>
        <?php
            // Get all applications from database
            // Prepare statement to prevent SQL injection
            $stmt = $conn->prepare("SELECT * FROM applications WHERE UIN = ?");
            // Bind statement
            $stmt->bind_param("i", $_SESSION['user_id']);
            // Execute the statement
            $stmt->execute();
            // Get the result from the statement
            $result = $stmt->get_result();
            $stmt->close();
        ?>
        <div class="table-container">
            <table id="app-table">
                <thead>
                    <tr>
                        <th>Program Number</th>
                        <th>Program Name</th>
                        <th>Uncompleted Certifications</th>
                        <th>Completed Certifications</th>
                        <th>Purpose Statement</th>
                        <th class="hidden">.</th>
                        <th class="hidden">.</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Populate table with data from database
                    if(mysqli_num_rows($result) > 0) {
                        while($row = mysqli_fetch_assoc($result)) {
                            // Prepare sstatement to prevent SQL injection
                            $stmt = $conn->prepare("SELECT Name FROM programs WHERE Program_Num = ?");
                            // Bind statement
                            $stmt->bind_param("i", $row['Program_Num']);
                            // Execute the statement
                            $stmt->execute();
                            // Get the result from the statement
                            $nameResult = $stmt->get_result();
                            // Put result into an itemized array
                            $data = $nameResult->fetch_assoc();
                            $stmt->close();
                            ?>
                            <tr>
                                <td><?php echo $row['Program_Num'] ?></td>
                                <td><?php echo $data['Name']?></td>
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

    <div class="table-wrapper margin-top-10">
    <h3>Programs</h3>
        <?php
            // Get all programs from database
            // Prepare statement to prevent SQL injection
            $stmt = $conn->prepare("SELECT Program_Num,Name FROM programs");
            // Execute the statement
            $stmt->execute();
            // Get the result from the statement
            $result = $stmt->get_result();
            $stmt->close();
        ?>
        <div class="table-container">
            <table id="program-table">
                <thead>
                    <tr>
                        <th>Program Number</th>
                        <th>Program Name</th>
                        <th class="hidden">.</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Populate table with data from database
                    if(mysqli_num_rows($result) > 0) {
                        while($row = mysqli_fetch_assoc($result)) {
                            ?>
                            <tr>
                                <td><?php echo $row['Program_Num'] ?></td>
                                <td><?php echo $row['Name']?></td>
                                <td>
                                    <form action="view_program_information.php" method="POST">
                                        <input type="hidden" name="view_program_id" value="<?php echo $row['Program_Num']; ?>">
                                        <button type="submit" name="view_program_btn" class="table-btn view-btn">APPLY</button>
                                    </form>
                                </td>
                            </tr>
                            <?php
                        }
                    } else {
                        $_SESSION['error'] = "No programs found in the database";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

</div>

<!-- Dialogs -->
<dialog id="app-dialog" class="modal modal-app">
    <div class="modal-header">
        <h3>Add Application</h3>
        <button autofocus id="close-app-modal" class="close-modal-btn">&times;</button>
    </div>
    <form class="flex flex-col" action="../includes/process_applications.php" method="post">

        <input type="hidden" name="uin" value="<?php echo $_SESSION['user_id'] ?>">

        <label class="event-label margin-left-24" for="program-num">Program Number</label>
        <input class="modal-input" id="program-num" type="text" placeholder="Program Number" name="program_num" required>

        <label class="event-label margin-left-24" for="uncom-cert">Uncompleted Certifications</label>
        <textarea class="modal-text-area" id="uncom-cert" placeholder="Uncompleted Certifications" name="uncom_cert"></textarea>

        <label class="event-label margin-left-24" for="com-cert">Completed Certifications</label>
        <textarea class="modal-text-area" id="com-cert" placeholder="Completed Certifications" name="com_cert"></textarea>

        <label class="event-label margin-left-24" for="purpose-stmt">Purpose Statement</label>
        <textarea class="modal-text-area" id="purpose-stmt" placeholder="Purpose Statement" name="purpose_stmt" required></textarea>


        <button type="submit" class="add-btn center margin-top-10" name="add_app_btn">Add</button>
    </form>
</dialog>


<script>
    // Grabbing the application dialog and the open and close buttons
    const appDialog = document.getElementById('app-dialog');
    const openAppModal = document.getElementById('open-app-modal');
    const closeAppModal = document.getElementById('close-app-modal');

    openAppModal.addEventListener('click', () => {
        appDialog.showModal();
    });

    closeAppModal.addEventListener('click', () => {
        appDialog.close();
    });
</script>
<script src="../js/index.js"></script>

