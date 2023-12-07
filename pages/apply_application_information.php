<!-- WRITTEN BY: NAMSON PHAM
     UIN: 530003416
-->
<?php include '../assets/header.php';
include '../assets/student_navbar.php';
include_once '../includes/dbh.inc.php';
?>
<?php
    // Variables to store the application information
    $programNum = "";
    $programName = "";
    $programDesc = "";
    // If the view button is clicked, get the application id and display the application information
    // POST METHOD
    if (isset($_POST['apply_program_btn'])) {
        // Get the application id from the form
        $programNum = $_POST['apply_program_num'];
        // Get the program information
        // Prepare statement to prevent SQL injection
        $programStmt = $conn->prepare("SELECT * FROM programs WHERE Program_Num = ?");
        // Bind parameters to the statement
        $programStmt->bind_param("i", $programNum);
        // Execute the statement
        if ($programStmt->execute()) {
            // Get the result from the statement
            $programResult = $programStmt->get_result();
            $programStmt->close();
            // Store the program information in variables
            $data = $programResult->fetch_assoc();
            $programNum = $data['Program_Num'];
            $programName = $data['Name'];
            $programDesc = $data['Description'];
        }
    }
?>
<div class="main-container margin-left-280">
    <div class="header">
        <h2>Program Application Information</h2>
    </div>
    <form class="edit-form flex flex-col flex-start align-start" action="../includes/process_applications.php" method="post">

        <div class="flex align-center margin-top-10 margin-bot-10">
            <label class="event-label text-black font-size-l pd-10 font-weight-bold" for="program-num">Program Number: </label>
            <input class="font-size-l border-radius-12 width-auto text-align-center" id="program-num" type="text" placeholder="Program Number" name="program_num" value="<?php echo $programNum; ?>" disabled>
        </div>

        <div class="flex align-center margin-top-10 margin-bot-10">
            <label class="event-label text-black font-size-l pd-10 font-weight-bold" for="program-name">Program Name: </label>
            <input class="font-size-l border-radius-12 pd-20 width-1350px" id="program-name" type="text" placeholder="Program Name" name="program_name" value="<?php echo $programName; ?>" disabled>
        </div>

        <div class="flex align-center margin-top-10 margin-bot-10">
            <label class="event-label text-black font-size-l pd-10 font-weight-bold" for="program-desc">Program Description: </label>
            <textarea class="font-size-l border-radius-12 pd-20 width-1300px" id="program-desc" type="text" placeholder="Program Description" name="program_desc" disabled><?php echo $programDesc; ?></textarea>
        </div>

        <div class="flex align-center margin-top-10 margin-bot-10">
            <label class="event-label text-black font-size-l pd-10 font-weight-bold" for="uncom-cert">Uncompleted Certificates: </label>
            <textarea class="font-size-l border-radius-12 pd-20 width-1250px" id="uncom-cert" type="text" placeholder="Uncompleted Certificates" name="uncom_cert"></textarea>
        </div>

        <div class="flex align-center margin-top-10 margin-bot-10">
            <label class="event-label text-black font-size-l pd-10 font-weight-bold" for="com-cert">Completed Certificates: </label>
            <textarea class="font-size-l border-radius-12 pd-20 width-1275px" id="com-cert" type="text" placeholder="Completed Certificates" name="com_cert"></textarea>
        </div>

        <div class="flex align-center margin-top-10 margin-bot-10">
            <label class="event-label text-black font-size-l pd-10 font-weight-bold" for="purpose-statement">Purpose Statement: </label>
            <textarea class="font-size-l border-radius-12 pd-20 width-1315px" id="purpose-statement" type="text" placeholder="Purpose Statement" name="purpose_stmt" required></textarea>
        </div>

        <div class="flex space-between width-24">
            <input type="hidden" name="program_num" value="<?php echo $programNum; ?>">
            <input type="hidden" name="uin" value="<?php echo $_SESSION['user_id'] ?>">
            <button type="submit" class="add-btn margin-top-20" name="add_app_btn">Apply</button>
            <a href="application_information.php" class="cancel-btn margin-top-20">Back</a>
        </div>
    </form>
</div>